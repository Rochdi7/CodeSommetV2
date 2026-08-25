export const meta = {
  name: 'seo-phase3-content-differentiation',
  description: 'Phase 3: fix deferred cannibalization content (telemedicine, fintech, edtech), tool positioning, city E-E-A-T, and remaining link-equity gaps',
  phases: [
    { title: 'Content Inventory & Specialist Analysis' },
    { title: 'Lead Architect Review' },
    { title: 'Implement' },
    { title: 'Validate' },
  ],
}

const ROOT = 'c:\\Users\\ASUS\\Desktop\\pikasso studio\\pikassostudio.com'
const CHECKPOINT = '0449640' // verified-clean commit this workflow's worktrees must branch from

// ─── Phase 1: Content inventory + specialist analysis (parallel, read-only) ─

const INVENTORY_SCHEMA = {
  type: 'object',
  properties: {
    pages: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          slug: { type: 'string' }, url: { type: 'string' }, title: { type: 'string' },
          h1: { type: 'string' }, meta_description: { type: 'string' }, meta_keywords: { type: 'string' },
          primary_keyword: { type: 'string' }, secondary_keywords: { type: 'array', items: { type: 'string' } },
          search_intent: { type: 'string' }, target_customer: { type: 'string' },
          product_service_scope: { type: 'string' }, main_features: { type: 'array', items: { type: 'string' } },
          pain_points: { type: 'array', items: { type: 'string' } }, faq_topics: { type: 'array', items: { type: 'string' } },
          cta: { type: 'string' }, internal_links: { type: 'array', items: { type: 'string' } },
          unique_content_summary: { type: 'string' }, duplicated_content_summary: { type: 'string' },
        },
        required: ['slug', 'url', 'title', 'search_intent'],
      },
    },
  },
  required: ['pages'],
}

async function runContentInventory() {
  phase('Content Inventory & Specialist Analysis')
  const groups = [
    { name: 'telemedicine+healthcare', files: ['services/telemedicine-platform-development', 'services/telemedicine-website-development', 'services/healthcare-website-development'] },
    { name: 'fintech', files: ['services/fintech-platform-development', 'services/fintech-website-development'] },
    { name: 'edtech-cluster', files: ['services/edtech-platform-development', 'services/elearning-platform-development', 'services/education-website-development', 'services/university-website-development', 'services/language-school-website-development'] },
    { name: 'tools', files: ['tools/domain-authority-checker', 'tools/domain-health-checker', 'tools/backlink-checker'] },
    { name: 'link-equity-targets', files: ['services/real-estate-website-development', 'services/saas-platform-development'] },
  ]
  const results = await parallel(groups.map(g => async () => {
    const r = await agent(
      `Fresh content inventory for the codesommet.com Laravel/Blade site at "${ROOT}". Read the ACTUAL current content (not filenames, not any prior report) of these pages: ${g.files.map(f => `resources/views/frontoffice/pages/${f}.blade.php`).join(', ')}, plus their paired lang/fr/${g.name.includes('tools') ? 'tools' : 'services'}/*.php files (check the exact lang key naming per file — service pages typically use {slug}-agency.php, tool pages use {slug}.php).

For each page report: slug, url, title, h1, meta_description, meta_keywords, primary_keyword, secondary_keywords, search_intent, target_customer (who is this page actually for — be specific), product_service_scope, main_features, pain_points (the specific pain-point paragraphs/claims found), faq_topics (list every FAQ question found, verbatim or close paraphrase), cta, internal_links (outbound route() links in body content), unique_content_summary (what's genuinely distinct about this page), duplicated_content_summary (any content that reads identical or near-identical to a sibling page in this group — quote or closely paraphrase the overlapping text).

Call StructuredOutput with a pages array.`,
      { label: `inventory:${g.name}`, phase: 'Content Inventory & Specialist Analysis', schema: INVENTORY_SCHEMA, effort: 'high' }
    )
    return { group: g.name, pages: r ? r.pages : [] }
  }))
  return results
}

const REWRITE_PLAN_SCHEMA = {
  type: 'object',
  properties: {
    target_pages: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          slug: { type: 'string' }, file: { type: 'string' }, lang_file: { type: 'string' },
          owns_intent: { type: 'string' }, target_customer: { type: 'string' },
          sections_to_rewrite: {
            type: 'array',
            items: {
              type: 'object',
              properties: {
                section: { type: 'string' }, current_lang_keys: { type: 'array', items: { type: 'string' } },
                problem: { type: 'string' }, new_content_direction: { type: 'string' },
                new_copy_french: { type: 'string' },
              },
              required: ['section', 'problem', 'new_content_direction'],
            },
          },
          faq_rewrite: {
            type: 'array',
            items: {
              type: 'object',
              properties: { lang_key: { type: 'string' }, old_question: { type: 'string' }, new_question_french: { type: 'string' }, new_answer_french: { type: 'string' } },
            },
          },
          sections_to_remove: { type: 'array', items: { type: 'string' } },
        },
        required: ['slug', 'sections_to_rewrite'],
      },
    },
    cross_link_updates: {
      type: 'array',
      items: {
        type: 'object',
        properties: { source_file: { type: 'string' }, destination_url: { type: 'string' }, new_anchor_french: { type: 'string' }, why: { type: 'string' } },
      },
    },
    business_decision_notes: { type: 'string' },
  },
  required: ['target_pages'],
}

