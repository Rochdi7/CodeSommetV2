const fs = require('fs');
const path = require('path');

function walk(target) {
  if (!fs.existsSync(target)) return [];
  const stat = fs.statSync(target);
  if (stat.isFile()) return target.endsWith('.blade.php') ? [target] : [];
  let out = [];
  for (const entry of fs.readdirSync(target)) out = out.concat(walk(path.join(target, entry)));
  return out;
}

function replaceExact(content, replacements) {
  const entries = Object.entries(replacements).sort((a, b) => b[0].length - a[0].length);
  for (const [from, to] of entries) {
    if (content.includes(from)) content = content.split(from).join(to);
  }
  return content;
}

function replaceRegex(content, replacements) {
  for (const [pattern, replacement] of replacements) content = content.replace(pattern, replacement);
  return content;
}

function parseQuoted(value) {
  try {
    return JSON.parse(`"${value.replace(/"/g, '\\"')}"`);
  } catch {
    return value.replace(/\\"/g, '"').replace(/\\'/g, "'").replace(/\\\\/g, '\\');
  }
}

function isSafeKey(from) {
  if (!from) return false;
  if (from.length >= 5) return true;
  return /^(\/month|Week [1-4](?:-[1-4])?|Dubai|Maroc|Paris|London)$/.test(from);
}

