<?php

namespace Drupal\blockinfo\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Blockinfo: contactus' block.
 *
 * @Block(
 *   id = "blockinfo_contactus",
 *   admin_label = @Translation("Blockinfo: contactus block"),
 * )
 */
class BlockinfoContactusBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $address = NULL;
    $address .= '<div class="text-center">';
      $address .= '<div class="">';
        $address .= $this->t("联系方式");
      $address .= '</div>';
      $address .= '<div class="">';
        $address .= $this->t('地址') . '：' . $this->t('北京市朝阳区南磨房路29号旭捷大厦10层1001室');
        $address .= '<span class="margin-left-12"></span>';
        $address .= $this->t('邮编') . '：100021';
      $address .= '</div>';
      $address .= '<div class="">';
        $address .= $this->t('电话') . '：010-65302100';
        $address .= '<span class="margin-left-12"></span>';
        $address .= $this->t('传真') . '：010-65301636';
        $address .= '<span class="margin-left-12"></span>';
        $address .= $this->t('邮箱') . '：support@onebandsys.com';
      $address .= '</div>';
    $address .= '</div>';

    $build = array(
      '#type' => 'markup',
      '#markup' => $address,
    );

    return $build;
  }
}