async function runTelemedicineSpecialist() {
  const r = await agent(
    `You are the Telemedicine Content Specialist for codesommet.com (French-language Laravel site). Read the ACTUAL current content of resources/views/frontoffice/pages/services/telemedicine-platform-development.blade.php, telemedicine-website-development.blade.php, and healthcare-website-development.blade.php, plus their lang/fr/services/*-agency.php files.

CONFIRMED PROBLEM (from two prior audits): telemedicine-website-development's body copy is still overwhelmingly copy-pasted from telemedicine-platform-development. Its FAQ still asks "Combien de temps faut-il pour créer une plateforme de télémédecine ?", pain-point paragraphs and "why choose us" badges still say "PLATEFORME", and a HIPAA/Zoom compliance answer is byte-identical and left in English on both pages.

REQUIRED INTENT ARCHITECTURE (do not deviate):
- telemedicine-platform-development OWNS: telemedicine software/SaaS, doctor/patient platform, provider dashboards, video consultation infrastructure, e-prescriptions, payments, APIs/integrations, scalable architecture. Target: companies/organizations building an actual telemedicine PRODUCT.
- telemedicine-website-development OWNS: medical/clinic/doctor website, patient-facing website, appointment-request website, medical SEO, trust/conversion, patient acquisition. Target: doctors/clinics/healthcare orgs needing a professional public-facing WEBSITE (telemedicine is a feature they mention, not the product they're building).
- healthcare-website-development OWNS: the broad healthcare category (general clinic/hospital sites, patient portals, EHR-adjacent features) with telemedicine as ONE feature/use-case among several, not its primary identity.

TASK: identify every section of telemedicine-website-development.blade.php/lang file that still uses platform-oriented language (FAQ questions about "plateforme", feature claims about video-SDK/EHR-integration/e-prescription platform architecture, "why choose us" badges saying PLATEFORME) and produce a REWRITE PLAN — not just a diagnosis. For each problem section, write the actual replacement French copy reflecting the website-page's genuine scope (medical website UX, patient trust, appointment conversion, doctor/clinic presentation, services/specialties list, medical SEO, local visibility, mobile-first patient experience, multilingual content, contact/conversion flows). Rewrite all FAQ questions/answers that are platform-oriented into genuinely website-oriented equivalents (e.g. "Qu'est-ce qu'un site web de télémédecine devrait inclure ?", "Comment un site médical génère-t-il des demandes de rendez-vous ?", "Le site peut-il gérer plusieurs médecins ou spécialités ?", "Comment structurer les services médicaux pour le SEO ?", "Le site peut-il s'intégrer à un système de prise de rendez-vous existant ?", "Combien de temps prend un projet de site web santé standard ?"). Translate/rewrite the HIPAA/Zoom compliance answer to be website-appropriate (a website doesn't need its own HIPAA/Zoom architecture answer the way a platform does — reframe around HIPAA-compliant data handling in a booking form, not video infrastructure).

CRITICAL RULES:
- Do NOT invent exact turnaround times, client counts, or certifications not already present elsewhere on the site — if you need a timeframe reference, use "2-5 jours" (the site's already-established, correct delivery-time framing) only where genuinely applicable to a marketing-website build, and do not claim it for something that would actually take longer; if unsure, phrase without a specific number.
- Do NOT do word-substitution (platform→website). The actual meaning/audience framing must change.
- Preserve French language quality — natural, not stilted or AI-sounding filler ("solution innovante" repetition, unsupported superlatives).
- Also review healthcare-website-development for its overlap with telemedicine (title says "Santé & Télémédecine", meta_keywords includes "plateforme de télémédecine" verbatim, one FAQ item ml_1011 duplicates telemedicine-platform's core question) — propose a LIGHTER title/meta/one-FAQ-item adjustment (e.g. swap "plateforme de télémédecine" for "télésanté"/"consultations vidéo" framing) that keeps healthcare as the broad parent without directly competing with telemedicine-platform's core term.

Call StructuredOutput with target_pages (one entry per page needing changes, each with file, lang_file, owns_intent, target_customer, sections_to_rewrite — each section needs current_lang_keys identified by reading the actual file, problem, new_content_direction, and new_copy_french with the ACTUAL replacement French text you're proposing), faq_rewrite (old_question/new_question_french/new_answer_french per FAQ item), sections_to_remove if any, and business_decision_notes for anything you're unsure requires a human call.`,
    { label: 'telemedicine-specialist', phase: 'Content Inventory & Specialist Analysis', schema: REWRITE_PLAN_SCHEMA, effort: 'high' }
  )
  return r
}

