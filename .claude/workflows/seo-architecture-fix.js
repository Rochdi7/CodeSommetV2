export const meta = {
  name: 'seo-architecture-fix',
  description: 'Post-implementation SEO audit: measure current link graph, fix geo-linking bug, differentiate cannibalizing content, re-validate',
  phases: [
    { title: 'Analysis' },
    { title: 'Lead Architect Review' },
    { title: 'Implement' },
    { title: 'Validate' },
  ],
}

const ROOT = 'c:\\Users\\ASUS\\Desktop\\pikasso studio\\pikassostudio.com'

// Confirmed by direct inspection before this workflow: hardcoded (not a shared partial) Gulf-cities
// block (abudhabi/doha/kuwait-city/riyadh) copy-pasted into these 15 city files, layered ON TOP of
// already-correct geo-relevant links from a prior audit (e.g. casablanca already links marrakech/
// rabat/tangier). doha and kuwait-city routes do not exist (config/pages.php whitelist) — dead links.
const GULF_BLOCK_FILES = [
  'abudhabi', 'barcelona', 'cairo', 'casablanca', 'dubai', 'lagos', 'lisbon', 'madrid',
  'marrakech', 'milan', 'rabat', 'riyadh', 'rome', 'tangier', 'tunis',
].map(c => `resources/views/frontoffice/pages/locations/web-development-company-${c}.blade.php`)

const CANNIBALIZATION_PAIRS = [
  { pair: ['telemedicine-platform-development', 'telemedicine-website-development'], note: 'C1 from prior audit: body copy (FAQ/features/testimonials) confirmed near word-for-word identical, incl. a copy-paste leftover FAQ on the "website" page asking about a "plateforme". Cross-links were added; content itself was NOT differentiated — this is the primary target of this run.' },
  { pair: ['edtech-platform-development', 'elearning-platform-development', 'education-website-development'], note: 'C2 from prior audit: secondary_keywords near-identical verbatim across all three. Cross-links added; content/keyword differentiation NOT done.' },
  { pair: ['domain-authority-checker', 'domain-health-checker'], note: 'C3 from prior audit: both run the same 6-check technical methodology; "Domain Authority" conventionally means Moz backlink data (already correctly served by backlink-checker), making the name a mislabeling.' },
  { pair: ['website-analyzer', 'website-readiness-checker'], note: 'C4 from prior audit: both are lead-gen audit tools for the same audience with overlapping category coverage.' },
  { pair: ['fintech-platform-development', 'fintech-website-development'], note: 'Partial overlap in prior audit — cleanest of the duplicated-name pairs, re-verify only.' },
  { pair: ['page-speed-analyzer', 'core-web-vitals-checker'], note: 'Partial overlap in prior audit — re-verify only.' },
  { pair: ['healthcare-website-development', 'telemedicine-platform-development'], note: 'Review-required in prior audit — healthcare page title/meta mentions télémédecine.' },
  { pair: ['study-abroad-website-development', 'immigration-consultancy-website-development'], note: 'Healthy overlap in prior audit, keep_both — re-verify only.' },
  { pair: ['education-website-development', 'university-website-development'], note: 'Review-required in prior audit — insufficient data on university page at the time.' },
  { pair: ['web-development-company-worldwide', 'locations'], note: 'Review-required in prior audit — near-identical H1 framing, insufficient SERP data.' },
]

// ─── Phase 1: Analysis (all read-only, run in parallel, independent) ─────────

const INVENTORY_SCHEMA = {
  type: 'object',
  properties: {
    pages: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          slug: { type: 'string' }, file: { type: 'string' }, url: { type: 'string' },
          h1: { type: 'string' }, title: { type: 'string' }, meta_description: { type: 'string' },
          primary_keyword: { type: 'string' }, secondary_keywords: { type: 'array', items: { type: 'string' } },
          search_intent: { type: 'string' }, business_tier: { type: 'string' },
          major_topics: { type: 'array', items: { type: 'string' } },
          existing_contextual_inbound_links: { type: 'array', items: { type: 'string' } },
          existing_contextual_outbound_links: { type: 'array', items: { type: 'string' } },
          related_pages: { type: 'array', items: { type: 'string' } },
        },
        required: ['slug', 'file', 'url', 'primary_keyword', 'business_tier'],
      },
    },
  },
  required: ['pages'],
}

