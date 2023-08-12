<?php
//  親テーマのスタイルをロードする
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style')
);
}

//SVGサポートパーサー
function arrow_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'arrow_mime_types');

//オリジナルカスタマイザー

/**
 * カスタマイザーの設定
 */

use Arkhe_Theme\Customizer;
add_action( 'customize_register', __NAMESPACE__ . '\customizer_setup', 21 );
function customizer_setup( $wp_customize ) {
  Customizer::big_title( 'arkhe_section_global', 'breadcrumb_list',
	array(
		'label' => 'SVGロゴカラーエフェクタ',
	)
  );
  Customizer::add(
    'arkhe_section_global',
    'default_Logo_color',
    array(
      'type' => 'color',
      'label' => 'ロゴカラー',
      'description' => "ロゴのカラーを置き換えることができます。他の設定で上がかれない限りこのカラーが反映します。SVG以外のロゴの場合は反映しません。",
    ),
    
  );
  Customizer::add(
    'arkhe_section_global',
    'default_Logo_color_b',
    array(
      'type' => 'checkbox',
      'label' => 'ロゴカラー変更する',
      'description' => "このチェックをONにするとロゴの色をリライトします",
      'choices' => 'ロゴの色を書き換える',
      'default' => '',
    ),
    
  );
}

add_filter('ark_get__head_logo_img','is_logo');
function is_logo($imgcode){
if(isset( $args['default_Logo_color_b'] )){
  $imgcode = str_replace('<img','<use',$imgcode);
}
return $imgcode;
}

?>