async function runFintechSpecialist() {
  const r = await agent(
    `You are the Fintech Content Specialist for codesommet.com (French-language Laravel site). Read the ACTUAL current content of resources/views/frontoffice/pages/services/fintech-platform-development.blade.php and fintech-website-development.blade.php, plus their lang/fr/services/*-agency.php files.

CONFIRMED PROBLEM (from a prior audit, previously misrated as "cleanest pair, no action needed"): the entire "Défis Courants" pain-point section (6 full paragraphs — PCI-DSS/tokenization, manual KYC delays, chargeback fraud, 3-5 day settlement rails, regulatory reporting, processing fees) is 100% byte-identical between the two pages. fintech-website-development (meant to be a marketing/brochure site) still carries a "real-time trading interface with order books, portfolio management, market analytics" feature card — product-platform functionality with no place on a marketing website. The comparison table and 4 of 5 FAQ questions are also identical.

REQUIRED INTENT ARCHITECTURE:
- fintech-platform-development OWNS: fintech software/financial platforms, payment infrastructure, APIs, transaction workflows, KYC/AML systems, reporting systems, financial product architecture, scalable backend. Target: companies building an actual fintech PRODUCT.
- fintech-website-development OWNS: fintech company websites, financial services marketing sites, trust/credibility, conversion, product/service presentation, investor/company info, financial SEO, lead generation, compliance communication (as messaging, not engineering). Target: fintech companies needing a professional public-facing WEBSITE.

TASK: produce a REWRITE PLAN for fintech-website-development.blade.php/lang file. Rewrite the "Défis Courants" pain-point section away from product-engineering pain points (PCI-DSS tokenization, KYC delays, settlement rails, chargeback fraud) toward genuine marketing-website concerns: lack of credibility signals for a fintech brand, poor page speed hurting trust with cautious financial-services visitors, generic templates that don't convert visitors into leads, missing compliance-badge/certification display, unclear pricing/product explanation. REMOVE the "real-time trading interface with order books" feature card entirely from the website page — it doesn't belong on a marketing site; replace it with a genuine website-scope feature (e.g. clear pricing/product explainer sections, trust-badge display, lead-capture forms, security-messaging blocks). Rewrite at least 3 of 5 FAQ questions to be website-appropriate rather than product-engineering-appropriate (e.g. instead of "quelles passerelles de paiement intégrez-vous côté produit", ask "comment présenter nos certifications de conformité sur le site", "combien de temps prend un site web fintech standard", "le site peut-il inclure une calculatrice de tarifs/simulateur").

CRITICAL RULES:
- Do NOT invent exact turnaround times, client counts, or certifications not already present elsewhere on the site.
- Do NOT do word-substitution. The actual meaning must change from product-engineering framing to marketing/conversion framing.
- Preserve French language quality — natural, not stilted or AI-sounding filler.
- Do not remove genuinely legitimate shared vocabulary (both pages can mention "conformité PCI-DSS" as a trust signal — the difference is platform explains HOW they build it, website explains how they COMMUNICATE it to visitors).

Call StructuredOutput with target_pages (fintech-website-development entry with file, lang_file, owns_intent, target_customer, sections_to_rewrite with actual new_copy_french, plus sections_to_remove listing the trading-interface card), faq_rewrite, and business_decision_notes.`,
    { label: 'fintech-specialist', phase: 'Content Inventory & Specialist Analysis', schema: REWRITE_PLAN_SCHEMA, effort: 'high' }
  )
  return r
}

