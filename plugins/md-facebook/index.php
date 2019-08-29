<?php
/*
Plugin Name: MixtaDrama Theme - Facebook plugin
Plugin URI: https://mixtadrama.com/
Description: Get facebook data
Author: ..
Version: 1.0
*/

$access_token = '';

//$page_id = $wpdb->get_results( "SELECT * FROM $table_name");
$page_id = '';
$url = "https://graph.facebook.com/".$page_id."?fields=id,name,feed{message,attachments{subattachments,media},created_time,permalink_url}%20&access_token=".$access_token ;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSLVERIFYPEER, true);
$json = json_decode(curl_exec($ch) , true);
curl_close($ch);

$img_no = 0;
$uzgur = 0;
$all_imgs_arr = array();

// check if access token has expired
function mixtadrama_check_valid_token() { 
  global $json;
  if ($json['error']['type'] == "OAuthException") { ?>

    <div class="notice notice-error is-dismissible">
    <p>Facebook plugin - Access token has expired. <a href="https://developers.facebook.com/tools/explorer/" target="_blank">Generate new</a></p>

  </div>
  <?php }
  return;
}
add_action('admin_notices', 'mixtadrama_check_valid_token');

// check if transient has expired
function mixtadrama_check_transient() {
  if(($fb_posts = get_transient("fb_post_transient")) === false) 
    { 
      $fb_posts = mixtadrama_get_fb_posts();
      set_transient("fb_post_transient", 'get_fb_posts', 10);
      return $fb_posts;
    }
}
add_action('plugins_loaded' , 'mixtadrama_check_transient')  ;

function mixtadrama_get_fb_posts() {

  global $json;
  global $img_no;
  global $uzgur;
  global $all_imgs_arr;

foreach ( $json['feed']['data'] as $key) {

  $post_imgs = '';
  $fb_message = $key['message'];
  $fb_title = substr( $fb_message, 0 , 10) . '...';
  $fb_post_id = $key['id'];
  $fb_post_url = $key['permalink_url'];

  if ($subAttc = $key['attachments']['data'][0]['subattachments']) {
    foreach($subAttc['data'] as $imgSrc) {
      $img_no++ ;
      $new_img_name =  $fb_post_id . '-img-' . $img_no;
      $new_img_src = $imgSrc['media']['image']['src'];
      $post_imgs .= '<div class="fb-img"><img src="'.$new_img_src.'" alt="'.$new_img_name.'" /></div>';
  }
  $fb_message = $key['message'] . '<div class="fb-imgs">'.$post_imgs.'</div>';
} else if ($subAttc = $key['attachments']['data'][0]['media']) {
  $new_img_name =  $fb_post_id . '-img-' . $img_no;
  $new_img_src = $subAttc['image']['src'];
  $post_imgs .= '<div class="fb-img"><img src="'.$new_img_src.'" alt="'.$new_img_name.'" /></div>';
  $fb_message = $key['message'] . '<div class="fb-imgs">'.$post_imgs.'</div>';
} else {
  $fb_message = $key['message'];
}

  $my_post = array(
    //'ID'            => '345678',
    'post_title'    => $fb_title,
    'post_content'  => $fb_message,
    'post_status'   => 'publish',
    'post_author'   => 1,
    'post_type'     => 'News',
    'post_name'     => $fb_post_id
  );

    $args = array(
      'post_type' => 'News',
      'name'  =>  $fb_post_id,
      'suppress_filters' => false
  ); 
  $posts = get_posts($args);


  $uzgur = array($key);

  if (!$posts) {
    wp_insert_post( $my_post );
    } else {
    return;
  }
} /// end foreach

};  /// end mixtadrama_get_fb_posts

?>