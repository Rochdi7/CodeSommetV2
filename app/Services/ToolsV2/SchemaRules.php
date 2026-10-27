<?php

namespace App\Services\ToolsV2;

/**
 * Propriétés requises et recommandées par type schema.org, d'après la
 * documentation des résultats enrichis Google. Les clés sont des chemins
 * (« offers.price ») et « a|b » signifie « au moins l'un des deux ».
 */
final class SchemaRules
{
    /** @var array<string, array{required: list<string>, recommended: list<string>}> */
    public const RULES = [
        'Article' => ['required' => ['headline', 'image', 'datePublished'], 'recommended' => ['author', 'dateModified', 'publisher', 'description', 'mainEntityOfPage']],
        'NewsArticle' => ['required' => ['headline', 'image', 'datePublished'], 'recommended' => ['author', 'dateModified', 'publisher', 'description']],
        'BlogPosting' => ['required' => ['headline', 'image', 'datePublished'], 'recommended' => ['author', 'dateModified', 'publisher', 'description']],
        'Product' => ['required' => ['name', 'offers|review|aggregateRating'], 'recommended' => ['image', 'description', 'sku', 'brand', 'offers.price', 'offers.priceCurrency', 'offers.availability']],
        'Offer' => ['required' => ['price', 'priceCurrency'], 'recommended' => ['availability', 'url', 'priceValidUntil']],
        'Organization' => ['required' => ['name'], 'recommended' => ['url', 'logo', 'sameAs', 'contactPoint', 'address']],
        'LocalBusiness' => ['required' => ['name', 'address'], 'recommended' => ['telephone', 'openingHoursSpecification', 'geo', 'image', 'priceRange', 'url']],
        'FAQPage' => ['required' => ['mainEntity'], 'recommended' => []],
        'Question' => ['required' => ['name', 'acceptedAnswer'], 'recommended' => []],
        'Answer' => ['required' => ['text'], 'recommended' => []],
        'BreadcrumbList' => ['required' => ['itemListElement'], 'recommended' => []],
        'ListItem' => ['required' => ['position', 'name|item'], 'recommended' => ['item']],
        'WebSite' => ['required' => ['name', 'url'], 'recommended' => ['potentialAction', 'publisher']],
        'WebPage' => ['required' => ['name|headline'], 'recommended' => ['description', 'url', 'isPartOf']],
        'Person' => ['required' => ['name'], 'recommended' => ['url', 'jobTitle', 'sameAs', 'image', 'worksFor']],
        'Event' => ['required' => ['name', 'startDate', 'location'], 'recommended' => ['endDate', 'image', 'description', 'offers', 'performer', 'organizer', 'eventStatus', 'eventAttendanceMode']],
        'Recipe' => ['required' => ['name', 'image'], 'recommended' => ['author', 'datePublished', 'description', 'prepTime', 'cookTime', 'totalTime', 'recipeYield', 'recipeIngredient', 'recipeInstructions', 'aggregateRating', 'nutrition', 'keywords']],
        'VideoObject' => ['required' => ['name', 'thumbnailUrl', 'uploadDate'], 'recommended' => ['description', 'duration', 'contentUrl', 'embedUrl', 'interactionStatistic']],
        'HowTo' => ['required' => ['name', 'step'], 'recommended' => ['image', 'totalTime', 'estimatedCost', 'supply', 'tool', 'description']],
        'HowToStep' => ['required' => ['text|name|itemListElement'], 'recommended' => ['image', 'url']],
        'JobPosting' => ['required' => ['title', 'description', 'datePosted', 'hiringOrganization', 'jobLocation'], 'recommended' => ['validThrough', 'baseSalary', 'employmentType', 'identifier']],
        'Review' => ['required' => ['itemReviewed', 'reviewRating', 'author'], 'recommended' => ['datePublished', 'reviewBody']],
        'AggregateRating' => ['required' => ['ratingValue', 'ratingCount|reviewCount'], 'recommended' => ['bestRating', 'worstRating']],
        'SoftwareApplication' => ['required' => ['name', 'offers', 'aggregateRating|review'], 'recommended' => ['applicationCategory', 'operatingSystem', 'image']],
        'Service' => ['required' => ['name', 'provider'], 'recommended' => ['areaServed', 'description', 'serviceType', 'url']],
        'Course' => ['required' => ['name', 'description', 'provider'], 'recommended' => ['offers', 'hasCourseInstance']],
        'ImageObject' => ['required' => ['contentUrl|url'], 'recommended' => ['license', 'creator', 'creditText']],
        'ItemList' => ['required' => ['itemListElement'], 'recommended' => []],
        'ContactPoint' => ['required' => ['contactType'], 'recommended' => ['telephone', 'email', 'areaServed', 'availableLanguage']],
        'PostalAddress' => ['required' => ['streetAddress|addressLocality'], 'recommended' => ['addressLocality', 'postalCode', 'addressCountry', 'addressRegion']],
    ];

    /** Types dont LocalBusiness est le parent : on applique ses règles. */
    public const LOCAL_BUSINESS_TYPES = [
        'Restaurant', 'Store', 'Dentist', 'Hotel', 'Bakery', 'BarOrPub', 'CafeOrCoffeeShop', 'AutoRepair',
        'HairSalon', 'BeautySalon', 'MedicalClinic', 'Physician', 'LegalService', 'RealEstateAgent',
        'ProfessionalService', 'FinancialService', 'HomeAndConstructionBusiness', 'Plumber', 'Electrician',
        'TravelAgency', 'LodgingBusiness', 'FoodEstablishment', 'HealthAndBeautyBusiness', 'SportsActivityLocation',
    ];

    /** Types « Article » au sens large. */
    public const ARTICLE_TYPES = ['TechArticle', 'ScholarlyArticle', 'Report', 'SocialMediaPosting', 'LiveBlogPosting'];

    /** @return array{required: list<string>, recommended: list<string>}|null */
    public static function for(string $type): ?array
    {
        if (isset(self::RULES[$type])) {
            return self::RULES[$type];
        }
        if (in_array($type, self::LOCAL_BUSINESS_TYPES, true)) {
            return self::RULES['LocalBusiness'];
        }
        if (in_array($type, self::ARTICLE_TYPES, true)) {
            return self::RULES['Article'];
        }

        return null;
    }

    /** Vrai si la propriété (chemin ou alternative « a|b ») est renseignée. */
    public static function has(array $entity, string $spec): bool
    {
        foreach (explode('|', $spec) as $path) {
            $value = $entity;
            foreach (explode('.', $path) as $segment) {
                if (is_array($value) && array_is_list($value)) {
                    $value = $value[0] ?? null;
                }
                if (! is_array($value) || ! array_key_exists($segment, $value)) {
                    $value = null;
                    break;
                }
                $value = $value[$segment];
            }
            if ($value !== null && $value !== '' && $value !== []) {
                return true;
            }
        }

        return false;
    }
}
