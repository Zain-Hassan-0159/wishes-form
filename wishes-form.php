<?php
/**
 * Plugin Name:       Wishes Form
 * Description:       Wishes Form is created by Zain Hassan.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Zain Hassan
 * Author URI:        https://hassanzain.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wishes-form 
*/

if(!defined('ABSPATH')){
    exit;
}


add_action( 'init', 'create_post_type_wishes' );
add_action( 'gform_after_submission', 'save_post_data', 10, 2 );
add_action( 'elementor/elements/categories_registered', 'custom_category_elementor_wishes' );
add_action( 'elementor/widgets/register', 'register_wishes_elementor_widgets' );


// Define custom post type function
function create_post_type_wishes() {
  register_post_type( 'wishes_submission',
    array(
      'labels' => array(
        'name' => __( 'Wishes' ),
        'singular_name' => __( 'Wish' )
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'wishes_submission'),
      'supports' => array( 'title', 'editor', 'thumbnail' )
    )
  );

  add_submenu_page(
    'edit.php?post_type=wishes_submission',
    'Wishes Form Setting',
    'Wishes Form Setting',
    'manage_options',
    'wishes_submission_settings',
    'wishes_submission_settings_page'
  );
}

function wishes_submission_settings_page() {

  // Code for your settings page goes here
  if (isset($_POST['form_id'])) {
    update_option('wishes_form_id', sanitize_text_field($_POST['form_id']));
    update_option('wishes_first_name_id', sanitize_text_field($_POST['first_name']));
    update_option('wishes_content_id', sanitize_text_field($_POST['content']));
    update_option('wishes_image_id', sanitize_text_field($_POST['image']));
  }
  ?>
  <form action="" method="post">
    <p>
      <label for="form_id">Form ID</label>
      <input type="number" name="form_id" id="form_id" value="<?php echo esc_attr(get_option('wishes_form_id')); ?>"> 
    </p>
    <p>
      <label for="first_name">Name Label</label>
      <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr(get_option('wishes_first_name_id')); ?>"> 
    </p>
    <p>
      <label for="content">Content Label</label>
      <input type="text" name="content" id="content" value="<?php echo esc_attr(get_option('wishes_content_id')); ?>"> 
    </p>
    <p>
      <label for="image">Image Label</label>
      <input type="text" name="image" id="image" value="<?php echo esc_attr(get_option('wishes_image_id')); ?>"> 
    </p>
    <input type="submit" value="Save">
  </form>
  <?php
}

// Save form data as post
function save_post_data( $entry, $form ) {

  $entries = array(
    'first_name' => '',
    'last_name' => '',
    'content' => '',
    'image' => '',
  );
  $form = GFAPI::get_form(esc_attr(get_option('wishes_form_id')));

  if (!is_wp_error($form)) {
    foreach ($form['fields'] as $field) {
      $field_id = $field->id;
      $field_label = $field->label;
      $field_type = $field->type;
      if($field_label == esc_attr(get_option('wishes_content_id'))){
        $entries['content'] = $field_id;
      }else
      if($field_label == esc_attr(get_option('wishes_image_id'))){
        $entries['image'] = $field_id;
      }else      
      if($field_type == 'name'){
        $entries['first_name'] = $field->inputs[1]['id'];
        $entries['last_name'] = $field->inputs[3]['id'];
      }
      // Do something with the field ID
    }
    // echo "<pre>";
    // print_r($entry);
    if($entry['form_id'] == esc_attr(get_option('wishes_form_id')) && !empty($entries) ){
      $name = rgar( $entry, $entries['first_name'] ) . " " . rgar( $entry, $entries['last_name'] );
      $post_args = array(
        'post_title' => $name, // use the 'Title' field value for the post title
        'post_content' => rgar( $entry, $entries['content'] ), // use the 'Message' field value for the post content
        'post_type' => 'wishes_submission', // use the 'custom_post' post type
        'post_status' => 'publish' // set the post status to 'publish'
      );
    
      // Create the post
      $post_id = wp_insert_post( $post_args );
    
      // Set the featured image (if available)
      $image_url = rgar( $entry, $entries['image'] );
      $image_url = explode( '|', $image_url )[0];
      $image_url = explode( '|', $image_url )[0];
      if ( ! empty( $image_url ) ) {
        $image_id = gf_add_image_from_url( $image_url, $post_id );
        if ( $image_id ) {
          set_post_thumbnail( $post_id, $image_id );
        }
      }
    }
  }

}
  

function gf_add_image_from_url( $url, $post_id ) {
  // Download the image from the URL
  $response = wp_remote_get( $url );
  if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
    print_r( $url);

    return false;
  }
  $image_data = wp_remote_retrieve_body( $response );

  // Get the file extension from the URL
  $path_parts = pathinfo( $url );
  $extension = $path_parts['extension'];

  // Generate a unique filename for the image
  $filename = md5( $url ) . '.' . $extension;

  // Save the image to the uploads directory
  $upload_dir = wp_upload_dir();
  $filepath = $upload_dir['path'] . '/' . $filename;
  file_put_contents( $filepath, $image_data );

  // Create the attachment object
  $attachment = array(
    'guid'           => $upload_dir['url'] . '/' . $filename,
    'post_mime_type' => 'image/' . $extension,
    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
    'post_content'   => '',
    'post_status'    => 'inherit'
  );

  // Insert the attachment into the database
  $attachment_id = wp_insert_attachment( $attachment, $filepath, $post_id );

  // Set the image as the featured image for the post
  update_post_meta( $post_id, '_thumbnail_id', $attachment_id );

  return $attachment_id;
}

function custom_category_elementor_wishes( $elements_manager ) {

	$elements_manager->add_category(
		'el-wishes',
		[
			'title' => esc_html__( 'Wishes', 'wishes-form' ),
			'icon' => 'fa fa-plug',
		]
	);
}

function register_wishes_elementor_widgets( $widgets_manager ) {
  require_once( __DIR__ . '/inc/wishes.php' );
  $widgets_manager->register( new \wishes_widget_elementore );
}


