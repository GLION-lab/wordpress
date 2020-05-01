<?php
/**
 * Theme Functions
 *
 * @package wp-headless
 */

// taxonomyを追加
function add_taxonomy() {
  // ピックアップを追加
  register_taxonomy(
    'pickup', //タクソノミースラッグ
    'post', //利用する投稿タイプ（通常の投稿の場合は「post」、固定ページの場合は「page」）
    array(
      'label' => 'ピックアップ',
      'singular_label' => 'pickup',
      'labels' => array(
        'all_items' => 'ピックアップ一覧',
        'add_new_item' => 'ピックアップを追加'
      ),
      'public' => true,
      'show_in_rest' => true,
      'show_ui' => true,
      'show_in_nav_menus' => true,
      'rest_base' => 'pickups',
      'hierarchical' => true //階層を持たせる場合は「true」、持たせない場合は「false」
    )
  );
}
add_action( 'init', 'add_taxonomy' );

// CORS対策
function cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}
add_action('send_headers', 'cors_http_header');

// nonce生成
function custom_preview_page_link($link) {
  global $post;
  $id = $post->ID;
  // $prefix = $post->post_type;
  // $id = get_the_ID();
  $nonce = wp_create_nonce('wp_rest');
  $link = 'http://localhost:8000/preview/?id='. $id. '&_wpnonce='. $nonce;
  return $link;
}
add_filter('preview_post_link', 'custom_preview_page_link');

// workaround script until there's an official solution for https://github.com/WordPress/gutenberg/issues/13998
function fix_preview_link_on_draft() {
  global $post;
  $id = $post->ID;
  $nonce = wp_create_nonce('wp_rest');
  $link = 'http://localhost:8000/preview/?id='. $id. '&_wpnonce='. $nonce;
  echo '<script type="text/javascript">
    jQuery(document).ready(function () {
      const checkPreviewInterval = setInterval(checkPreview, 1000);
      function checkPreview() {
        const editorPreviewButton = jQuery(".editor-post-preview");
        if (editorPreviewButton.length && editorPreviewButton.attr("href") !== "' . $link . '" ) {
          editorPreviewButton.attr("href", "' . $link . '");
          editorPreviewButton.off();
          editorPreviewButton.click(false);
          editorPreviewButton.on("click", function() {
            setTimeout(function() { 
              const win = window.open("' . $link . '", "_blank");
              if (win) {
                win.focus();
              }
            }, 1000);
          });
        }
      }
    });
  </script>';
}
add_action('admin_footer', 'fix_preview_link_on_draft');

// add_filter( 'rest_prepare_revision', function( $response, $post ) {
//   $data = $response->get_data();
//   $data['acf'] = get_fields( $post->ID );

//   return rest_ensure_response( $data );
// }, 10, 2 );

// function custom_preview_page_link( $link ) {
// 	$id = get_the_ID();
// 	// For authentication a nonce must be created
// 	// otherwise the REST API does not allow users to see previews
// 	$nonce = wp_create_nonce( 'wp_rest' );
// 	$post = get_post( $id );
// 	$slug = $post->post_name;
// 	$lang = '';
// 	$isPost = '';

// 	// if we preview a post, we want to add 'posts/' to the url to link to our posts site in the frontend
// 	// TODO this URL schould be dynamicly the same for back- and frontend
// 	if ($post->post_type === 'post') {
// 		$isPost = '';
// 	}

// 	// if we have a new page without a slug we show /preview/ as a page
// 	if ($slug === '') {
// 		$slug = 'preview';
// 	}

// 	// Get the language of the polylang custom field
// 	// https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/
// 	$current_lang = pll_get_post_language( $id );
// 	$default_lang = pll_default_language( 'slug' );

// 	// Only add a language if it's not the default language
// 	if ($current_lang !== $default_lang) {
// 		$lang = $current_lang . '/';
// 	}

// 	/* make sure WP_HOME (wp-config.php) always has exactly one trailing slash.
// 	Remove if it has multiple then add one or add one if it has no slash */
// 	$home_path = rtrim(WP_HOME, '/') . '/';
// 	$link = $home_path . $lang . $isPost . $slug . '/?preview_id='. $id. '&preview_nonce=' . $nonce . '&preview=true';
// 	return $link;
// }
// add_filter('preview_post_link', 'custom_preview_page_link');
