export const meta = {
  name: 'internal-linking-audit',
  description: 'Full-site internal linking + keyword cannibalization audit and fix for codesommet.com',
  phases: [
    { title: 'Inventory' },
    { title: 'Topical Map & Cannibalization' },
    { title: 'Linking Plan' },
    { title: 'Implement' },
    { title: 'Validate' },
  ],
}

const ROOT = 'c:\\Users\\ASUS\\Desktop\\pikasso studio\\pikassostudio.com'

const PAGE_GROUPS = {
  core: ['home', 'about', 'contact', 'get-quote', 'our-work', 'industries', 'locations', 'tools'],
  legal: ['privacy-policy', 'terms-of-service', 'refund-policy', 'cookie-policy', 'acceptable-use'],
  services: [
    'ecommerce-website-development', 'edtech-platform-development', 'education-website-development',
    'elearning-platform-development', 'fintech-platform-development', 'fintech-website-development',
    'healthcare-website-development', 'immigration-consultancy-website-development',
    'language-school-website-development', 'online-course-platform-development',
    'real-estate-website-development', 'saas-platform-development', 'study-abroad-website-development',
    'telemedicine-platform-development', 'telemedicine-website-development', 'university-website-development',
  ],
  cities: [
    'worldwide', 'casablanca', 'marrakech', 'rabat', 'tangier', 'dubai', 'abudhabi', 'riyadh',
    'london', 'amsterdam', 'berlin', 'paris', 'copenhagen', 'dublin', 'brussels', 'zurich', 'stockholm',
    'madrid', 'barcelona', 'lisbon', 'rome', 'milan', 'new-york', 'san-francisco', 'los-angeles', 'austin',
    'seattle', 'boston', 'chicago', 'denver', 'toronto', 'vancouver', 'tunis', 'cairo', 'lagos',
  ],
  tools: [
    'backlink-checker', 'base64-encoder', 'blog-title-generator', 'broken-link-checker', 'canonical-checker',
    'chatbot-script-generator', 'color-palette-generator', 'core-web-vitals-checker', 'css-minifier',
    'domain-authority-checker', 'domain-health-checker', 'duplicate-content-checker', 'faq-schema-generator',
    'heading-analyzer', 'hreflang-generator', 'html-minifier', 'html-to-text', 'image-alt-analyzer',
    'image-compression-analyzer', 'internal-link-analyzer', 'json-formatter', 'keyword-density-analyzer',
    'landing-page-generator', 'local-business-schema', 'lorem-ipsum-generator', 'meta-refresh-generator',
    'meta-tag-generator', 'mobile-friendly-test', 'nofollow-link-checker', 'og-preview-generator',
    'page-speed-analyzer', 'qr-code-generator', 'readability-analyzer', 'redirect-checker',
    'robots-txt-generator', 'robots-validator', 'schema-generator', 'sitemap-validator',
    'ssl-certificate-checker', 'text-case-converter', 'url-slug-generator', 'utm-builder',
    'website-analyzer', 'website-readiness-checker', 'word-counter', 'xml-sitemap-generator',
  ],
  caseStudies: ['dental-pro', 'glamworlds', 'gls-sprachenzentrum', 'hssabek', 'mon-asso', 'morocco-quest'],
}

function viewPath(group, slug) {
  const dir = {
    core: `resources/views/frontoffice/pages/${slug}.blade.php`,
    legal: `resources/views/frontoffice/pages/legal/${slug}.blade.php`,
    services: `resources/views/frontoffice/pages/services/${slug}.blade.php`,
    cities: `resources/views/frontoffice/pages/locations/web-development-company-${slug}.blade.php`,
    tools: `resources/views/frontoffice/pages/tools/${slug}.blade.php`,
    caseStudies: `resources/views/frontoffice/pages/our-work/${slug}.blade.php`,
  }[group]
  return dir
}