async function runEdtechSpecialist() {
  const r = await agent(
    `You are the EdTech/E-learning Content Specialist for codesommet.com (French-language Laravel site). Read the ACTUAL current content of resources/views/frontoffice/pages/services/edtech-platform-development.blade.php, elearning-platform-development.blade.php, education-website-development.blade.php, university-website-development.blade.php, language-school-website-development.blade.php, plus their lang/fr/services/*-agency.php files.

CONFIRMED BUSINESS DECISION (already made — do not re-litigate): the site's own titles already show a real split — edtech-platform-development's title is "Développement de Plateformes EdTech B2B" targeting "éditeurs et startups éducatives" (publishers/startups building a commercial product to sell), elearning-platform-development's title is "Développement de Plateformes E-Learning (LMS)" targeting "écoles, centres de formation et entreprises" (schools/training centers/companies building an LMS for their OWN internal use). This is Option A from the task brief: EdTech = commercial B2B product for publishers/startups; E-learning = LMS/training platform for institutional buyers. PROCEED WITH DIFFERENTIATION — this decision has already been confirmed, do not flag it as a consolidation candidate.

CONFIRMED PROBLEM: >80% of unique body copy (pain points, features, 5 of 6 FAQ questions) is shared via a literal find/replace ("EdTech"↔"E-Learning") despite the title-level distinction already existing. elearning-platform-development has a disambiguation cross-link box pointing to edtech-platform-development; edtech-platform-development does NOT have a reciprocal one.

TASK: produce a REWRITE PLAN.
- edtech-platform-development: rewrite the pain-point section around B2B/publisher concerns (white-labeling for resale, multi-tenant course marketplaces, revenue-share models with instructors, API/LTI integration for institutional buyers, building a commercializable product) instead of reusing Teachable/Kajabi consumer-creator pain points verbatim. Add a reciprocal disambiguation cross-link box pointing to elearning-platform-development for "building your own internal training platform." Differentiate at least 4 of 6 FAQ questions to be publisher/product-focused (e.g. "proposez-vous un modèle multi-tenant pour revendre à plusieurs clients ?", "supportez-vous le marquage blanc pour nos propres clients ?", "quelles intégrations API/LTI proposez-vous pour les institutions ?").
- elearning-platform-development: verify/strengthen its existing disambiguation (it already has one per the confirmed problem) — keep pain points focused on institutional/internal-training concerns (FERPA/data security for the buyer's own learners, completion-rate tracking, corporate training compliance) rather than B2B-resale concerns.
- education-website-development, university-website-development, language-school-website-development: quick re-verification only per prior audits (these were already confirmed genuinely distinct) — flag anything that looks newly regressed, but do not propose rewrites unless you find a real problem.

CRITICAL RULES:
- Do NOT invent exact client counts, revenue figures, or case studies not already present.
- Do NOT do word-substitution — actual buyer-persona framing must change (publisher/reseller vs institutional/internal-use).
- Preserve French language quality.

Call StructuredOutput with target_pages (edtech-platform-development primarily, elearning-platform-development if changes needed, with actual new_copy_french), faq_rewrite, cross_link_updates (the new reciprocal box), and business_decision_notes.`,
    { label: 'edtech-specialist', phase: 'Content Inventory & Specialist Analysis', schema: REWRITE_PLAN_SCHEMA, effort: 'high' }
  )
  return r
}

const TOOL_POSITIONING_SCHEMA = {
  type: 'object',
  properties: {
    target_pages: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          slug: { type: 'string' }, file: { type: 'string' }, lang_file: { type: 'string' },
          keep_slug: { type: 'boolean' },
          new_title_french: { type: 'string' }, new_h1_french: { type: 'string' },
          new_meta_description_french: { type: 'string' }, new_meta_keywords_french: { type: 'string' },
          new_intro_french: { type: 'string' },
          faq_rewrite: { type: 'array', items: { type: 'object', properties: { lang_key: { type: 'string' }, old_question: { type: 'string' }, new_question_french: { type: 'string' }, new_answer_french: { type: 'string' } } } },
        },
        required: ['slug', 'keep_slug'],
      },
    },
    business_decision_notes: { type: 'string' },
  },
  required: ['target_pages'],
}

async function runToolPositioningSpecialist() {
  const r = await agent(
    `You are the Tool/Product Positioning Specialist for codesommet.com's free SEO tools. Read the ACTUAL current content of resources/views/frontoffice/pages/tools/domain-authority-checker.blade.php, domain-health-checker.blade.php, backlink-checker.blade.php, plus their lang/fr/tools/*.php files.

CONFIRMED PROBLEM (from two prior audits): domain-authority-checker's own on-page FAQ admits it doesn't measure real Moz-style Domain Authority — it runs a 6-check technical checklist (domain accessibility, HTTPS, SSL, sitemap.xml, robots.txt, WWW redirect) and brands the resulting score as "Domain Authority", which conventionally means Moz's real backlink-based metric (already correctly served by backlink-checker using actual Moz API data). This is misleading branding.

HARD CONSTRAINT: the URL slug/route MUST remain /tools/domain-authority-checker — do NOT propose a slug/route change (external backlinks/bookmarks reference it; a rename requires a redirect migration this task explicitly says to avoid unless unavoidable, and it is avoidable here via a copy-only fix).

TASK: propose new title/H1/meta_description/meta_keywords/intro copy for domain-authority-checker that accurately describes what the tool measures (a technical-domain-health/foundations score based on the 6 checks) WITHOUT claiming it measures Moz-style Domain Authority. Do not claim DA/PA/backlink data anywhere in the new copy. Rewrite the opening FAQ question (currently something like "Qu'est-ce que le Domain Authority ?") to ask about the actual technical score instead, while keeping the honest explanation that already exists in the FAQ (it already correctly discloses the real methodology — build on that, don't discard it). Suggest a natural French name for the score concept (e.g. "Score de Fondations SEO Techniques" or similar — propose your best option, this is copy not routing).

Also verify/confirm domain-health-checker's positioning remains accurate (it's the broader technical+on-page superset) and backlink-checker's positioning remains accurate (real Moz DA/PA data) — only propose changes if you find something newly wrong, these were both already confirmed correct in prior audits.

Call StructuredOutput with target_pages (domain-authority-checker with keep_slug:true and the actual new copy in French for title/h1/meta_description/meta_keywords/intro, plus faq_rewrite for at least the opening question), and business_decision_notes.`,
    { label: 'tool-positioning-specialist', phase: 'Content Inventory & Specialist Analysis', schema: TOOL_POSITIONING_SCHEMA, effort: 'high' }
  )
  return r
}