function inventoryPrompt(groupName, fileGlobHint) {
  return `Fresh site inventory pass on the Laravel/Blade site codesommet.com at "${ROOT}". This is a POST-IMPLEMENTATION audit — a prior pass already added 142 contextual internal links across 94 files (committed at git commit 36aacc3). Do NOT assume prior findings are still accurate; read the CURRENT file content.

Inventory the "${groupName}" section: ${fileGlobHint}. Read each Blade file (and its paired lang/fr/*.php file where title/H1/meta/body text is stored via __() calls, not hardcoded).

For each page report: slug, file, url, h1, title, meta_description, primary_keyword, secondary_keywords, search_intent, business_tier (tier1_primary_money / tier2_secondary_commercial / tier3_supporting / tier5_utility), major_topics, existing_contextual_inbound_links (links you can find INTO this page from elsewhere — best-effort, may be incomplete from a single page read), existing_contextual_outbound_links (every internal href/route() link found in this page's BODY content, excluding header/footer/nav partials), related_pages (other pages this content is thematically connected to, reasoned from actual content).

Call StructuredOutput with a pages array.`
}

async function runInventory() {
  phase('Analysis')
  const groups = [
    { name: 'core+legal', hint: 'resources/views/frontoffice/pages/{home,about,contact,get-quote,our-work,industries,locations,tools}.blade.php and legal/*.blade.php (13 files)' },
    { name: 'services-A', hint: 'resources/views/frontoffice/pages/services/*.blade.php, first 8 alphabetically' },
    { name: 'services-B', hint: 'resources/views/frontoffice/pages/services/*.blade.php, remaining 8 alphabetically' },
    { name: 'cities-A', hint: 'resources/views/frontoffice/pages/locations/*.blade.php, first 18 alphabetically (includes worldwide)' },
    { name: 'cities-B', hint: 'resources/views/frontoffice/pages/locations/*.blade.php, remaining 17 alphabetically' },
    { name: 'tools-A', hint: 'resources/views/frontoffice/pages/tools/*.blade.php, first 22 alphabetically' },
    { name: 'tools-B', hint: 'resources/views/frontoffice/pages/tools/*.blade.php, remaining 22 alphabetically' },
    { name: 'case-studies', hint: 'resources/views/frontoffice/pages/our-work/*.blade.php (6 files)' },
  ]
  const results = await parallel(groups.map(g => async () => {
    const r = await agent(inventoryPrompt(g.name, g.hint), { label: `inventory:${g.name}`, phase: 'Analysis', schema: INVENTORY_SCHEMA })
    return r ? r.pages : []
  }))
  const allPages = results.flat()
  log(`Fresh inventory: ${allPages.length} pages catalogued.`)
  return allPages
}

const CANNIB_SCHEMA = {
  type: 'object',
  properties: {
    findings: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          pair: { type: 'array', items: { type: 'string' } },
          primary_url: { type: 'string' }, supporting_url: { type: 'string' },
          search_intent_each: { type: 'string' },
          what_each_should_own: { type: 'string' },
          current_conflict: { type: 'string' },
          exact_conflicting_content: { type: 'string' },
          recommended_change: { type: 'string' },
          risk: { type: 'string' },
          still_cannibalizing: { type: 'boolean' },
        },
        required: ['pair', 'current_conflict', 'recommended_change', 'still_cannibalizing'],
      },
    },
  },
  required: ['findings'],
}

