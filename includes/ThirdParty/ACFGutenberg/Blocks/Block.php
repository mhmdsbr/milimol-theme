<?php

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use EXP\ThirdParty\ACFGutenberg\Traits\ClassCapturer;

class Block
{
    use ClassCapturer;

    const namespace = __NAMESPACE__;

    static function classNames(): array
    {
        // add your block class name here
        return [
            // Templates
            'BlockHomepageTemplate',
            'BlockServicesTemplate',
            'BlockIndustriesTemplate',
            'BlockInsightsTemplate',
            'BlockTrainingsTemplate',
            'BlockCasesTemplate',
            'BlockCertificationTemplate',
            'BlockVacanciesTemplate',
            'BlockPressReleasesTemplate',
            'BlockWorkingAreasTemplate',
            'BlockCertificationIndustryDetailTemplate',
            'BlockCertificationIndustriesOverviewTemplate',
            'BlockServiceTypeOneTemplate',
            'BlockServiceTypeTwoTemplate',
            'BlockServiceTypeThreeTemplate',
            'BlockIndustryDetailTemplate',

           //Headers
            'BlockHomepageHeader',
            'BlockInsightHeader',
            'BlockSplitContentHeader',
            'BlockTrainingHeader',
            'BlockImageHeader',
            'BlockCertificationProgramHeader',
            'BlockAcademySearchHeader',
            'BlockFeaturedInsightHeader',
            'BlockBigVisualHeader',

            // Blocks
            'BlockContactPerson',
            'BlockCasesSlider',
            'BlockSummary',
            'BlockBanner',
            'BlockValuePropositions',
            'BlockUspAccordion',
            'BlockIntro',
            'BlockImageBanner',
            'BlockImage',
            'BlockFaqAccordion',
            'BlockSplitContent',
            'BlockLinkList',
            'BlockProcessSlider',
            'BlockVideo',
            'BlockCounter',
            'BlockContent',
            'BlockFollowUs',
            'BlockSingleDownload',
            'BlockQuote',
            'BlockPeopleStoriesSlider',
            'BlockMultipleDownloads',
            'BlockLatestInsightSlider',
            'BlockContactForm',
            'BlockAnchorMenu',
            'BlockProcess',
            'BlockHighlights',

            // Listings
            'BlockIndustryListing',
            'BlockLinkedIndustries',
            'BlockServicesListing',
            'BlockLinkedCertificationPrograms',
            'BlockCertificationIndustriesListing',
            'BlockRelatedOrSubServicesListing',
            'BlockLatestProducts',
            'BlockLinkedServices',
            'BlockOfficeListing',
            'BlockUpcomingTrainingsPrograms',

            // Facet WP blocks
            'BlockCertificationProgramsOverviewFacetWP',
            'BlockInsightsOverviewFacetWP',
            'BlockAcademyOverviewFacetWP',
        ];
    }
}