const INVENTORY_SCHEMA = {
  type: 'object',
  properties: {
    pages: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          slug: { type: 'string' },
          file: { type: 'string' },
          url: { type: 'string' },
          page_type: { type: 'string' },
          primary_topic: { type: 'string' },
          primary_keyword: { type: 'string' },
          secondary_keywords: { type: 'array', items: { type: 'string' } },
          search_intent: { type: 'string' },
          intent_category: { type: 'string', enum: ['informational', 'commercial', 'transactional', 'navigational', 'local'] },
          business_value: { type: 'string', enum: ['tier1_primary_money', 'tier2_secondary_commercial', 'tier3_supporting', 'tier4_informational', 'tier5_utility'] },
          conversion_goal: { type: 'string' },
          target_audience: { type: 'string' },
          geographic_target: { type: 'string' },
          title: { type: 'string' },
          h1: { type: 'string' },
          meta_description: { type: 'string' },
          current_outbound_internal_links: { type: 'array', items: { type: 'string' } },
          related_topics: { type: 'array', items: { type: 'string' } },
          suggested_link_targets: { type: 'array', items: { type: 'string' } },
          notes: { type: 'string' },
        },
        required: ['slug', 'file', 'primary_topic', 'primary_keyword', 'intent_category', 'business_value'],
      },
    },
  },
  required: ['pages'],
}

function inventoryPrompt(groupName, slugs) {
  const fileList = slugs.map(s => `- ${s} → ${viewPath(groupName, s)}`).join('\n')
  return `You are auditing the Laravel/Blade site codesommet.com at root "${ROOT}" for an internal-linking and keyword-cannibalization project. Read the ACTUAL content (not just filenames) of each of these ${groupName} pages:

${fileList}

For each page, also check the matching lang file if one exists under lang/fr/${groupName === 'cities' ? 'locations' : groupName}/ (city pages use lang key 'web-development-company-{slug}', service pages use '{slug}-agency' typically — verify actual filenames with Glob if unsure) since titles/meta/H1/body copy often live there via __() calls, not hardcoded in the Blade file.

For each page report: slug, file path, inferred URL, page_type (service/city/tool/case-study/core/legal), primary_topic, primary_keyword (in French, as actually targeted by the page — do not invent), secondary_keywords, search_intent (a sentence describing what the searcher wants), intent_category, business_value tier (tier1_primary_money = pages meant to directly sell/convert like service pages and get-quote; tier2_secondary_commercial = city pages, industries hub; tier3_supporting = case studies, tools; tier4_informational = blog/guides; tier5_utility = legal/utility), conversion_goal, target_audience, geographic_target (city name or 'global'/'Morocco' or 'n/a'), title, h1, meta_description, current_outbound_internal_links (list every internal href/route() link you find in the page's body content — exclude header/footer/nav partials, only count contextual body links), related_topics (other pages in the site this page's content is thematically connected to — reason from content, not filename similarity), suggested_link_targets (pages this content should logically link to, with brief justification each), and notes (anything unusual — e.g. content mismatch, thin content, duplicate-looking copy vs a sibling page).

Be evidence-based. If a claim can't be verified from the file content, don't make it. Call the StructuredOutput tool with the pages array.`
}

async function runInventory() {
  phase('Inventory')
  const groupEntries = Object.entries(PAGE_GROUPS)
  const results = await parallel(groupEntries.map(([groupName, slugs]) => async () => {
    // Split large groups (cities: 35, tools: 44) into two halves each so no single agent
    // has to deep-read 40+ files — improves read quality per page.
    if (slugs.length > 15) {
      const mid = Math.ceil(slugs.length / 2)
      const halves = [slugs.slice(0, mid), slugs.slice(mid)]
      const halfResults = await parallel(halves.map((half, i) => async () => {
        const r = await agent(inventoryPrompt(groupName, half), {
          label: `inventory:${groupName}:${i}`,
          phase: 'Inventory',
          schema: INVENTORY_SCHEMA,
        })
        return r ? r.pages : []
      }))
      return { group: groupName, pages: halfResults.flat() }
    }
    const r = await agent(inventoryPrompt(groupName, slugs), {
      label: `inventory:${groupName}`,
      phase: 'Inventory',
      schema: INVENTORY_SCHEMA,
    })
    return { group: groupName, pages: r ? r.pages : [] }
  }))
  const allPages = results.flatMap(r => r.pages)
  log(`Inventory complete: ${allPages.length} pages catalogued across ${results.length} groups`)
  return allPages
}

