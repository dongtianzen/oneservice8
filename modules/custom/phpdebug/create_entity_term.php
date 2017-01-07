<?php

/**
 *
  require_once(DRUPAL_ROOT . '/modules/custom/phpdebug/create_entity_term.php');
  _run_batch_entity_create_terms();
 */

function _run_batch_entity_create_terms() {
  $vocabulary = array(
    'vid'  => 'province',
  );

  $terms = _entity_terms_info();
  foreach ($terms as $term) {
    _entity_create_terms($term);
  }
}

function _entity_terms_info() {
  $terms = array(
    '北京',
    '上海',
    // '天津',
    // '重庆',
    // '内蒙古',
    // '辽宁',
    // '吉林',
    // '黑龙江',
    // '河北',
    // '山东',
    // '山西',
    // '河南',
    // '江苏',
    // '安徽',
    // '浙江',
    // '江西',
    // '湖北',
    // '湖南',
    // '福建',
    // '广东',
    // '广西',
    // '海南',
    // '贵州',
    // '云南',
    // '四川',
    // '陕西',
    // '甘肃',
    // '宁夏',
    // '青海',
    // '新疆',
    // '西藏',
    // '香港',
    // '澳门',
    // '台湾',
    // '其它地区',
  );

  return $terms;
}

function _entity_create_terms($vocabulary, $term) {
  $term = Term::create([
    'name' => $term,
    'vid'  => $vocabulary['vid'],
  ]);
  $term->save();
}
