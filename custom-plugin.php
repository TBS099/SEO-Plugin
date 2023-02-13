<?php
//  Plugin Name: Custom SEO Title and Description
//  Description: Plugin for a custom seo title and description
//  Author: Tanush Bikram Shah
//  Version:1.0.0
// Text Domain: Custom SEO Title and Description 

if (!defined('ABSPATH')) {
    echo 'ACCESS DENIED';
    exit;
} else {

    // creating custom metabox field
    function custom_metabox()
    {
        add_meta_box("custom_seo_metabox", "SEO Meta", "seo_metabox_field", null, "side");
    }
    add_action('add_meta_boxes', 'custom_metabox');
    //custom metabox field
    function seo_metabox_field()
    {

        ?>
        SEO Title:<br>
        <input type='text' name='seo-title'><br><br>
        SEO Description:<br>
        <input type='textarea' name='seo-description'>
        <?php

    }

    function save_seo_data()
    {
        global $post;

        if (isset($_POST["seo-title"])):

            update_post_meta($post->ID, 'seo_title', $_POST["seo-title"]);

        endif;

        if (isset($_POST["seo-description"])):

            update_post_meta($post->ID, 'seo_description', $_POST["seo-description"]);

        endif;
    }
    add_action('save_post', 'save_seo_data');

    function custom_seo_metadata()
    {
        global $post;

        $seo_description = get_post_meta($post->ID, 'seo_description', true);
        $seo_title = get_post_meta($post->ID, 'seo_title', true);
        echo '<meta name="title" content="' . $seo_title . '">';
        echo '<meta name="description" content="' . $seo_description . '">';
    }
    add_action('wp_head', 'custom_seo_metadata');

}