const TOPICAL_MAP_SCHEMA = {
  type: 'object',
  properties: {
    pillars: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          name: { type: 'string' },
          pillar_url: { type: 'string' },
          cluster_urls: { type: 'array', items: { type: 'string' } },
          supporting_urls: { type: 'array', items: { type: 'string' } },
        },
      },
    },
    keyword_ownership_map: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          keyword_cluster: { type: 'string' },
          primary_url: { type: 'string' },
          supporting_urls: { type: 'array', items: { type: 'string' } },
          not_competing_urls: { type: 'array', items: { type: 'string' } },
          rationale: { type: 'string' },
        },
      },
    },
    commercial_page_tiers: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          url: { type: 'string' },
          tier: { type: 'string' },
          justification: { type: 'string' },
        },
      },
    },
  },
}

const CANNIBALIZATION_SCHEMA = {
  type: 'object',
  properties: {
    findings: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          keyword_or_topic: { type: 'string' },
          competing_urls: { type: 'array', items: { type: 'string' } },
          evidence: { type: 'string' },
          intent_comparison: { type: 'string' },
          classification: { type: 'string', enum: ['true_cannibalization', 'partial_overlap', 'healthy_overlap', 'review_required'] },
          severity: { type: 'string', enum: ['high', 'medium', 'low'] },
          recommended_action: { type: 'string', enum: ['keep_both', 'differentiate_intent', 'consolidate', 'redirect', 'canonicalize', 'no_change', 'review_required'] },
          primary_url: { type: 'string' },
          supporting_urls: { type: 'array', items: { type: 'string' } },
        },
        required: ['keyword_or_topic', 'competing_urls', 'classification', 'recommended_action'],
      },
    },
  },
  required: ['findings'],
}