const EEAT_SCHEMA = {
  type: 'object',
  properties: {
    findings: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          claim_or_stat: { type: 'string' },
          affected_cities: { type: 'array', items: { type: 'string' } },
          is_globally_true_but_presented_as_local: { type: 'boolean' },
          classification: { type: 'string', enum: ['SAFE_TEMPLATE', 'ACCEPTABLE_COMMON_CONTENT', 'THIN_DUPLICATION', 'PROBLEMATIC_DUPLICATION', 'UNSUPPORTED_LOCAL_CLAIM'] },
          recommended_action: { type: 'string', enum: ['no_change', 'remove_claim', 'reframe_as_global', 'rewrite_needed'] },
          priority: { type: 'string', enum: ['high', 'medium', 'low'] },
          evidence: { type: 'string' },
        },
        required: ['claim_or_stat', 'affected_cities', 'classification', 'recommended_action'],
      },
    },
    worst_offenders: { type: 'array', items: { type: 'string' } },
  },
  required: ['findings'],
}

async function runEEATSpecialist() {
  // Split across 3 parallel agents to actually read all 35 city files thoroughly.
  const cityGroups = [
    ['casablanca', 'marrakech', 'rabat', 'tangier', 'dubai', 'abudhabi', 'riyadh', 'worldwide', 'london', 'amsterdam', 'berlin', 'paris'],
    ['copenhagen', 'dublin', 'brussels', 'zurich', 'stockholm', 'madrid', 'barcelona', 'lisbon', 'rome', 'milan', 'new-york', 'san-francisco'],
    ['los-angeles', 'austin', 'seattle', 'boston', 'chicago', 'denver', 'toronto', 'vancouver', 'tunis', 'cairo', 'lagos'],
  ]
  const results = await parallel(cityGroups.map((cities, i) => async () => {
    const r = await agent(
      `You are the E-E-A-T / City Content Auditor for codesommet.com. Read the ACTUAL current content of these city pages: ${cities.map(c => `resources/views/frontoffice/pages/locations/web-development-company-${c}.blade.php`).join(', ')} (plus paired lang/fr/locations/*.php files).

KNOWN PATTERN TO VERIFY (confirmed on Austin/Denver by a prior audit, check if it extends to your assigned cities): proof-point statistics like "300+ étudiants inscrits", "2 000+ rendez-vous réservés", "800+ voyageurs accompagnés" and identical sector-specialty lists ("Santé / Éducation / Tourisme") appearing VERBATIM IDENTICAL across multiple unrelated cities, presented as if city-specific.

For every repeated statistic or claim you find across your assigned cities, report: claim_or_stat (the exact text), affected_cities (every city in your group where it appears identically), is_globally_true_but_presented_as_local (your best judgment — does this read like a real company-wide stat being falsely localized, or a plausible city-specific fact?), classification: SAFE_TEMPLATE (structural boilerplate like a CTA button — not a content-quality issue), ACCEPTABLE_COMMON_CONTENT (a legitimately shared fact, e.g. company-wide delivery time), THIN_DUPLICATION (near-identical phrasing but not a fabricated-sounding claim), PROBLEMATIC_DUPLICATION (a specific-sounding stat/claim copy-pasted across unrelated cities with no real differentiation), UNSUPPORTED_LOCAL_CLAIM (a claim presented as city-specific proof with no evidence it's true for that city). recommended_action: no_change / remove_claim (if unsupported and unverifiable — do NOT recommend inventing a replacement) / reframe_as_global (if the stat is plausibly true company-wide, recommend rephrasing it as a company-wide claim rather than a fake local one) / rewrite_needed. priority based on how many cities are affected and how specific/fabricated-sounding the claim is.

Do NOT flag genuinely distinct city-specific content (real sector differentiation, actual geography mentions, distinct case-study references) — only flag content that reads as templated/copy-pasted and presented misleadingly as local.

Call StructuredOutput with findings array and worst_offenders (the 3-5 most clear-cut PROBLEMATIC_DUPLICATION or UNSUPPORTED_LOCAL_CLAIM cases you found, by city+claim).`,
      { label: `eeat-audit:${i}`, phase: 'Content Inventory & Specialist Analysis', schema: EEAT_SCHEMA, effort: 'high' }
    )
    return r ? r.findings : []
  }))
  return results.flat()
}

