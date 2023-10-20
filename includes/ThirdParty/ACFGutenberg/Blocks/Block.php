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
            'BlockWorkingAreasTemplate',

           //Headers
            'BlockImageHeader',

            // Blocks
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
            'BlockMultipleDownloads',
            'BlockRequestsSlider',
            'BlockContactForm',
            'BlockAnchorMenu',
            'BlockProcess',
            'BlockAdvertisements',
            'BlockFollowUs',

            // Listings
            'BlockCompanyListing',
            'BlockLatestProducts',
            'BlockRequestsListing',

        ];
    }
}