async function runTopicalMapAndCannibalization(inventory) {
  phase('Topical Map & Cannibalization')
  const inventoryJson = JSON.stringify(inventory)

  const [topicalMap, cannibChunks] = await parallel([
    async () => agent(
      `You have a complete page inventory (JSON below) for codesommet.com, a Laravel web dev agency site. Build a topical architecture: identify pillar pages (broad high-value topics: likely 'développement web', 'outils SEO gratuits', 'développement par secteur/industrie', 'agence web internationale'), the cluster pages under each pillar, and supporting content. Then build a keyword ownership map: for every keyword cluster where 2+ pages could compete (e.g. service variants, city pages, tool categories), assign exactly ONE primary URL and list supporting URLs that should reinforce (not compete with) it. Finally classify every page into a commercial tier (tier1_primary_money through tier5_utility) with justification, using business_value already suggested per page as a starting point but verify against actual content/conversion goal.

Known prior findings to build on, not blindly trust — verify against the inventory: EdTech vs E-Learning platform pages were already differentiated (EdTech=B2B product, E-learning=internal LMS). Telemedicine platform vs website were already differentiated (platform=app, website=storefront). Fintech platform vs website similarly. 7 city pages previously shared a duplicate title (now fixed) — check the inventory to confirm.

INVENTORY:
${inventoryJson}

Call StructuredOutput with pillars, keyword_ownership_map, and commercial_page_tiers.`,
      { label: 'topical-map', phase: 'Topical Map & Cannibalization', schema: TOPICAL_MAP_SCHEMA, effort: 'high' }
    ),
    async () => {
      // Split cannibalization scoring into: services-vs-services, cities-vs-cities+home, tools-vs-tools, cross-group
      const servicePages = inventory.filter(p => p.page_type === 'service' || (p.file && p.file.includes('/services/')))
      const cityPages = inventory.filter(p => p.page_type === 'city' || (p.file && p.file.includes('/locations/')))
      const toolPages = inventory.filter(p => p.page_type === 'tool' || (p.file && p.file.includes('/tools/')))
      const otherPages = inventory.filter(p => !servicePages.includes(p) && !cityPages.includes(p) && !toolPages.includes(p))

      const chunks = [
        { label: 'cannib:services', pages: servicePages, note: 'Service pages are most likely to cannibalize each other (e.g. edtech vs elearning vs online-course, telemedicine platform vs website, fintech platform vs website). Check title/H1/primary keyword/body intent for every pair that looks related.' },
        { label: 'cannib:cities', pages: [...cityPages, ...otherPages.filter(p => p.slug === 'home' || p.slug === 'locations')], note: 'City pages target "développement web à {ville}" - check for duplicate titles/descriptions across cities, and whether Morocco cities (casablanca/marrakech/rabat/tangier) cannibalize the homepage or each other.' },
        { label: 'cannib:tools', pages: toolPages, note: 'Tool pages target "{function} gratuit" queries - check for near-duplicate tools (e.g. multiple SEO checkers) and whether any two tools target the exact same query.' },
        { label: 'cannib:cross', pages: [...servicePages.slice(0, 5), ...toolPages.slice(0, 5), ...otherPages], note: 'Check for cross-group cannibalization: tools vs services (should be informational vs commercial, usually fine), industries hub vs individual service pages, locations hub vs individual city pages, case studies vs the services they reference.' },
      ]

      return parallel(chunks.map(c => async () => {
        const r = await agent(
          `You are auditing codesommet.com for keyword cannibalization. ${c.note}

Compare title, H1, meta description, primary_keyword, secondary_keywords, and search_intent for every page below. Identify:
A. TRUE CANNIBALIZATION - two+ pages target essentially the same query and same intent.
B. PARTIAL OVERLAP - related keywords, different intent - may coexist.
C. HEALTHY TOPICAL OVERLAP - same broad topic, clearly different purpose - do NOT flag as cannibalization.
If you cannot confidently classify a pair, mark classification as "review_required" and explain why in evidence - do not guess.

For every finding requiring action, recommend: keep_both, differentiate_intent, consolidate, redirect, canonicalize, or no_change. Do not recommend consolidate/redirect/canonicalize unless the evidence clearly shows true, unresolvable cannibalization - these are destructive and need strong justification.

PAGES (JSON):
${JSON.stringify(c.pages)}

Call StructuredOutput with a findings array (can be empty if no issues found).`,
          { label: c.label, phase: 'Topical Map & Cannibalization', schema: CANNIBALIZATION_SCHEMA, effort: 'high' }
        )
        return r ? r.findings : []
      }))
    },
  ])

  const cannibalizationFindings = cannibChunks.flat()
  log(`Topical map built. ${cannibalizationFindings.length} cannibalization findings across all groups.`)
  return { topicalMap, cannibalizationFindings }
}