async function runCannibalizationSpecialist() {
  const r = await agent(
    `You are the Cannibalization Specialist for a post-implementation SEO re-audit of codesommet.com (Laravel/Blade). A prior audit (committed, git commit 36aacc3) already found and partially mitigated (via cross-links only, NOT content rewrites) these pairs:

${JSON.stringify(CANNIBALIZATION_PAIRS, null, 2)}

Independently re-read the CURRENT actual content (title, H1, meta description, primary/secondary keywords, intro, headings, body copy, FAQs, CTA) of every page in every pair above, plus check these additional pairs the task requires verifying: fintech platform vs fintech website, page speed vs Core Web Vitals, healthcare vs telemedicine, study abroad vs immigration consultancy, university vs education, worldwide vs locations, and any city pages with similar vertical positioning you notice (e.g. San Francisco/Austin/Denver on SaaS-startup framing, Chicago/New York on fintech framing — check if these are still an issue).

For each pair, determine whether body content still genuinely conflicts (not just whether a cross-link exists — a link does not fix content-level cannibalization). Report: pair (array of slugs), primary_url, supporting_url, search_intent_each, what_each_should_own, current_conflict (be specific — quote or closely paraphrase the actual overlapping text you found), exact_conflicting_content, recommended_change, risk, and still_cannibalizing (true if the underlying content problem is unresolved, false if it's actually fine).

Do NOT recommend consolidation, redirects, or deletion — only content differentiation or "no action needed" if you find the pair is actually fine. Be skeptical of the prior audit's findings; verify against current file content, don't just repeat them.

Call StructuredOutput with a findings array.`,
    { label: 'cannibalization-specialist', phase: 'Analysis', schema: CANNIB_SCHEMA, effort: 'high' }
  )
  return r ? r.findings : []
}

const LINK_GRAPH_SCHEMA = {
  type: 'object',
  properties: {
    per_page: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          url: { type: 'string' },
          contextual_inbound_count: { type: 'number' },
          contextual_outbound_count: { type: 'number' },
          is_orphan: { type: 'boolean' },
          is_weak: { type: 'boolean' },
          is_overlinked: { type: 'boolean' },
          is_tier1_with_zero_inbound: { type: 'boolean' },
        },
        required: ['url'],
      },
    },
    orphan_pages: { type: 'array', items: { type: 'string' } },
    weak_pages: { type: 'array', items: { type: 'string' } },
    overlinked_pages: { type: 'array', items: { type: 'string' } },
    tier1_zero_inbound: { type: 'array', items: { type: 'string' } },
    hub_to_spoke_count: { type: 'number' },
    spoke_to_hub_count: { type: 'number' },
    service_to_city_count: { type: 'number' },
    city_to_service_count: { type: 'number' },
    tool_to_service_count: { type: 'number' },
    case_study_to_service_count: { type: 'number' },
    summary_notes: { type: 'string' },
  },
  required: ['orphan_pages', 'weak_pages', 'overlinked_pages', 'tier1_zero_inbound'],
}

async function runLinkGraphSpecialist(inventory) {
  const r = await agent(
    `You are the Internal Linking Graph Specialist. A prior audit's final report explicitly stated: "Orphan/weak/overlinked recount post-implementation — NOT MEASURED." You must measure it now, for real, from current file content.

You have a fresh page inventory (JSON below) including each page's existing_contextual_outbound_links (found by reading each page individually). Build the link graph: for every page, count contextual INBOUND links (how many other pages' outbound-link lists reference it) and contextual OUTBOUND links (from its own list). Only count links found in BODY content — the inventory data already excludes header/footer/nav, so trust it, but sanity-check for obvious double-counting (e.g. the same link listed twice in one page's outbound list).

Classify:
- orphan_pages: zero contextual inbound links from anywhere
- weak_pages: fewer than 2 contextual inbound links
- overlinked_pages: pages receiving links from many source pages via what looks like the same repeated boilerplate anchor/pattern rather than genuinely distinct contextual mentions (use the inventory's related_pages/major_topics to judge whether inbound links look organic or templated)
- tier1_zero_inbound: business_tier=tier1_primary_money pages with zero contextual inbound links (this is the most severe finding category)

Also count (best-effort from the data given): hub_to_spoke_count (links from /industries or /locations to their spoke pages), spoke_to_hub_count (reverse), service_to_city_count, city_to_service_count, tool_to_service_count, case_study_to_service_count.

FRESH INVENTORY (113 pages):
${JSON.stringify(inventory)}

Call StructuredOutput with per_page (array), orphan_pages, weak_pages, overlinked_pages, tier1_zero_inbound, the cross-type link counts, and summary_notes explaining any measurement caveats.`,
    { label: 'link-graph-specialist', phase: 'Analysis', schema: LINK_GRAPH_SCHEMA, effort: 'high' }
  )
  return r
}

