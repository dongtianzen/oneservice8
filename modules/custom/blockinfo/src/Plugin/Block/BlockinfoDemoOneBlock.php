<?php

namespace Drupal\blockinfo\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Blockinfo: demoone' block.
 *
 * @Block(
 *   id = "blockinfo_demo_one",
 *   admin_label = @Translation("Blockinfo: demoone block"),
 * )
 */
class BlockinfoDemoOneBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = array(
      '#type' => 'markup',
      '#markup' => $this->t("This block."),
    );

    return $build;
  }
}