const LINKING_PLAN_SCHEMA = {
  type: 'object',
  properties: {
    link_opportunities: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          source_file: { type: 'string' },
          source_url: { type: 'string' },
          destination_url: { type: 'string' },
          destination_route: { type: 'string' },
          anchor_text: { type: 'string' },
          relationship: { type: 'string', enum: ['topic_support', 'user_next_step', 'commercial_transition', 'topical_authority', 'location_relevance', 'case_study_proof', 'conversion'] },
          why: { type: 'string' },
          seo_value: { type: 'string', enum: ['high', 'medium', 'low'] },
          commercial_value: { type: 'string', enum: ['high', 'medium', 'low'] },
          placement_hint: { type: 'string' },
          action: { type: 'string', enum: ['add', 'keep', 'do_not_add'] },
        },
        required: ['source_file', 'destination_url', 'anchor_text', 'relationship', 'why', 'action'],
      },
    },
    orphan_pages: { type: 'array', items: { type: 'string' } },
    weak_pages: { type: 'array', items: { type: 'string' } },
    overlinked_pages: { type: 'array', items: { type: 'string' } },
  },
  required: ['link_opportunities'],
}

async function runLinkingPlan(inventory, topicalMap, cannibalizationFindings) {
  phase('Linking Plan')

  // Group inventory by section for pipelined per-section planning (each section's plan
  // doesn't need to wait on the others, only on the shared topical map / cannibalization barrier above).
  const sections = [
    { name: 'services', pages: inventory.filter(p => p.file && p.file.includes('/services/')) },
    { name: 'cities', pages: inventory.filter(p => p.file && p.file.includes('/locations/')) },
    { name: 'tools', pages: inventory.filter(p => p.file && p.file.includes('/tools/')) },
    { name: 'case-studies-and-core', pages: inventory.filter(p => p.file && (p.file.includes('/our-work/') || (!p.file.includes('/services/') && !p.file.includes('/locations/') && !p.file.includes('/tools/')))) },
  ]

  const results = await parallel(sections.map(section => async () => {
    const r = await agent(
      `You are building an internal linking plan for the "${section.name}" section of codesommet.com, a Laravel web dev agency site. You have the full site's topical map, keyword ownership map, and cannibalization findings (JSON below) plus the page inventory for this section.

RULES (strict):
- Every proposed link needs an explicit WHY - one of: topic_support (destination expands on current topic), user_next_step (logical next step for visitor), commercial_transition (informational content leading to relevant service), topical_authority (supporting page reinforces a pillar), location_relevance (geographic relevance), case_study_proof (destination is evidence of expertise), conversion (destination is a relevant commercial page like /get-quote or /contact).
- Do NOT propose linking every page in this section to every other page in the same section (e.g. do not link every city to every city, do not link every tool to every tool, do not link every service to every service).
- Where the topical map's keyword_ownership_map indicates a page is a "supporting_url" for a keyword cluster, that page SHOULD link to its primary_url with commercial_transition or topical_authority reasoning.
- Where cannibalization findings recommend "differentiate_intent" for two pages, do NOT propose links between them that would blur that differentiation - if you do link them, the anchor text must make the difference obvious (e.g. link edtech->elearning with anchor "besoin d'un LMS interne plutôt qu'un produit commercialisé ?" style differentiation, not a generic anchor).
- Prioritize giving tier1/tier2 commercial pages (services, cities, get-quote, contact) more inbound contextual links from tier3/tier4 pages (tools, case studies) - this is the "authority flow toward money pages" goal.
- Tool pages should link to 2-4 thematically related tools (not all 44) plus 1 relevant service page as a "commercial_transition" where genuinely relevant (e.g. an SEO-audit-style tool -> the service page most related, if one exists; if none is genuinely relevant, do not force it).
- City pages should link to: the relevant service pages this location's dominant industries call for (per this section's own content - e.g. if a city page discusses fintech clients, link fintech-website-development), 1-2 relevant case studies as proof, and get-quote/contact as conversion. Do not link every city to every other city - only worldwide/locations hub relationships belong in nav, not body content.
- Service pages should link to: 1-2 relevant case studies as case_study_proof, get-quote/contact as conversion, and where a genuinely related complementary service exists (per keyword ownership map, not just similar name) link it once with a clear differentiating anchor.
- Anchor text must be natural and descriptive of the destination - do not repeat the exact same anchor text for the same destination across many source pages; vary phrasing naturally while staying accurate.
- Use route() destination format matching this site's actual routes: route('service', 'slug'), route('location', 'slug'), route('tool', 'slug'), route('case-study', 'slug'), route('get-quote'), route('contact'), route('industries'), route('locations'), route('tools').
- If you cannot justify a link with a clear reason, do NOT propose it - list it as action "do_not_add" is not needed, simply omit it.
- Identify orphan_pages (pages in this section with no proposed OR existing incoming contextual link from anywhere), weak_pages (pages with fewer than 2 relevant contextual inbound links total), and overlinked_pages (pages that current data shows receiving excessive/repetitive links).

TOPICAL MAP:
${JSON.stringify(topicalMap)}

CANNIBALIZATION FINDINGS:
${JSON.stringify(cannibalizationFindings)}

THIS SECTION'S PAGE INVENTORY (includes current_outbound_internal_links already present - do not duplicate existing links, only propose NEW ones, and set action "keep" for existing links worth preserving if listing them for completeness is useful, otherwise focus your list on action "add"):
${JSON.stringify(section.pages)}

Call StructuredOutput with link_opportunities (only action "add" items need full justification; you may skip "keep"), orphan_pages, weak_pages, overlinked_pages.`,
      { label: `linkplan:${section.name}`, phase: 'Linking Plan', schema: LINKING_PLAN_SCHEMA, effort: 'high' }
    )
    return { section: section.name, plan: r }
  }))

  const allOpportunities = results.flatMap(r => (r.plan && r.plan.link_opportunities) ? r.plan.link_opportunities : [])
  const allOrphans = results.flatMap(r => (r.plan && r.plan.orphan_pages) ? r.plan.orphan_pages : [])
  const allWeak = results.flatMap(r => (r.plan && r.plan.weak_pages) ? r.plan.weak_pages : [])
  const allOverlinked = results.flatMap(r => (r.plan && r.plan.overlinked_pages) ? r.plan.overlinked_pages : [])

  log(`Linking plan built: ${allOpportunities.length} proposed links, ${allOrphans.length} orphans, ${allWeak.length} weak pages flagged.`)
  return { linkOpportunities: allOpportunities, orphanPages: allOrphans, weakPages: allWeak, overlinkedPages: allOverlinked }
}