const GEO_AUDIT_SCHEMA = {
  type: 'object',
  properties: {
    confirmed_files_with_gulf_block: { type: 'array', items: { type: 'string' } },
    dead_links_found: { type: 'array', items: { type: 'string' } },
    architecture_design: { type: 'string' },
    per_file_fix_plan: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          file: { type: 'string' },
          city: { type: 'string' },
          links_to_remove: { type: 'array', items: { type: 'string' } },
          links_to_keep: { type: 'array', items: { type: 'string' } },
          links_to_add: { type: 'array', items: { type: 'string' } },
          rationale: { type: 'string' },
        },
        required: ['file', 'links_to_remove'],
      },
    },
  },
  required: ['confirmed_files_with_gulf_block', 'per_file_fix_plan'],
}

async function runGeoArchitectureSpecialist() {
  const r = await agent(
    `You are the Geographic Architecture Specialist for codesommet.com. IMPORTANT CORRECTION to what you might assume: a previous investigation already confirmed the "Nous Servons Également" nearby-cities block on city pages is NOT a shared partial/component — it is HARDCODED HTML copy-pasted individually into each of these 15 files:

${JSON.stringify(GULF_BLOCK_FILES)}

Each contains leftover links to abudhabi/doha/kuwait-city/riyadh regardless of actual geography. doha and kuwait-city do not exist as routes (removed from config/pages.php whitelist previously) — confirmed dead links (404). A PRIOR audit already added CORRECT geo-relevant links to some of these same files (e.g. casablanca.blade.php already links to marrakech/rabat/tangier; barcelona already links to lisbon; lagos/tunis already link to cairo) — verify this is still true by reading each file, and do NOT remove those already-correct links.

Your job: for EACH of the 15 files listed above, read the file, find the exact Gulf-block links (route('location', 'doha'), route('location', 'kuwait-city'), and any route('location', 'abudhabi')/route('location', 'riyadh') links that are NOT geographically relevant to that specific city), and produce a per_file_fix_plan entry: file path, city slug, links_to_remove (the irrelevant/dead route() calls verbatim, e.g. "route('location', 'doha')"), links_to_keep (any Gulf-cluster link that IS legitimate — e.g. abudhabi.blade.php linking to dubai/riyadh IS geographically correct and should be kept; dubai linking to abudhabi/riyadh is also legitimate), links_to_add (only if you find a genuinely missing same-region link with no existing legitimate replacement — do not force one if the city already has 2+ good geo-links), and rationale.

Design principle (document in architecture_design, a short paragraph): group cities by actual region (Morocco: casablanca/marrakech/rabat/tangier; Gulf: dubai/abudhabi/riyadh; Europe: london/amsterdam/berlin/paris/copenhagen/dublin/brussels/zurich/stockholm/madrid/barcelona/lisbon/rome/milan; North America: new-york/san-francisco/los-angeles/austin/seattle/boston/chicago/denver/toronto/vancouver; Africa/MENA: tunis/cairo/lagos) and each city page's "nearby cities" links should stay within its own region (2-4 links), never cross into an unrelated region. Since there is no shared component to fix centrally, this requires per-file edits — that is expected and correct, not a workaround.

Verify every dead_links_found (doha/kuwait-city) actually don't resolve — check config/pages.php's cities whitelist and confirm no view exists at resources/views/frontoffice/pages/locations/web-development-company-doha.blade.php or -kuwait-city.blade.php.

Call StructuredOutput with confirmed_files_with_gulf_block, dead_links_found, architecture_design, and per_file_fix_plan (one entry per file, 15 total).`,
    { label: 'geo-architecture-specialist', phase: 'Analysis', schema: GEO_AUDIT_SCHEMA, effort: 'high' }
  )
  return r
}