function loadQuotedTranslations(files) {
  const map = {};
  const pairRegex = /"((?:\\"|[^"])*)":\s*"((?:\\"|[^"])*)",/g;
  for (const file of files) {
    if (!fs.existsSync(file)) continue;
    const source = fs.readFileSync(file, 'utf8');
    for (const match of source.matchAll(pairRegex)) {
      const from = parseQuoted(match[1]);
      const to = parseQuoted(match[2]);
      if (from && to && isSafeKey(from)) map[from] = to;
    }
  }
  return map;
}

const pageFiles = walk(path.join('resources', 'views', 'pages'));
const extraFiles = [
  path.join('resources', 'views', 'layouts', 'app.blade.php'),
  path.join('resources', 'views', 'partials', 'header.blade.php'),
  path.join('resources', 'views', 'partials', 'header-mobile.blade.php'),
  path.join('resources', 'views', 'partials', 'footer.blade.php'),
  path.join('resources', 'views', 'partials', 'home-testimonials.blade.php'),
  path.join('resources', 'views', 'partials', 'home-sections.blade.php'),
  path.join('resources', 'views', 'partials', 'location-process-steps.blade.php'),
  path.join('resources', 'views', 'partials', 'cal-modal.blade.php'),
].filter((file) => fs.existsSync(file));

const files = [...new Set([...pageFiles, ...extraFiles])];
const serviceFiles = files.filter((file) => file.includes(path.join('pages', 'services') + path.sep));
const locationFiles = files.filter((file) => file.includes(path.join('pages', 'locations') + path.sep));
const toolFiles = files.filter((file) => file.includes(path.join('pages', 'tools') + path.sep));

const repairExact = {
  'transition-transpourm': 'transition-transform',
  'transpourm': 'transform',
  'platepourmes': 'plateformes',
  'platepourme': 'plateforme',
  'platpourms': 'platforms',
  'platpourm': 'platform',
  'conpourmit?': 'conformit?',
  'conpourmes': 'conformes',
  'conpourme': 'conforme',
  'perpourmances': 'performances',
  'perpourmance': 'performance',
  'poureign': 'foreign',
  'bepoure': 'before',
  'afpourd': 'afford',
  'inpourmed': 'informed',
  'pourget': 'forget',
  'pourte intention': 'forte intention',
  'Fait Confiance par': 'Adopt? par',
  'Fait Confiance': 'Adopt?',
  'QuoisApp': 'WhatsApp',
  'Suivant.js': 'Next.js',
};

const globalExact = {
  'Specialized Industry': 'Secteur sp?cialis?',
  'Questions Courantes': 'Questions fr?quentes',
  'Questions Fr?quentes': 'Questions fr?quentes',
  'Questions Fr?quemment Pos?es Sur le D?veloppement Web ?': 'Questions Fr?quemment Pos?es sur le D?veloppement Web ?',
  'Website Development': 'D?veloppement de Site Web',
  'Complete website with AI features, dashboards, and premium design delivered in 7-10 days.': 'Site web complet avec fonctionnalit?s IA, tableaux de bord et design premium livr? en 7 ? 10 jours.',
  'Perfect for businesses needing ongoing AI features, dashboards, and website improvements.': 'Parfait pour les entreprises ayant besoin de fonctionnalit?s IA continues, de tableaux de bord et d?am?liorations de site web.',
  '1 active project at a time': '1 projet actif ? la fois',
  'per project': 'par projet',
  'International Agencies': 'Agences Internationales',
  'Agencies': 'Agences',
  'AI Feature Development': 'D?veloppement de Fonctionnalit?s IA',
  'Contact for Quote': 'Contact pour un devis',
  'What Clients Say About Us': 'Ce que nos clients disent de nous',
  'Clients Say About Us': 'Ce que nos clients disent de nous',
  'View all case studies': 'Voir toutes les ?tudes de cas',
  'View Our Pricing': 'Voir nos tarifs',
  'Explore all our services and offerings': 'Explorez tous nos services et offres',
  'Portfolio de services': 'Portfolio de services',
  'Sites web de conseil professionnels avec vitrines de services et outils de g?n?ration de leads': 'Sites web de conseil professionnels avec vitrines de services et outils de g?n?ration de leads',
  'Audit de Site Web Gratuit': 'Audit Gratuit de Site Web',
  'Free': 'Gratuit',
  'Manual Audit': 'Audit manuel',
  'Website Analyzer': 'Analyseur de site web',
  'Additional cost per audit': 'Co?t suppl?mentaire par audit',
  'Enter URL & Instant Checks': 'Entrez l?URL & v?rifications instantan?es',
  'SEO Analysis': 'Analyse SEO',
  'Security Audit': 'Audit de S?curit?',
  'Why Use This Free Tool?': 'Pourquoi utiliser cet outil gratuit ?',
  '100% Free Forever': '100 % gratuit pour toujours',
  'Ready to analyze your website?': 'Pr?t ? analyser votre site web ?',
  'Get instant insights and a personalized improvement plan in 30 seconds': 'Obtenez des insights instantan?s et un plan d?am?lioration personnalis? en 30 secondes',
  'Website Analyzer vs Manual SEO Audit': 'Analyseur de site web vs audit SEO manuel',
  'Questions Fr?quemment Pos?es': 'Questions fr?quemment pos?es',
  'V?rificateur d\'URL Canonical': 'V?rificateur d?URL canonique',
  'V?rifier l\'URL Canonical': 'V?rifier l?URL canonique',
  'URL de la Page': 'URL de la page',
  'Comment utiliser cet outil': 'Comment utiliser cet outil',
  'Worldwide Web Development Services | CodeSommetStudio': 'Services de d?veloppement web dans le monde entier | CodeSommetStudio',
  'CodeSommetStudio ? We Serve You Wherever You Are': 'CodeSommetStudio ? Nous vous accompagnons o? que vous soyez',
  'Premium web development agency serving clients worldwide. AI-powered websites, dashboards, and SaaS platforms. 50+ projects delivered globally.': 'Agence premium de d?veloppement web au service de clients dans le monde entier. Sites web aliment?s par l?IA, tableaux de bord et plateformes SaaS. Plus de 50 projets livr?s ? l??chelle internationale.',
  'Accepting Projets Worldwide': 'Nous acceptons des projets dans le monde entier',
  'WE SERVE YOU': 'NOUS VOUS SERVONS',
  'YOU ARE': 'O? QUE VOUS SOYEZ',
  'Why Businesses Worldwide Choose CodeSommetStudio': 'Pourquoi les entreprises du monde entier choisissent CodeSommetStudio',
  'Comment Nous Travaillons With Clients Worldwide': 'Comment nous travaillons avec des clients dans le monde entier',
  'Discovery Call': 'Appel d?couverte',
  'Development': 'D?veloppement',
  'Success Stories From Around the World': 'Histoires de r?ussite ? travers le monde',
  'Client based in Germany': 'Client bas? en Allemagne',
  'Client based in UAE': 'Client bas? aux EAU',
  'Frequently Asked Questions': 'Questions fr?quemment pos?es',
  'See the projects we\'ve delivered for clients worldwide.': 'D?couvrez les projets que nous avons livr?s pour des clients dans le monde entier.',
  'Learn about our team, values, and approach.': 'D?couvrez notre ?quipe, nos valeurs et notre approche.',
  'Ready to start? Let\'s discuss your project.': 'Pr?t ? d?marrer ? Parlons de votre projet.',
  'No matter where you are in the world ? let\'s create something exceptional together. Get a free consultation today.': 'O? que vous soyez dans le monde, cr?ons quelque chose d?exceptionnel ensemble. Obtenez une consultation gratuite d?s aujourd?hui.',
  'WhatsApp Business API': 'API WhatsApp Business',
};

const globalRegex = [
  [/>for</g, '>pour<'],
  [/Contactez-nous for your project requirements/g, 'Contactez-nous pour vos besoins de projet'],
  [/Have questions\? We\\'ve got answers\. Here are the most common questions from/g, 'Vous avez des questions ? Nous avons les r?ponses. Voici les questions les plus fr?quentes de'],
  [/Don\\'t just take our word for it\. Hear from businesses in/g, 'Ne nous croyez pas sur parole. ?coutez les entreprises de'],
  [/Frequently Asked Questions About D[?e]veloppement Web in/g, 'Questions Fr?quemment Pos?es sur le D?veloppement Web ?'],
  [/Explore our d[?e]veloppement web services in other cities across the globe/g, 'D?couvrez nos services de d?veloppement web dans d\'autres villes ? travers le monde'],
  [/Discover what makes CodeSommet your ideal d[?e]veloppement web partner/g, 'D?couvrez ce qui fait de CodeSommet votre partenaire id?al en d?veloppement web'],
  [/\* Comparison based on average pricing and service offerings from top 10 agencies in/g, '* Comparaison bas?e sur les prix moyens et les offres de services des 10 meilleures agences ?'],
  [/Morocco-based web development studio serving businesses worldwide\. We build AI-powered websites and intelligent dashboards remotely\. Premium quality websites delivered in 7 days\./g, 'Studio de d?veloppement web bas? au Maroc au service des entreprises du monde entier. Nous cr?ons ? distance des sites web aliment?s par l?IA et des tableaux de bord intelligents. Des sites premium livr?s en 7 jours.'],
  [/Morocco-based d?veloppement web studio serving businesses worldwide\. We build sites web aliment?s par l'IA and tableaux de bord intelligents remotely\. Premium quality websites delivered in 7 days\./g, 'Studio de d?veloppement web bas? au Maroc au service des entreprises du monde entier. Nous cr?ons ? distance des sites web aliment?s par l?IA et des tableaux de bord intelligents. Des sites premium livr?s en 7 jours.'],
  [/Premium web development agency in Morocco specializing in AI-powered websites, intelligent dashboards, and SaaS platforms\. Expert Next\.js development for education, healthcare & business\. 50\+ projects delivered\./g, 'Agence de d?veloppement web premium au Maroc sp?cialis?e dans les sites web aliment?s par l?IA, les tableaux de bord intelligents et les plateformes SaaS. D?veloppement Next.js expert pour l??ducation, la sant? et les entreprises. Plus de 50 projets livr?s.'],
  [/Premium web development agency specializing in AI-powered websites, intelligent dashboards, and SaaS platforms\. 50\+ projects delivered\./g, 'Agence de d?veloppement web premium sp?cialis?e dans les sites web aliment?s par l?IA, les tableaux de bord intelligents et les plateformes SaaS. Plus de 50 projets livr?s.'],
  [/worldwide web development, remote web development agency, global web development services, AI web development, Next\.js development, SaaS development, dashboard development, web agency Morocco/g, 'd?veloppement web mondial, agence de d?veloppement web ? distance, services de d?veloppement web globaux, d?veloppement web IA, d?veloppement Next.js, d?veloppement SaaS, d?veloppement de tableaux de bord, agence web Maroc'],
  [/Morocco-based web development studio serving businesses worldwide\. We build AI-powered websites, dashboards, and SaaS platforms remotely ? no matter where you are\./g, 'Studio de d?veloppement web bas? au Maroc au service d?entreprises du monde entier. Nous cr?ons ? distance des sites web aliment?s par l?IA, des tableaux de bord et des plateformes SaaS, o? que vous soyez.'],
  [/Premium web development agency based in Morocco, delivering AI-powered websites, intelligent dashboards, and SaaS platforms to clients across every continent\./g, 'Agence premium de d?veloppement web bas?e au Maroc, livrant des sites web aliment?s par l?IA, des tableaux de bord intelligents et des plateformes SaaS ? des clients sur tous les continents.'],
  [/Based in Morocco, delivering globally\. We build premium sites web aliment?s par l'IA, tableaux de bord intelligents, and plateformes SaaS for businesses on every continent\. No borders, no limits ? just exceptional digital experiences\./g, 'Bas?s au Maroc, nous livrons partout dans le monde. Nous cr?ons des sites web premium aliment?s par l?IA, des tableaux de bord intelligents et des plateformes SaaS pour des entreprises sur tous les continents. Sans fronti?res, sans limites, uniquement des exp?riences digitales d?exception.'],
  [/We combine Morocco's top talent with world-class processes to deliver premium websites ? remotely, reliably, and on time\./g, 'Nous combinons les meilleurs talents du Maroc avec des processus de niveau international pour livrer des sites premium ? distance, de mani?re fiable et dans les d?lais.'],
  [/No matter your timezone or location ? we adapt our schedule to yours\. Real-time communication via Slack, Zoom, or your preferred tools\./g, 'Quelle que soit votre localisation ou votre fuseau horaire, nous adaptons notre planning au v?tre. Communication en temps r?el via Slack, Zoom ou vos outils pr?f?r?s.'],
  [/We integrate AI chatbots, intelligent search, automated workflows, and smart dashboards into every project we build\./g, 'Nous int?grons des chatbots IA, une recherche intelligente, des workflows automatis?s et des tableaux de bord intelligents dans chaque projet que nous r?alisons.'],
  [/Complex admin panels, analytics dashboards, and multi-tenant plateformes SaaS ? built with Next\.js, React, and TypeScript\./g, 'Panneaux d?administration complexes, tableaux de bord analytiques et plateformes SaaS multi-tenant, con?us avec Next.js, React et TypeScript.'],
  [/Every website we build is designed to convert\. SEO-optimized, fast-loading, and crafted to turn visitors into customers\./g, 'Chaque site web que nous cr?ons est pens? pour convertir. Optimis? pour le SEO, rapide au chargement et con?u pour transformer les visiteurs en clients.'],
  [/From design and development to deployment, SEO, and ongoing support ? we handle everything so you can focus on your business\./g, 'Du design et du d?veloppement jusqu?au d?ploiement, au SEO et au support continu, nous g?rons tout pour que vous puissiez vous concentrer sur votre activit?.'],
  [/Deep expertise in ?ducation, Healthcare, E-commerce, FinTech, Real Estate, and SaaS ? we understand your market\./g, 'Une expertise approfondie en ?ducation, sant?, e-commerce, fintech, immobilier et SaaS : nous comprenons votre march?.'],
  [/We hop on a video call to understand your business, goals, and requirements ? at a time that works for your timezone\./g, 'Nous organisons un appel vid?o pour comprendre votre activit?, vos objectifs et vos besoins, ? un horaire adapt? ? votre fuseau horaire.'],
  [/We create high-fidelity designs in Figma with real-time collaboration\. You see progress daily and give feedback instantly\./g, 'Nous cr?ons des maquettes haute fid?lit? dans Figma avec collaboration en temps r?el. Vous suivez l?avancement chaque jour et donnez vos retours instantan?ment.'],
  [/We build your website with modern tech \(Next\.js, React, TypeScript\)\. You get a staging link to review progress at any time\./g, 'Nous d?veloppons votre site avec des technologies modernes (Next.js, React, TypeScript). Vous recevez un lien de pr?production pour suivre l?avancement ? tout moment.'],
  [/We deploy, optimize for SEO, and provide ongoing support\. Your website is live and performing ? no matter where you are\./g, 'Nous d?ployons, optimisons pour le SEO et assurons un support continu. Votre site est en ligne et performant, o? que vous soyez.'],
  [/Specialized solutions for businesses across every sector, delivered remotely with the same quality as any top agency\./g, 'Des solutions sp?cialis?es pour des entreprises de tous secteurs, livr?es ? distance avec le m?me niveau de qualit? qu?une agence haut de gamme.'],
  [/Real projets livr?s to real businesses ? remotely, on time, and exceeding expectations\./g, 'Des projets r?els livr?s ? de vraies entreprises, ? distance, dans les d?lais et au-del? des attentes.'],
];

const locationRegex = [
  [/View ([^<]+?) Portfolio/g, 'Voir le portfolio de $1'],
  [/How We Helped a ([^<]+?) Real Estate Platform Generate 250\+ Qualified Prospects Monthly/g, 'Comment nous avons aid? une plateforme immobili?re ? $1 ? g?n?rer plus de 250 prospects qualifi?s par mois'],
  [/A growing ([^-]+?)-based property management firm was struggling with manual lead tracking across 150\+ properties\. Their website had no virtual tour capabilities, Arabic language support was poor, and they couldn't integrate with popular ([^.]+?) payment gateways\. Lead response time averaged 48 hours, causing them to lose prospects to competitors\./g, 'Une soci?t? de gestion immobili?re en pleine croissance bas?e ? $1 peinait ? suivre manuellement les leads sur plus de 150 biens. Son site ne proposait pas de visites virtuelles, la prise en charge de l?arabe ?tait faible et elle ne pouvait pas s?int?grer aux passerelles de paiement populaires de $2. Le temps moyen de r?ponse aux prospects atteignait 48 heures, ce qui entra?nait la perte d?opportunit?s face aux concurrents.'],
  [/We built a custom Next\.js property portal with AI-powered search, 360? virtual tours, WhatsApp integration for instant inquiries, and full Arabic localization\. Integrated (.+?) payment gateways, automated lead distribution to agents, and implemented a smart dashboard showing real-time booking analytics\./g, 'Nous avons cr?? un portail immobilier Next.js sur mesure avec recherche aliment?e par l?IA, visites virtuelles ? 360?, int?gration WhatsApp pour les demandes instantan?es et localisation compl?te en arabe. Nous avons int?gr? les passerelles de paiement $1, automatis? la distribution des leads aux agents et mis en place un tableau de bord intelligent affichant les analyses de r?servation en temps r?el.'],
  [/Lead response time reduced from 48hrs to under 2 hours/g, 'Temps de r?ponse aux leads r?duit de 48 h ? moins de 2 heures'],
  [/30% of bookings now come from Arabic-speaking clients/g, '30 % des r?servations proviennent d?sormais de clients arabophones'],
  [/CodeSommet transformed how we manage our properties online\. The virtual tours and WhatsApp integration alone doubled our inquiry rate\. They understood ([^.]+?)'s market perfectly - from payment gateways to Arabic localization\./g, 'CodeSommet a transform? notre mani?re de g?rer nos biens en ligne. Les visites virtuelles et l?int?gration WhatsApp ont ? elles seules doubl? notre taux de demandes. L??quipe a parfaitement compris le march? de $1, des passerelles de paiement ? la localisation en arabe.'],
  [/Ready to Upgrade Your ([^<]+?) Website\?/g, 'Pr?t ? am?liorer votre site web ? $1 ?'],
  [/Do you have a physical office in ([^<]+?)\?/g, 'Avez-vous un bureau physique ? $1 ?'],
  [/Can you work with ([^<]+?) businesses remotely\?/g, 'Pouvez-vous travailler ? distance avec des entreprises de $1 ?'],
  [/What payment methods do you accept in ([^<]+?)\?/g, 'Quels moyens de paiement acceptez-vous ? $1 ?'],
  [/How quickly can you launch a website for my ([^<]+?) business\?/g, 'En combien de temps pouvez-vous lancer un site web pour mon entreprise ? $1 ?'],
  [/Do you understand ([^<]+?) compliance and data protection laws\?/g, 'Comprenez-vous les exigences de conformit? et de protection des donn?es de $1 ?'],
  [/Can you help with \.ae domain registration\?/g, 'Pouvez-vous aider pour l?enregistrement d?un domaine .ae ?'],
  [/Build intelligent chatbots, automation workflows, AI-powered search, and recommendation engines tailored for ([^<]+?)'s tech-savvy audience\./g, 'Cr?ez des chatbots intelligents, des workflows d?automatisation, une recherche aliment?e par l?IA et des moteurs de recommandation adapt?s au public technophile de $1.'],
  [/Design user portals, admin panels, analytics dashboards, and plateformes SaaS that scale with your ([^<]+?) startup\./g, 'Concevez des portails utilisateurs, des panneaux d?administration, des tableaux de bord analytiques et des plateformes SaaS qui ?voluent avec votre startup ? $1.'],
  [/From concept to launch, we handle design, development, testing, and deployment\. No need to coordinate multiple vendors\./g, 'Du concept au lancement, nous g?rons le design, le d?veloppement, les tests et le d?ploiement. Inutile de coordonner plusieurs prestataires.'],
  [/Deep expertise in ([^.]+?) - ([^.]+?)'s fastest-growing sectors\./g, 'Une expertise approfondie dans $1, les secteurs ? la croissance la plus rapide de $2.'],
];

const toolExact = {
  'The full website URL (e.g., https://codesommet.com/services)': 'L?URL compl?te du site web (ex. : https://codesommet.com/services)',
  'Where traffic comes from (e.g., google, newsletter, facebook)': 'Indique d?o? provient le trafic (ex. : google, newsletter, facebook)',
  'Marketing medium (e.g., cpc, email, social, banner)': 'Indique le canal marketing (ex. : cpc, email, social, banner)',
  'Product, promotion, or slogan (e.g., summer_sale, product_launch)': 'Indique le produit, la promotion ou le slogan (ex. : summer_sale, product_launch)',
  'Paid keywords (e.g., running+shoes, ai+websites)': 'Mots-cl?s payants (ex. : running+shoes, ai+websites)',
  'Differentiate ads or links (e.g., logo_link, ad_variant_1)': 'Permet de diff?rencier des annonces ou des liens (ex. : logo_link, ad_variant_1)',
  'Identifies the source of traffic (google, newsletter, facebook)': 'Identifie la source du trafic (google, newsletter, facebook)',
  'Identifies the marketing medium (cpc, email, social, banner)': 'Identifie le canal marketing (cpc, email, social, banner)',
  'Identifies the campaign name (summer_sale, product_launch)': 'Identifie le nom de la campagne (summer_sale, product_launch)',
  'Identifies paid keywords for search campaigns': 'Identifie les mots-cl?s payants pour les campagnes de recherche',
  'Differentiates similar content or links (ad_variant_1, header_cta)': 'Diff?rencie des contenus ou liens similaires (ad_variant_1, header_cta)',
  'Use lowercase and underscores (e.g., summer_sale, not Summer Sale)': 'Utilisez des lettres minuscules et des underscores (ex. : summer_sale, pas Summer Sale)',
  'Be consistent with naming conventions across all campaigns': 'Restez coh?rent dans les conventions de nommage sur toutes les campagnes',
  'Keep URLs under 2000 characters for maximum compatibility': 'Gardez les URL sous 2 000 caract?res pour une compatibilit? maximale',
  'Test your URLs before launching campaigns to ensure proper tracking': 'Testez vos URL avant de lancer des campagnes afin d?assurer un suivi correct',
  'Document your UTM naming conventions for team-wide consistency': 'Documentez vos conventions de nommage UTM pour garantir la coh?rence de toute l??quipe',
};

const serviceTranslations = loadQuotedTranslations(['translate_services.py', 'translate_svc2.py']);

let changedCount = 0;

for (const file of files) {
  let content = fs.readFileSync(file, 'utf8');
  const original = content;

  content = replaceExact(content, repairExact);
  content = replaceExact(content, globalExact);
  content = replaceRegex(content, globalRegex);

  if (serviceFiles.includes(file)) content = replaceExact(content, serviceTranslations);
  if (locationFiles.includes(file)) content = replaceRegex(content, locationRegex);
  if (toolFiles.includes(file)) content = replaceExact(content, toolExact);

  if (content !== original) {
    fs.writeFileSync(file, content, 'utf8');
    changedCount += 1;
    console.log('updated ' + file);
  }
}

console.log('changed ' + changedCount + ' files');

