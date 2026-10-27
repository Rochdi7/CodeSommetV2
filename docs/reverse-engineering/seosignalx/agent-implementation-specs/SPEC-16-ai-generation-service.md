# SPEC-16 — AI generation service (entities, lexical relations, co-occurring words, unique n-grams, outline merge)

Features: FEATURE-073, -074, -075, -071 (generation part), -076, -097 (optional). Phase **F**. Workflow: [../workflows/04-ai-generation-tools-anonymous-fallback.md](../workflows/04-ai-generation-tools-anonymous-fallback.md).

## 1. Objective
One LLM-backed service with schema-validated JSON outputs that powers the content-ideation tools. Results must be clearly AI-generated and never silently replaced by templates.

## 2. User stories
- As a writer, I enter a topic and get related entities, synonyms, hyponyms, meronyms and similar, grouped and copyable.
- I merge the heading outlines of 3 competitor URLs into one recommended outline.

## 3. Reference URLs
`/content/entities-generator`, `/content/grammar`, `/content/skip-gram`, `/content/unique-ngrams`, `/content/outline`.

## 4. Evidence
For anonymous users all of these call `/api/deepseek` → 401 "Missing Firebase auth token" and render **template fallbacks** (test rows BLOCKED). Observed output *shapes* for Grammar ("Laptop"): 8 groups (proper nouns, common nouns, synonyms, antonyms, hyponyms, hypernyms, meronyms, holonyms), 37 words, Copy all per group and Export All. Unique n-grams: 8 numbered phrases. Entities generator: about 15 entities per keyword. Outline: an extracted H1–H6 tree per source, then "AI Combine". Real AI output was **not verified**.

## 5. Functional requirements
1. `LlmGenerationService::generate(string $task, array $input, string $locale): array`. Each task has a versioned prompt template and a JSON schema.
2. Tasks:

   | Task | Output |
   |---|---|
   | `entities` | keywords[] → per keyword `[{name, type, why}]`, 10–20 each |
   | `lexical_relations` | topic → the 8 groups above, 3–8 items each |
   | `cooccurrence` | word → `[{word, sense}]`, grouped by word sense (disambiguation is the stated purpose) |
   | `unique_ngrams` | topic → 8–12 original 3–6-word phrases plus a rationale |
   | `outline_merge` | outlines[] → merged outline with source attribution per heading |

3. Use the Anthropic Messages API with structured output (tool use / JSON schema). Model `claude-haiku-5-5` for the classification-like tasks and `claude-sonnet-5-5` for `outline_merge` (*Recommendation*, DR-3).
4. Validate the output against the schema. On failure, retry once, then return a `provider_error`. **No template fallback.**
5. Cache by `(task, normalised input, locale, prompt_version)` for 30 days.
6. Access: logged-in users only, with N free generations per day on the Free plan (DR-5). Anonymous users get a "Sign in to generate" state instead of fake output.

## 6. Non-functional requirements
P95 under 10 s. Cost is logged per call (input and output tokens) to `provider_usage`.

## 7. Input schema
`{"task":"lexical_relations","input":{"topic":"Laptop"},"locale":"fr"}`

## 8. Output schema
`{"task":"lexical_relations","groups":[{"key":"hyponyms","label":"Hyponyms","items":["ultrabook","gaming laptop"]}],"model":"claude-haiku-5-5","cached":false}`

## 9. UI behaviour
Example chips fill the input (observed pattern). Results appear in grouped cards with copy and export. An "AI-generated, review before use" note is shown.

## 10. Backend behaviour
Synchronous with a 20 s timeout. Queued for `outline_merge` with more than 3 URLs (fetching plus generation).

## 11. Database changes
`llm_cache(hash PK, task, payload json, model, prompt_version, created_at)`, `provider_usage(id, user_id, provider, task, units, cost_micros, created_at)`.

## 12. External dependencies
Claude API (load the `claude-api` skill before implementing).

## 13. Validation rules
Topic 2–80 characters. Keywords ≤ 20 per run. Outline URLs 1–5.

## 14. Error handling
`provider_error`, `quota_exceeded`, `login_required` (with a CTA).

## 15. Security
Prompt-injection defence: fetched competitor HTML is passed as quoted data, never as instructions, and the model output is schema-validated. API keys are server-side only.

## 16. Accessibility
Standard requirements.

## 17. Test cases
Fake the client: schema-valid response → render; invalid JSON → retry then error; anonymous → 401 `login_required` (no fallback); cache hit → no API call.

## 18. Acceptance criteria
No code path returns template output that pretends to be AI. Each task has a JSON schema and a prompt version.

## 19. Implementation dependencies
SPEC-01, accounts (FEATURE-001).

## 20. Known unknowns
The reference's prompts and model behaviour (the DeepSeek endpoint is inferred). Pricing and free quota (DR-5).