const TOOL_AUDIT_SCHEMA = {
  type: 'object',
  properties: {
    tool_findings: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          tool: { type: 'string' },
          current_purpose: { type: 'string' },
          overlaps_with: { type: 'array', items: { type: 'string' } },
          has_unique_purpose: { type: 'boolean' },
          naming_accurate: { type: 'boolean' },
          recommended_action: { type: 'string' },
          safe_to_rename: { type: 'boolean' },
          risk_if_renamed: { type: 'string' },
        },
        required: ['tool', 'current_purpose', 'has_unique_purpose', 'recommended_action'],
      },
    },
  },
  required: ['tool_findings'],
}

async function runToolArchitectureSpecialist() {
  const r = await agent(
    `You are the Tool Architecture Specialist for codesommet.com's free SEO tools section. Inspect these tool pages by reading their actual current content (resources/views/frontoffice/pages/tools/{slug}.blade.php and paired lang/fr/tools/{slug}.php):

domain-authority-checker, domain-health-checker, website-analyzer, website-readiness-checker, page-speed-analyzer, core-web-vitals-checker, backlink-checker.

For domain-authority-checker specifically: verify whether its actual current implementation/copy measures real Domain Authority (a Moz backlink-based metric) or just runs a generic technical checklist (HTTPS/SSL/sitemap/robots.txt/WWW-redirect). If it's the latter, this is a mislabeling — recommend a content/title/H1/meta correction that repositions it honestly (e.g. reframe around "technical domain health score" rather than "Domain Authority", since backlink-checker already correctly serves the real DA/PA/Moz-data intent). Only recommend a slug/route rename if you can confirm no external backlinks/bookmarks would break AND it's genuinely necessary — a content/copy fix without a route change is strongly preferred and almost certainly sufficient; flag route renames as high-risk requiring a redirect strategy, and prefer NOT recommending one unless the mislabeling is severe enough that copy alone can't fix it.

For website-analyzer vs website-readiness-checker: confirm/strengthen the existing differentiation (analyzer = comprehensive 40+-point audit; readiness-checker = quick 14-point pre-launch check) is clear in the CURRENT copy (H1, intro, feature list) — if a prior audit already added a cross-link, verify the anchor text actually explains the distinction, not just a generic link.

For fintech-platform/fintech-website, page-speed/core-web-vitals: quick re-verification only — are they still healthy/differentiated per the prior audit's classification, or has something regressed?

For each tool, report: current_purpose, overlaps_with (other tool slugs), has_unique_purpose, naming_accurate, recommended_action (be specific: "no change" / "add clarifying line to H1/intro" / "reposition meta_description away from X framing" / "rename slug — requires redirect, high risk"), safe_to_rename, risk_if_renamed.

Call StructuredOutput with tool_findings array.`,
    { label: 'tool-architecture-specialist', phase: 'Analysis', schema: TOOL_AUDIT_SCHEMA, effort: 'high' }
  )
  return r ? r.tool_findings : []
}

// ─── Phase 2: Lead Architect Review ───────────────────────────────────────

const ARCHITECT_SCHEMA = {
  type: 'object',
  properties: {
    approved_changes: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          category: { type: 'string', enum: ['geo_link_fix', 'content_differentiation_telemedicine', 'content_differentiation_education', 'tool_repositioning', 'technical_cleanup', 'internal_link'] },
          target_file: { type: 'string' },
          description: { type: 'string' },
          classification: { type: 'string', enum: ['FIX_NOW', 'FIX_AFTER_REVIEW', 'DO_NOT_CHANGE'] },
          reasoning: { type: 'string' },
        },
        required: ['category', 'target_file', 'description', 'classification', 'reasoning'],
      },
    },
    rejected_or_deferred: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          description: { type: 'string' },
          why_not_fixed: { type: 'string' },
          decision_required: { type: 'string' },
          recommended_decision: { type: 'string' },
        },
      },
    },
  },
  required: ['approved_changes'],
}