const IMPLEMENTATION_SCHEMA = {
  type: 'object',
  properties: {
    file_edited: { type: 'string' },
    links_added: { type: 'number' },
    links_skipped: { type: 'array', items: { type: 'string' } },
    summary: { type: 'string' },
  },
  required: ['file_edited', 'links_added', 'summary'],
}

async function runImplementation(linkOpportunities) {
  phase('Implement')

  // Group link opportunities by source_file so each agent edits ONE file with ALL its
  // new links at once (avoids conflicting concurrent edits to the same file).
  const bySourceFile = {}
  for (const op of linkOpportunities) {
    if (op.action !== 'add') continue
    if (!op.source_file) continue
    if (!bySourceFile[op.source_file]) bySourceFile[op.source_file] = []
    bySourceFile[op.source_file].push(op)
  }

  const fileEntries = Object.entries(bySourceFile)
  log(`Implementing links across ${fileEntries.length} source files (worktree-isolated to avoid conflicts)...`)

  const results = await parallel(fileEntries.map(([file, ops]) => async () => {
    return agent(
      `Add contextual internal links to the Blade view file "${file}" in the codesommet.com Laravel project at root "${ROOT}". This file may be a raw Blade view OR its content may come from a lang/fr/*.php file via __() calls - check both; if the visible text you need to link FROM lives in a lang file, add the Blade <a> markup around the appropriate __() output in the Blade file itself (do not edit lang files to add HTML links unless the entire string is already HTML-safe and rendered with {!! !!} - check how the surrounding code renders that key first).

Add EXACTLY these links, placed naturally within existing body content near text that discusses the relevant topic (do not create new sections just to hold a link list - weave into prose, feature lists, or a relevant existing block; a small "related resources" block at the end of a natural content section is acceptable if no better contextual spot exists):

${JSON.stringify(ops, null, 2)}

For each link: use Laravel's route() helper as specified in destination_route (e.g. {{ route('service', 'ecommerce-website-development') }}), use the exact anchor_text given (adjust only for grammatical fit in French, do not change the meaning or add keyword stuffing), and place it per placement_hint if given. Preserve all existing HTML structure, classes, and styling patterns already used for links elsewhere in the file (match the site's existing <a> tag class conventions - grep the file for existing <a class= patterns first and reuse that styling for consistency). Do NOT remove or alter any existing content, links, or styling beyond adding these new links. Do NOT touch anything unrelated to this task.

If a proposed link's target route/slug doesn't actually exist (verify with Glob if unsure), skip it and report why in links_skipped rather than adding a broken link.

After editing, call StructuredOutput with file_edited, links_added (count), links_skipped (array of reasons for any skipped), and a short summary.`,
      { label: `implement:${file.split('/').pop()}`, phase: 'Implement', schema: IMPLEMENTATION_SCHEMA, isolation: 'worktree' }
    )
  }))

  return results.filter(Boolean)
}

