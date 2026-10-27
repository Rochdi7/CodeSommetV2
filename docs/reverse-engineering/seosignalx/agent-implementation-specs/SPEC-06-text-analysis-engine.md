# SPEC-06 — Text analysis engine: NLP keywords, n-grams, entities

Features: FEATURE-070, -071, -072. Phase **E**. Workflow: [../workflows/03-content-extraction-nlp-ngrams-entities.md](../workflows/03-content-extraction-nlp-ngrams-entities.md).

## 1. Objective
One server-side `TextAnalysis` engine, exposed through three tool views, that extracts key phrases, n-gram frequencies and entities from a URL or pasted text.

## 2. User stories
- As a writer, I paste a competitor URL and get its key phrases ranked by relevance.
- As an SEO, I compare the 1-, 2- and 3-gram densities of my page against a competitor's.
- As an SEO, I list the entities a page covers, with their type and salience.

## 3. Reference URLs
`/content/nlp`, `/content/ngrams`, `/content/entities-extractor`.

## 4. Evidence
The NLP, N-Grams and Entities valid, empty and malformed test rows in `test-matrix.csv` (PASS). Observed on example.com:

- NLP: 15 rows, `KEYWORD · RELEVANCE · TYPE · SENTIMENT`. Relevance values were 100% or 52%. Every row was `Concept`/`Neutral`.
- N-Grams: tabs `1-gram (12) · 2-gram (11) · 3-gram (10)`, columns `N-GRAM · COUNT · DENSITY`, with density = count / total tokens (1/12 = 8.33%).
- Entities: 7 rows, `ENTITY · TYPE · SALIENCE · MENTIONS`, every row `Concept` / 1.00.

**Inferred:** the reference uses heuristic tokenisation, not a trained model.

## 5. Functional requirements
1. Input mode is URL or Text (tabs). URL mode fetches through `SafeHttpFetcher` and extracts the main content: drop nav, header, footer, aside, script and style, and prefer `<main>`/`<article>`.
2. Language detection (fr/en/ar at least) with per-language stop-word lists.
3. Sentence segmentation. N-grams never cross sentence boundaries. This fixes the reference artefacts "service avoid" and "relying testing".
4. N-grams (n = 1..3) report count, density (count / tokens) and positions (first occurrence %).
5. Key phrases: score candidates with RAKE/YAKE-style statistics plus TF-IDF against a background corpus (*Recommendation*: our own blog corpus first). Normalise to a 0–100 relevance.
6. Entities have two modes:
   - (a) Heuristic: capitalised spans + gazetteer + schema.org `about`/`mentions`.
   - (b) Optional LLM classification into `Person`, `Organization`, `Place`, `Product`, `Concept`, `Event`, `Other`, with salience. Mode (b) requires login (SPEC-16) (*Decision required*, DR-3).
7. Competitor mode (Entities): up to 5 URLs. Output a matrix of entity presence per URL, highlighting entities competitors cover that you don't.
8. CSV export per table.

## 6. Non-functional requirements
Under 2 s for 5,000 words with heuristics only. Deterministic for identical input.

## 7. Input schema
```json
{"mode":"url|text","url":"https://…","text":"…","language":"auto|fr|en|ar","competitors":["https://…"]}
```

## 8. Output schema
```json
{"language":"en","tokens":25,"sentences":2,
 "ngrams":{"1":[{"gram":"domain","count":1,"density":0.04}],"2":[…],"3":[…]},
 "keyphrases":[{"phrase":"documentation examples","relevance":100,"count":1}],
 "entities":[{"name":"IANA","type":"Organization","salience":0.42,"mentions":2,"source":"heuristic|llm"}],
 "competitor_matrix":null}
```

## 9. UI behaviour
Tabs URL | Text. The button is disabled until there is input. Result tables are sortable and capped at 100 rows with "show all". Empty text → "No content found on this page" (not an empty table with 0 rows; the reference shows "(0)").

## 10. Backend behaviour
Synchronous for a single URL. Competitor mode is queued.

## 11. Database changes
None (results in `analysis_runs`).

## 12. External dependencies
None for the heuristics. Optional LLM via SPEC-16.

## 13. Validation rules
Text 20–100,000 characters. URL rules as in the conventions. A malformed URL → 422 before any fetch. The reference let it reach its proxy, which returned 400.

## 14. Error handling
`fetch_failed` with the HTTP status. `no_content` when the extracted text has fewer than 20 words.

## 15. Security
HTML is parsed with DOMDocument (no regex parsing). Output is escaped. No fetched HTML is stored beyond the run.

## 16. Accessibility
Tables have captions. Density is shown as a number, not by colour alone.

## 17. Test cases
- Fixture article (EN, FR, AR): known top bigrams and no cross-sentence n-grams.
- Stop-words removed per language.
- Density maths.
- Malformed URL → 422.
- A thin page → `no_content`.

## 18. Acceptance criteria
- All three views render from a single analysis call.
- Results are stable across runs.
- The FR fixture yields meaningful bigrams (e.g. "développement web"), not stop-word pairs.

## 19. Implementation dependencies
SPEC-01. SPEC-16 for LLM entity typing.

## 20. Known unknowns
The reference's relevance and sentiment model (U-03). We define our own.
