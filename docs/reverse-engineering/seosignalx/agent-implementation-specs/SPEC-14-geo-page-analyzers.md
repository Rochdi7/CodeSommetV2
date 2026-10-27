# SPEC-14 — GEO page analyzers: AI-readiness score, competitor GEO comparison, owned-content tone, prompt opportunities

Features: FEATURE-091, -093, -095, -097. Phase **C**. Workflow: [../workflows/05-geo-ai-search-tools.md](../workflows/05-geo-ai-search-tools.md).

## 1. Objective
Deterministic, explainable checks for how answer engines can parse and cite a page. They should be honest about not querying AI vendors (the reference states this for its sentiment and prompt tools).

## 2. User stories
- As an SEO, I get an AI-readiness score for a URL with the measured value behind each check.
- I compare my page against competitors on the same checks.
- I get content-planning prompt ideas derived from my page's topics.

## 3. Reference URLs
`/geo/ai-compatibility`, `/geo/competitor-research`, `/geo/brand-sentiment`, `/geo/prompt-tracking`.

## 4. Evidence
Valid tests (PASS) and the AI Compatibility malformed test (**FAIL** on the reference: it analysed `https://not a url ::`). Observed outputs:

- AI Compatibility: score 20 for example.com, 6 model buckets × 5 checks (listed in the workflow).
- Competitor: a table of GEO score, words, headings, internal links, topics and status. "Ten deterministic checks". Scores were 20 vs. 60.
- Sentiment: Neutral, 50/100, plus a page-facts checklist and next steps.
- Prompts: extracted topic trigrams, the fetched text, and templated prompts with a disclaimer.

## 5. Functional requirements

1. **Shared check pack `geo.v1`.** About 15 checks, each producing the check result shape from the conventions:

   | Check | Measures |
   |---|---|
   | Author signal | byline, `rel=author`, `Person` schema |
   | External citations | outbound links to authoritative domains, `<cite>`, footnotes |
   | Heading structure | H1 count, H2/H3 density per 300 words |
   | Lists and tables | count |
   | Question-led sections | headings ending in "?" or FAQ schema |
   | Answer-first paragraphs | first sentence after a heading under 30 words |
   | Readability | average sentence length; Flesch for EN/FR (Kandel-Moles) |
   | Content depth | word count bands |
   | Freshness | `dateModified`, visible date, `Last-Modified` header |
   | Structured data | JSON-LD present and valid types |
   | Meta basics | title, description, canonical, indexable |
   | Open Graph core fields | count |
   | Language and hreflang | — |
   | Image alt coverage | — |
   | Chunkability | words per section |

2. **AI-readiness score** = weighted pass rate (conventions formula). Show it as ONE score. Optional per-engine "lenses" are only allowed if each lens lists its check IDs and weights. Do not imply vendor-specific measurement (*Recommendation*; this fixes the reference's opacity).
3. **Competitor comparison:** 1 + up to 4 URLs, run the same pack, and return a side-by-side table plus the per-check pass matrix.
4. **Owned-content tone:** a lexicon-based tone score (positive/negative/hedging/sensational term lists per language) plus trust signals (contact, about, policies linked). Label it "Tone of this page", not "brand sentiment".
5. **Prompt opportunities:** topics = top key phrases from SPEC-06. Prompts are generated from templates (what/how/why/best/vs, FR and EN), with optional LLM rewriting (SPEC-16, logged-in only). Keep the reference's honest disclaimer.

## 6. Non-functional requirements
Under 5 s for a single URL. Comparison is queued. Deterministic output.

## 7. Input schema
`{"url":"https://…","competitors":["https://…"],"language":"auto"}`

## 8. Output schema
`{"score":62,"label":"Fair","checks":[CheckResult…],"lenses":[{"name":"Retrieval","check_ids":[…],"score":70}],"topics":[…],"prompts":[…],"tone":{"label":"Neutral","score":50,"signals":{"positive":[],"negative":[]}}}`

## 9. UI behaviour
Score gauge, check list with a measured value per row, filter All / Passed / Failed (observed), "How this score is calculated" disclosure, and New Analysis.

## 10. Backend behaviour
Reuse `App\Services\Analysis` analyzers (Meta, Schema, Structure and Accessibility already exist). Add `GeoAnalyzer` for the new checks.

## 11. Database changes
None.

## 12. External dependencies
None (the LLM is optional through SPEC-16).

## 13. Validation rules
**A strict URL validator before any processing.** The reference failed this.

## 14. Error handling
A thin page (under 50 words) gets a prominent "Page too thin to evaluate reliably" warning. The score is still shown but flagged.

## 15. Security
Standard SSRF guard.

## 16. Accessibility
The gauge has a text equivalent. Pass/fail is shown by icon plus text.

## 17. Test cases
- Fixture pages: a rich article (score ≥ 75), a thin page (≤ 30), an FAQ page (question check passes).
- Malformed URL → 422.
- Comparison of 3 URLs produces 3 columns.

## 18. Acceptance criteria
Every check shows its measured value. The score formula is visible in the UI. The malformed-URL case is rejected.

## 19. Implementation dependencies
SPEC-01, SPEC-06 (topics).

## 20. Known unknowns
The reference's weights and its "per-model" mapping (U-03). Intentionally not replicated.