const VALIDATION_SCHEMA = {
  type: 'object',
  properties: {
    broken_internal_links: { type: 'array', items: { type: 'string' } },
    routes_verified_ok: { type: 'boolean' },
    tests_passed: { type: 'boolean' },
    test_output_summary: { type: 'string' },
    notes: { type: 'string' },
  },
}

async function runValidation(implementationResults) {
  phase('Validate')
  const editedFiles = implementationResults.map(r => r.file_edited).filter(Boolean)

  const result = await agent(
    `You are validating internal-linking changes just made to the codesommet.com Laravel project at root "${ROOT}". These files were edited to add contextual internal links:

${JSON.stringify(editedFiles)}

Do the following:
1. For each edited file, grep for route(' calls and verify every referenced route name + slug pair actually exists (cross-check against routes/web.php and config/pages.php whitelists for services/cities, and Glob the tools/our-work directories for tool/case-study slugs).
2. Run the project's existing test suite relevant to routes/SEO if one exists (check for "composer test" or a phpunit command in composer.json; run it if feasible, e.g. via 'php artisan test --filter=Seo' or similar targeted filter to avoid a very long run - use your judgment, a full run is fine too if it's fast).
3. Report any broken internal links found (route/slug that doesn't resolve to an existing view).
4. Report whether php artisan view:cache (or view:clear then a dry render check) succeeds without Blade syntax errors on the edited files - at minimum, run 'php artisan view:clear' and try rendering one or two edited routes if a quick way exists, otherwise just verify Blade syntax visually (matched @if/@endif, proper route() call syntax, no stray {{ }}).

Call StructuredOutput with broken_internal_links (list, empty if none), routes_verified_ok (bool), tests_passed (bool - true if tests ran and passed, false if failed, and if no relevant tests exist just verify no errors were introduced), test_output_summary, and notes.`,
    { label: 'validate', phase: 'Validate', schema: VALIDATION_SCHEMA, effort: 'high' }
  )
  return result
}

// ─── Main ────────────────────────────────────────────────────────────────

const inventory = await runInventory()
const { topicalMap, cannibalizationFindings } = await runTopicalMapAndCannibalization(inventory)
const { linkOpportunities, orphanPages, weakPages, overlinkedPages } = await runLinkingPlan(inventory, topicalMap, cannibalizationFindings)
const implementationResults = await runImplementation(linkOpportunities)
const validation = await runValidation(implementationResults)

return {
  inventory,
  topicalMap,
  cannibalizationFindings,
  linkOpportunities,
  orphanPages,
  weakPages,
  overlinkedPages,
  implementationResults,
  validation,
}