async function runLeadArchitect(cannibFindings, linkGraph, geoAudit, toolAudit) {
  phase('Lead Architect Review')
  const r = await agent(
    `You are the Lead SEO Architect reviewing findings from 4 independent specialist agents before any implementation happens on codesommet.com (a live production Laravel site). Your job is to resolve contradictions, reject speculative changes, prioritize, and produce the ONLY list of changes implementation agents are allowed to make.

Classify every proposed change as FIX_NOW (safe, clearly justified, low risk — implement this run), FIX_AFTER_REVIEW (needs a human/business decision first — do not implement), or DO_NOT_CHANGE (not actually a problem, or too risky without more evidence).

Hard constraints you must enforce:
- Never approve consolidating, redirecting, deleting, or canonicalizing a page.
- Never approve a route/slug rename unless the specialist explicitly marked it safe_to_rename=true AND described a concrete redirect strategy — otherwise mark FIX_AFTER_REVIEW.
- For content-differentiation changes (telemedicine, EdTech/e-learning/education): only approve FIX_NOW if the change is rewriting/trimming existing duplicate sections to reflect genuinely different intent — reject any change that sounds like "replace the word X with Y" without an actual intent shift, per the task's explicit rule.
- For the geo-linking fix: approve removing confirmed-dead links (doha/kuwait-city) and confirmed-irrelevant Gulf links FIX_NOW (low risk, mechanical, evidence is strong). Do NOT approve adding speculative new geo-links beyond what the geo specialist's per_file_fix_plan already justified.
- Deduplicate: if two specialists proposed overlapping or contradictory changes to the same file, resolve it into ONE approved_changes entry, not two.
- For anything you classify DO_NOT_CHANGE or FIX_AFTER_REVIEW, add a corresponding entry to rejected_or_deferred explaining why_not_fixed, decision_required, and recommended_decision (your best recommendation, but framed as a recommendation, not an implemented decision).

CANNIBALIZATION SPECIALIST FINDINGS:
${JSON.stringify(cannibFindings)}

LINK GRAPH SPECIALIST FINDINGS:
${JSON.stringify(linkGraph)}

GEO ARCHITECTURE SPECIALIST FINDINGS:
${JSON.stringify(geoAudit)}

TOOL ARCHITECTURE SPECIALIST FINDINGS:
${JSON.stringify(toolAudit)}

Call StructuredOutput with approved_changes (every FIX_NOW/FIX_AFTER_REVIEW/DO_NOT_CHANGE item, one per concrete change) and rejected_or_deferred (detail for every FIX_AFTER_REVIEW/DO_NOT_CHANGE item).`,
    { label: 'lead-architect', phase: 'Lead Architect Review', schema: ARCHITECT_SCHEMA, effort: 'high' }
  )
  return r
}

// ─── Phase 3: Implementation (only FIX_NOW items, grouped by file) ───────

const IMPL_SCHEMA = {
  type: 'object',
  properties: {
    file_edited: { type: 'string' },
    changes_made: { type: 'array', items: { type: 'string' } },
    changes_skipped: { type: 'array', items: { type: 'string' } },
    summary: { type: 'string' },
  },
  required: ['file_edited', 'summary'],
}

async function runImplementation(approvedChanges) {
  phase('Implement')
  const fixNow = approvedChanges.filter(c => c.classification === 'FIX_NOW' && c.target_file)
  const byFile = {}
  for (const c of fixNow) {
    if (!byFile[c.target_file]) byFile[c.target_file] = []
    byFile[c.target_file].push(c)
  }
  const entries = Object.entries(byFile)
  log(`Implementing ${fixNow.length} FIX_NOW changes across ${entries.length} files...`)

  const results = await parallel(entries.map(([file, changes]) => async () => {
    return agent(
      `Apply the following Lead-Architect-approved changes to "${file}" in the codesommet.com Laravel project at root "${ROOT}". This file may pull text from a paired lang/fr/*.php file via __() — check both, edit whichever actually contains the target text.

APPROVED CHANGES (all FIX_NOW, already reviewed — implement exactly, do not add anything beyond this list):
${JSON.stringify(changes, null, 2)}

Rules:
- For geo_link_fix category: remove exactly the specified dead/irrelevant route('location', 'X') links and their surrounding <a> card markup cleanly (don't leave broken HTML structure). Keep everything else on the page untouched.
- For content_differentiation category: rewrite/trim the described section so it reflects a genuinely different search intent per the description — this may mean removing a duplicated paragraph, rewriting an FAQ answer, or adjusting feature-list emphasis. Do NOT just do a word-substitution (e.g. "platform"→"website") — the actual meaning/audience framing must change per the description. Preserve all HTML structure, Tailwind classes, and translated-language integrity (French stays French).
- For tool_repositioning category: only touch title/H1/meta_description/intro copy as described — do not change routes/slugs unless the description explicitly says so with a stated redirect plan.
- For technical_cleanup category: fix exactly the described defect (e.g. mojibake encoding, English-only content, dead links) and nothing else.
- For internal_link category: add/modify exactly the described link with natural French anchor text.
- Never touch anything not explicitly listed above.

After editing, call StructuredOutput with file_edited, changes_made (list what you did), changes_skipped (anything you couldn't safely do and why), and summary.`,
      { label: `implement:${file.split('/').pop()}`, phase: 'Implement', schema: IMPL_SCHEMA, isolation: 'worktree' }
    )
  }))
  return results.filter(Boolean)
}

