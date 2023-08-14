<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockFaqAccordion extends Blockable
{
  protected $block_name = 'block_faq_accordion';

  protected $block_title = 'سوالات پر تکرار';

  protected $block_category = 'layout';

  protected $block_icon = 'welcome-learn-more';

  protected $block_keywords = ['faq', 'accordion'];

  /**
   * Callback method that displays the block
   *
   * @param array $block
   * @param string $content
   * @param boolean $is_preview
   *
   * @return void
   */
  public function renderCallback(array $block, string $content = '', bool $is_preview = true): void
  {
    $context['block']      = $block;
    $context['fields']     = get_fields();
    $context['is_preview'] = $is_preview;

    if (!isset($context['fields']['selected_faqs'])) {
      return;
    } else {
      $context['accordionItems'] = $context['fields']['selected_faqs'];
      $context['accordionType'] = 'faq';
    }

    Timber::render('blocks/layout/accordion.twig', $context);
  }
}
