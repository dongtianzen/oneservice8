<?php

namespace Drupal\navinfo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Component\Utility\Xss;

use Drupal\navinfo\Content\NavinfoBlockGenerator;

/**
 * Provides a 'Navinfo: navigation' block.
 *
 * @Block(
 *   id = "navinfo_navigation",
 *   admin_label = @Translation("Navinfo: navigation bar")
 * )
 */
class NavinfoNavigationBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $NavinfoBlockGenerator = new NavinfoBlockGenerator();
    $output = $NavinfoBlockGenerator->contentNavigation();

    $admin_tags = Xss::getAdminTagList();
    $admin_tags_plus = [
      'canvas', 'form', 'input', 'label', 'md-button', 'md-content',
      'md-input-container', 'md-menu', 'md-menu-content', 'md-option',
      'md-select', 'md-tab', 'md-tabs',
    ];
    $admin_tags = array_merge($admin_tags, $admin_tags_plus);

    return array(
      '#type' => 'markup',
      '#markup' => $output,
      '#allowed_tags' => $admin_tags,
      '#attached' => array(
        'library' => array(
          'navinfo/navinfo.navbar',
        ),
      ),
    );
  }

}