// ─── Phase 4: Fresh Validation ────────────────────────────────────────────

const VALIDATION_SCHEMA = {
  type: 'object',
  properties: {
    broken_internal_links: { type: 'array', items: { type: 'string' } },
    dead_links_remaining: { type: 'array', items: { type: 'string' } },
    routes_verified_ok: { type: 'boolean' },
    blade_compiles: { type: 'boolean' },
    tests_passed: { type: 'boolean' },
    test_output_summary: { type: 'string' },
    cannibalization_recheck: { type: 'string' },
    notes: { type: 'string' },
  },
}

async function runValidation(implementationResults) {
  phase('Validate')
  const editedFiles = implementationResults.map(r => r.file_edited).filter(Boolean)
  const r = await agent(
    `You are validating changes just made to codesommet.com (Laravel project at root "${ROOT}"). This is a FRESH, independent validation — do not reuse numbers from any prior audit report.

Files edited in this run: ${JSON.stringify(editedFiles)}

Do the following:
1. Grep every edited file for route(' calls, verify every route name+slug pair resolves against routes/web.php and config/pages.php whitelists. Specifically confirm the confirmed-dead doha/kuwait-city links no longer appear anywhere in the codebase (grep the full resources/views/frontoffice tree, not just edited files).
2. Run 'php artisan view:clear' then 'php artisan view:cache' — report whether Blade compiles with 0 errors.
3. Run the project's test suite (composer test or php artisan test) — report pass/fail counts. If RenderSnapshotTest fails, check whether the failure is because of THIS run's changes (compare against what changed) vs a pre-existing unrelated snapshot mismatch (e.g. check if unedited pages also fail with the same message pattern) — do NOT blindly run --update-snapshots; only note if a fixture update is warranted and why.
4. For the telemedicine and EdTech/e-learning/education pages (if they were edited in this run), spot-check that the body content genuinely reads differently now (not just a word swap) — quote a short before/after-feeling excerpt if you can tell from git diff.
5. Report dead_links_remaining: any route('location', 'doha') or route('location', 'kuwait-city') still found anywhere in resources/views/frontoffice/.

Call StructuredOutput with broken_internal_links, dead_links_remaining, routes_verified_ok, blade_compiles, tests_passed, test_output_summary, cannibalization_recheck (your assessment of whether the content differentiation changes look substantive), and notes.`,
    { label: 'fresh-validation', phase: 'Validate', schema: VALIDATION_SCHEMA, effort: 'high' }
  )
  return r
}

// ─── Main ──────────────────────────────────────────────────────────────────

const [inventory, cannibFindings, geoAudit, toolAudit] = await parallel([
  () => runInventory(),
  () => runCannibalizationSpecialist(),
  () => runGeoArchitectureSpecialist(),
  () => runToolArchitectureSpecialist(),
])

const linkGraph = await runLinkGraphSpecialist(inventory)

const architectReview = await runLeadArchitect(cannibFindings, linkGraph, geoAudit, toolAudit)
const approvedChanges = architectReview ? architectReview.approved_changes : []

const implementationResults = await runImplementation(approvedChanges)
const validation = await runValidation(implementationResults)

return {
  inventory,
  cannibFindings,
  linkGraph,
  geoAudit,
  toolAudit,
  architectReview,
  implementationResults,
  validation,
}
