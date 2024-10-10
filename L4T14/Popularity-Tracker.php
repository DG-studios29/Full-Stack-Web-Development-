<?php
/*
Plugin Name: Popularity Tracker
Plugin URI: https://www.hyperiondev.com/
Description: A plugin that keeps track of post views and displays hot posts
Version: 1.1
Author: Dhillan
Author URI: https://www.hyperiondev.com/
License: GPL2
*/

add_action('wp_head', 'popularity_tracker_new_view');
add_action('before_content', 'popularity_tracker_display_top_views');
add_filter('the_content', 'popularity_tracker_display_views');
add_shortcode('hot_posts', 'popularity_tracker_hot_posts_widget');
add_filter('the_content', 'popularity_tracker_display_views');
add_action('save_post', 'popularity_tracker_set_new_post_views');

// Track post views
function popularity_tracker_new_view() {
    if (!is_single()) return null;
    global $post;
    $views = get_post_meta($post->ID, 'popularity_tracker_views', true);
    if (!$views) $views = 0;
    $views++;
    update_post_meta($post->ID, 'popularity_tracker_views', $views);
    return $views;
}


// Display view count at the top of posts
function popularity_tracker_display_top_views() {
    global $post;
    $views = get_post_meta($post->ID, 'popularity_tracker_views', true);
    if (!$views) $views = 0;
    $views_display = popularity_tracker_format_views($views);
    echo '<div style="text-align: center; margin-bottom: 20px;">View count: ' . $views_display . '</div>';
}


// Display view count in post content
function popularity_tracker_display_views($content) {
    global $post;
    $views = get_post_meta($post->ID, 'popularity_tracker_views', true);
    if (!$views) $views = 0;
    $views_display = popularity_tracker_format_views($views);
    $content = '<div style="text-align: center; margin-bottom: 20px;">View count:            ' . $views_display . '</div>' . $content;
    return $content;
}


// Set new posts' view counts to 0
function popularity_tracker_set_new_post_views($post_id) {
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;
    $post_type = get_post_type($post_id);
    if ($post_type != 'post') return;
    $post_status = get_post_status($post_id);
    if ($post_status != 'publish') return;
    $views = get_post_meta($post_id, 'popularity_tracker_views', true);
    if (!$views) {
        update_post_meta($post_id, 'popularity_tracker_views', 0);
    }
}


// Format view count to K (thousands) or M (millions)
function popularity_tracker_format_views($views) {
    if ($views >= 1000000) {
        return round($views / 1000000, 1) . 'M views';
    } elseif ($views >= 1000) {
        return round($views / 1000, 1) . 'K views';
    } else {
        return $views . ' views';
    }
}

// Display hot posts in a widget
function popularity_tracker_hot_posts_widget() {
    $searchParams = [
        'posts_per_page' => 10,
        'post_type' => 'post',
        'post_status' => 'publish',
        'meta_key' => 'popularity_tracker_views',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    ];
    $hot_posts = new WP_Query($searchParams);
    if ($hot_posts->have_posts()) {
        echo '<ol>';
        while ($hot_posts->have_posts()) {
            $hot_posts->the_post();
            $views = get_post_meta(get_the_ID(), 'popularity_tracker_views', true);
            $views_display = popularity_tracker_format_views($views);
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a> - ' . $views_display . '</li>';
        }
        echo '</ol>';
        wp_reset_postdata();
    } else {
        echo 'No hot posts found.';
    }
}