const LINK_EQUITY_SCHEMA = {
  type: 'object',
  properties: {
    findings: {
      type: 'array',
      items: {
        type: 'object',
        properties: {
          page: { type: 'string' }, confirmed_inbound_count: { type: 'number' },
          confirmed_inbound_sources: { type: 'array', items: { type: 'string' } },
          genuinely_orphan_or_weak: { type: 'boolean' },
          recommended_new_links: {
            type: 'array',
            items: { type: 'object', properties: { source_file: { type: 'string' }, anchor_french: { type: 'string' }, why: { type: 'string' } } },
          },
        },
        required: ['page', 'confirmed_inbound_count', 'genuinely_orphan_or_weak'],
      },
    },
  },
  required: ['findings'],
}

async function runLinkEquitySpecialist() {
  const r = await agent(
    `You are the Internal Link Equity Specialist for codesommet.com. Two prior audits flagged /services/real-estate-website-development and /services/saas-platform-development as weak/unconfirmed inbound — but the source data itself was marked "unconfirmed". Do NOT trust that stale inventory data.

Do a fresh, direct verification: grep the ENTIRE resources/views/frontoffice/pages/ tree for any route('service', 'real-estate-website-development') or route('service', 'saas-platform-development') occurrence, and separately check each city page's body content for real-estate or SaaS-vertical deep-dive sections that don't currently link to the corresponding service page (a prior audit already added SOME of these links — verify which ones actually exist now vs which are still missing).

For each of the 2 target pages, report confirmed_inbound_count (actual grep-verified count, not inventory-estimated), confirmed_inbound_sources (the actual file paths), genuinely_orphan_or_weak (true only if the verified count is truly 0-1), and if genuinely weak, recommended_new_links — ONLY from city pages or tool pages or case studies that have a GENUINE topical reason (e.g. a city page's real-estate deep-dive section, a relevant case study, a relevant tool) — do not propose forcing a link from an unrelated page just to inflate the count.

Call StructuredOutput with a findings array (2 entries, one per target page).`,
    { label: 'link-equity-specialist', phase: 'Content Inventory & Specialist Analysis', schema: LINK_EQUITY_SCHEMA, effort: 'high' }
  )
  return r ? r.findings : []
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
          category: { type: 'string', enum: ['telemedicine', 'fintech', 'edtech', 'tool_positioning', 'healthcare', 'eeat_city', 'link_equity'] },
          target_file: { type: 'string' },
          target_lang_file: { type: 'string' },
          description: { type: 'string' },
          new_copy_french: { type: 'string' },
          classification: { type: 'string', enum: ['FIX_NOW', 'FIX_AFTER_REVIEW', 'DO_NOT_CHANGE'] },
          seo_benefit: { type: 'string' }, user_benefit: { type: 'string' },
          business_risk: { type: 'string' }, implementation_risk: { type: 'string' },
          reasoning: { type: 'string' },
        },
        required: ['category', 'target_file', 'description', 'classification', 'reasoning'],
      },
    },
    rejected_or_deferred: {
      type: 'array',
      items: {
        type: 'object',
        properties: { description: { type: 'string' }, why_not_fixed: { type: 'string' }, decision_required: { type: 'string' }, recommended_decision: { type: 'string' } },
      },
    },
  },
  required: ['approved_changes'],
}

