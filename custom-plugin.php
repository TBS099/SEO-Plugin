<?php
//  Plugin Name: Custom SEO Meta
//  Description: Plugin for a custom seo meta
//  Author: Tanush Bikram Shah
//  Version:1.8.0
// Text Domain: Custom SEO Title and Description 

if (!defined('ABSPATH')) {
    echo 'ACCESS DENIED';
    exit;
} else {

    class seo_title_and_description
    {

        //call functions
        public function __construct()
        {
            add_action('add_meta_boxes', array($this, 'custom_metabox'));
            add_action('save_post', array($this, 'save_seo_data'));
            add_action('wp_head', array($this, 'custom_seo_metadata'));
        }

        // creating custom metabox field
         public function custom_metabox()
        {
            add_meta_box("custom_seo_metabox", "SEO Meta", array($this, "seo_metabox_field"), null, "side");
        }

        //custom metabox field
        public function seo_metabox_field()
        {
            $seo_title = get_post_meta(get_the_ID(), 'seo_title', true);
            $seo_description = get_post_meta(get_the_ID(), 'seo_description', true);
            ?>
            SEO Title:<br>
            <input type='text' name='seo-title' value="<?php echo $seo_title; ?>"><br><br>
            SEO Description:<br>
            <textarea name='seo-description'><?php echo $seo_description; ?></textarea><br><br>
            <?php
        }

        //insert or update seo data
        public function save_seo_data()
        {
            global $post;

            if (isset($_POST["seo-title"])) {

                update_post_meta($post->ID, 'seo_title', $_POST["seo-title"]);

            }

            if (isset($_POST["seo-description"])) {

                update_post_meta($post->ID, 'seo_description', $_POST["seo-description"]);

            }
        }

        //show seo data in header of html page
        public function custom_seo_metadata()
        {
            global $post;

            $seo_description = get_post_meta($post->ID, 'seo_description', true);
            $seo_title = get_post_meta($post->ID, 'seo_title', true);


            echo '<meta name="title" content="' . $seo_title . '">';
            echo '<meta name="description" content="' . $seo_description . '">';

            if (has_post_thumbnail()) {
                $thumbnail = get_the_post_thumbnail_url($post->ID, $size = 'full');
                echo '<meta name="thumbnail" content="' . $thumbnail . '">';
            }
        }

    }

}
new seo_title_and_description();