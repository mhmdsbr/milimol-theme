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
            'BlockIndustriesTemplate',
            'BlockInsightsTemplate',
            'BlockWorkingAreasTemplate',

           //Headers
            'BlockHomepageHeader',
            'BlockInsightHeader',
            'BlockSplitContentHeader',
            'BlockTrainingHeader',
            'BlockImageHeader',
            'BlockFeaturedInsightHeader',
            'BlockBigVisualHeader',

            // Blocks
            'BlockCasesSlider',
            'BlockSummary',
            'BlockBanner',
            'BlockIntro',
            'BlockImageBanner',
            'BlockImage',
            'BlockFaqAccordion',
            'BlockSplitContent',
            'BlockProcessSlider',
            'BlockVideo',
            'BlockCounter',
            'BlockContent',
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
            'BlockLatestProducts',

        ];
    }
}