async function runLeadArchitect(telemedicine, fintech, edtech, toolPositioning, eeatFindings, linkEquity) {
  phase('Lead Architect Review')
  const r = await agent(
    `You are the Lead SEO Architect reviewing Phase 3 findings from 6 specialist agents before any implementation on codesommet.com (a live production Laravel site). Classify every proposed change as FIX_NOW (safe, evidence-backed, ready to implement verbatim), FIX_AFTER_REVIEW (needs human sign-off — do not implement), or DO_NOT_CHANGE.

Hard constraints:
- Never approve a route/slug change for domain-authority-checker — the tool specialist was explicitly told to keep the slug, verify they did.
- Content rewrites (telemedicine, fintech, edtech) are pre-authorized by prior human confirmation THIS SESSION that the underlying business distinctions are real (EdTech B2B-product vs E-learning institutional-LMS was explicitly confirmed by the user this session) — you do NOT need to re-defer these to FIX_AFTER_REVIEW purely for being content rewrites, unlike the previous Phase 2 run. However, still scrutinize each specific proposed copy change: reject/defer anything that invents unverifiable claims (specific client counts, certifications, integrations, turnaround times not already established elsewhere on the site), reads as word-substitution rather than genuine intent differentiation, or removes content without a clear replacement reason.
- For E-E-A-T findings: approve remove_claim or reframe_as_global as FIX_NOW only for clear-cut PROBLEMATIC_DUPLICATION/UNSUPPORTED_LOCAL_CLAIM cases with strong evidence (multiple cities, specific fabricated-sounding numbers). Do not approve rewriting all 35 city pages — prioritize the worst 3-5 offenders per the specialist's own worst_offenders list. THIN_DUPLICATION and SAFE_TEMPLATE should generally be DO_NOT_CHANGE.
- For link equity: only approve recommended_new_links that have a genuine topical reason already stated by the specialist — reject anything that reads like forcing a link to inflate a count.
- Deduplicate overlapping proposals across specialists into one approved_changes entry per actual file change.
- For every FIX_AFTER_REVIEW or DO_NOT_CHANGE item, add a rejected_or_deferred entry with why_not_fixed, decision_required, recommended_decision.
- Populate new_copy_french on every FIX_NOW content-rewrite entry with the ACTUAL text from the specialist's proposal (do not just describe it — copy the specialist's new_copy_french / new_question_french / new_answer_french / new_title_french etc. verbatim into this field so implementation agents have exact text to use, not a paraphrase).

TELEMEDICINE SPECIALIST OUTPUT:
${JSON.stringify(telemedicine)}

FINTECH SPECIALIST OUTPUT:
${JSON.stringify(fintech)}

EDTECH SPECIALIST OUTPUT:
${JSON.stringify(edtech)}

TOOL POSITIONING SPECIALIST OUTPUT:
${JSON.stringify(toolPositioning)}

E-E-A-T CITY AUDIT FINDINGS:
${JSON.stringify(eeatFindings)}

LINK EQUITY SPECIALIST FINDINGS:
${JSON.stringify(linkEquity)}

Call StructuredOutput with approved_changes and rejected_or_deferred.`,
    { label: 'lead-architect', phase: 'Lead Architect Review', schema: ARCHITECT_SCHEMA, effort: 'high' }
  )
  return r
}

// ─── Phase 3: Implementation (file-owned groups, worktree-isolated) ──────

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
  const fixNow = approvedChanges.filter(c => c.classification === 'FIX_NOW')
  const byFile = {}
  for (const c of fixNow) {
    const key = c.target_lang_file || c.target_file
    if (!key) continue
    if (!byFile[key]) byFile[key] = []
    byFile[key].push(c)
    // Also group the paired Blade/lang file together under the same owner if both are named.
  }
  // Merge target_file and target_lang_file into one group per logical page so one agent
  // owns both files for a given page (avoids two agents racing on the same page's pair).
  const pageGroups = {}
  for (const c of fixNow) {
    const pageKey = c.target_file || c.target_lang_file
    if (!pageKey) continue
    if (!pageGroups[pageKey]) pageGroups[pageKey] = { files: new Set(), changes: [] }
    pageGroups[pageKey].files.add(c.target_file)
    if (c.target_lang_file) pageGroups[pageKey].files.add(c.target_lang_file)
    pageGroups[pageKey].changes.push(c)
  }

  const entries = Object.entries(pageGroups)
  log(`Implementing ${fixNow.length} FIX_NOW changes across ${entries.length} pages...`)

  const results = await parallel(entries.map(([pageKey, group]) => async () => {
    const files = [...group.files].filter(Boolean)
    return agent(
      `Apply Lead-Architect-approved content changes to the codesommet.com Laravel project at root "${ROOT}". Files involved for this page: ${JSON.stringify(files)}. This is a Blade view paired with a lang/fr/*.php file — the visible French copy usually lives in the lang file via __() calls; find and edit the correct file for each change (do not guess, grep for the lang key first).

APPROVED CHANGES (use the new_copy_french text VERBATIM where provided — this was already reviewed, do not paraphrase or improve it further):
${JSON.stringify(group.changes, null, 2)}

Rules:
- Use the exact new_copy_french / FAQ question/answer text provided. If a change description says to remove a section (e.g. the fintech trading-interface feature card), remove it cleanly without leaving orphaned HTML/Blade structure.
- Preserve all existing HTML structure, Tailwind classes, and styling patterns already used elsewhere on the page — match conventions, don't introduce new ones.
- Do NOT touch any content, section, or link not explicitly listed in the approved changes above.
- Do NOT change the URL slug or route() name for any page — content-only changes.
- Preserve French language quality: natural phrasing, no literal English left in French copy unless intentionally quoting a technical term.
- If a change references a lang key (e.g. 'ml_1217'), find that exact key in the lang file and replace its value; if it references a Blade section instead, edit the Blade file directly.

Before finishing, re-read your own diff mentally: confirm you did NOT touch anything outside this change list, and confirm no HTML/Blade syntax was left broken (matched tags, correct @if/@endif, no stray {{ }}).

Call StructuredOutput with file_edited (the primary file), changes_made, changes_skipped (anything you couldn't safely map to an exact location — explain why), and summary.`,
      { label: `implement:${pageKey.split('/').pop()}`, phase: 'Implement', schema: IMPL_SCHEMA, isolation: 'worktree' }
    )
  }))
  return results.filter(Boolean)
}

