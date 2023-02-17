<?php
//  Plugin Name: Custom SEO Title and Description
//  Description: Plugin for a custom seo title and description
//  Author: Tanush Bikram Shah
//  Version:1.0.0
// Text Domain: Custom SEO Title and Description 

if (!defined('ABSPATH')) {
    echo 'ACCESS DENIED';
    exit;
} 

else {

    class seo_title_and_description
    {

        //call functions
        public function __construct()
        {
            add_action('add_meta_boxes',array($this, 'custom_metabox'));
            add_action('save_post',array($this, 'save_seo_data'));
            add_action('wp_head',array($this, 'custom_seo_metadata'));
        }

        // creating custom metabox field
        function custom_metabox()
        {
            add_meta_box("custom_seo_metabox", "SEO Meta", array($this,"seo_metabox_field"), null, "side");
        }

        //custom metabox field
        public function seo_metabox_field()
        {
            $seo_title = get_post_meta(get_the_ID(), 'seo_title', true);
            $seo_description = get_post_meta(get_the_ID(), 'seo_description', true);
            $seo_thumbnail = wp_get_attachment_image_url(get_post_meta(get_the_ID(), 'seo_attachment_id', true));
            ?>
            <form method='post' enctype="multipart/form-data">
            SEO Title:<br>
            <input type='text' name='seo-title' value="<?php echo $seo_title; ?>"><br><br>
            SEO Description:<br>
            <textarea name='seo-description'><?php echo $seo_description; ?></textarea><br><br>
            SEO Thumbnail:<br>
            <?php echo '<img src="' . $seo_thumbnail . '" alt="user profile image" width="70%" height="auto">';?>
            <input type='file' accept='image/png, image/jpeg' name='seo_thumbnail' placeholder='Update Thumbnail'><br><br>
            </form>
            <?php
        }

        //insert or update seo data
        public function save_seo_data()
        {
            global $post;

            if (isset($_POST["seo-title"])):

                update_post_meta($post->ID, 'seo_title', $_POST["seo-title"]);

            endif;

            if (isset($_POST["seo-description"])):

                update_post_meta($post->ID, 'seo_description', $_POST["seo-description"]);

            endif;

            if (!function_exists('wp_generate_attachment_metadata_2')){
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                require_once(ABSPATH . "wp-admin" . '/includes/media.php');
            }
            if ($_FILES) {
                if ($_FILES['seo_thumbnail']['error'] !== UPLOAD_ERR_OK) {
                    return "upload error : " . $_FILES['seo_thumbnail']['error'];
                }
                $attach_id = media_handle_upload( 'seo_thumbnail', get_the_ID() );
                update_post_meta( get_the_ID(), 'seo_attachment_id', $attach_id );
            }
        }

        //show seo data in header of html page
        public function custom_seo_metadata()
        {
            global $post;

            $seo_description = get_post_meta($post->ID, 'seo_description', true);
            $seo_title = get_post_meta($post->ID, 'seo_title', true);
            $seo_thumbnail = wp_get_attachment_image_url(get_post_meta(get_the_ID(), 'seo_attachment_id', true));

            echo '<meta name="title" content="' . $seo_title . '">';
            echo '<meta name="description" content="' . $seo_description . '">';
            echo '<meta name="thumbnail" content="'.$seo_thumbnail.'">';
        }

    }

}
new seo_title_and_description();