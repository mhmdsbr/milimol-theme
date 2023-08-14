<?php
/**
 * Helper class for custom Contact Gutenberg block
 */

namespace EXP\ThirdParty\ACFGutenberg\Blocks;

use Timber\Timber;
use EXP\ThirdParty\ACFGutenberg\Abstracts\Blockable;


class BlockUspAccordion extends Blockable
{
  protected $block_name = 'block_usp_accordion';

  protected $block_title = 'USP Accordion';

  protected $block_category = 'layout';

  protected $block_icon = 'align-pull-left';

  protected $block_keywords = ['usp', 'accordion'];

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

    if (!isset($context['fields']['selected_usps'])) {
      return;
    } else {
      $context['accordionItems'] = $context['fields']['selected_usps'];
      $context['accordionType'] = 'usp';
    }

    Timber::render('blocks/layout/accordion.twig', $context);
  }
}