// ─── Phase 4: Fresh validation ─────────────────────────────────────────────

const VALIDATION_SCHEMA = {
  type: 'object',
  properties: {
    content_similarity_before_after: { type: 'string' },
    broken_internal_links: { type: 'array', items: { type: 'string' } },
    blade_compiles: { type: 'boolean' },
    tests_passed: { type: 'boolean' },
    test_output_summary: { type: 'string' },
    telemedicine_verdict: { type: 'string' },
    fintech_verdict: { type: 'string' },
    edtech_verdict: { type: 'string' },
    notes: { type: 'string' },
  },
}

async function runValidation(implementationResults) {
  phase('Validate')
  const editedFiles = [...new Set(implementationResults.flatMap(r => [r.file_edited]).filter(Boolean))]
  const r = await agent(
    `You are validating Phase 3 content-differentiation changes just made to codesommet.com (Laravel project at root "${ROOT}"). Fresh, independent validation — do not reuse numbers from any prior report.

Files edited: ${JSON.stringify(editedFiles)}

1. For telemedicine-platform-development vs telemedicine-website-development: read both files' current FAQ sections and pain-point paragraphs. Confirm whether the website page's FAQ still asks about a "plateforme" anywhere, and whether the pain points now read genuinely differently (quote 1-2 short excerpts from each to demonstrate). Give a telemedicine_verdict: "differentiated" / "partially differentiated" / "still duplicated" with evidence.
2. Same check for fintech-platform-development vs fintech-website-development — confirm the trading-interface card is gone from the website page, and pain points read differently. fintech_verdict.
3. Same check for edtech-platform-development vs elearning-platform-development — confirm pain points/FAQ no longer read as a word-swap of each other. edtech_verdict.
4. Grep every edited file for route(' calls, verify against routes/web.php and config/pages.php — report broken_internal_links.
5. Run 'php artisan view:clear' then 'php artisan view:cache' — report blade_compiles.
6. Run the project's test suite (composer test or php artisan test --filter for Seo/Sitemap/Tools tests) — report tests_passed and test_output_summary. If RenderSnapshotTest fails, determine whether it's caused by these content changes (expected, since body copy changed) vs something else — do not blindly update snapshots; report which snapshots would need a reviewed update and why.
7. content_similarity_before_after: your best assessment (qualitative, since no crawler tool is available) of whether telemedicine/fintech/edtech pairs read as genuinely distinct pages now vs before.

Call StructuredOutput with all fields.`,
    { label: 'fresh-validation-phase3', phase: 'Validate', schema: VALIDATION_SCHEMA, effort: 'high' }
  )
  return r
}

// ─── Main ──────────────────────────────────────────────────────────────────

const [inventory, telemedicine, fintech, edtech, toolPositioning, eeatFindings, linkEquity] = await parallel([
  () => runContentInventory(),
  () => runTelemedicineSpecialist(),
  () => runFintechSpecialist(),
  () => runEdtechSpecialist(),
  () => runToolPositioningSpecialist(),
  () => runEEATSpecialist(),
  () => runLinkEquitySpecialist(),
])

const architectReview = await runLeadArchitect(telemedicine, fintech, edtech, toolPositioning, eeatFindings, linkEquity)
const approvedChanges = architectReview ? architectReview.approved_changes : []

const implementationResults = await runImplementation(approvedChanges)
const validation = await runValidation(implementationResults)

return {
  inventory,
  telemedicine,
  fintech,
  edtech,
  toolPositioning,
  eeatFindings,
  linkEquity,
  architectReview,
  implementationResults,
  validation,
  checkpoint: CHECKPOINT,
}
