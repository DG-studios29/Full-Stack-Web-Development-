<?php
/*
Plugin Name: View Count for Posts
Description: Adds a view count feature to posts.
Version: 1.0
Author: Dhillan
*/

// Function to increment view count with rounding
function increment_view_count($post_id) {
    $count = get_post_meta($post_id, 'view_count', true);
    $count = ($count) ? $count + 1 : 1;
    update_post_meta($post_id, 'view_count', $count);

    // Round the view count
    if ($count >= 1000000) {
        $rounded_count = round($count / 1000000, 1) . 'M';
    } elseif ($count >= 1000) {
        $rounded_count = round($count / 1000, 1) . 'K';
    } else {
        $rounded_count = $count;
    }

    // Update the rounded view count as post meta
    update_post_meta($post_id, 'rounded_view_count', $rounded_count);
}

// Hook into single post view to increment count and round off
add_action('wp_head', 'track_post_views_and_round');
function track_post_views_and_round() {
    if (is_single()) {
        global $post;
        if ($post) {
            increment_view_count($post->ID);
            // Display rounded view count in head section
            $count = get_post_meta($post->ID, 'rounded_view_count', true);
            if ($count) {
                echo '<meta name="rounded-view-count" content="' . esc_attr($count) . '">';
            }
        }
    }
}

// Function to get hot posts
function get_hot_posts() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'meta_key' => 'view_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );
    $hot_posts = new WP_Query($args);
    return $hot_posts;
}

// Shortcode to display hot posts
add_shortcode('hot_posts', 'hot_posts_shortcode');
function hot_posts_shortcode($atts) {
    ob_start();
    $hot_posts = get_hot_posts();
    if ($hot_posts->have_posts()) {
        echo '<ul>';
        while ($hot_posts->have_posts()) {
            $hot_posts->the_post();
            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo 'No hot posts found.';
    }
    wp_reset_postdata();
    return ob_get_clean();
}

// Create Hot Right Now page on plugin activation
register_activation_hook(__FILE__, 'create_hot_right_now_page');
function create_hot_right_now_page() {
    $hot_right_now_page = get_page_by_title('Hot Right Now');
    if (!$hot_right_now_page) {
        $hot_right_now_page_id = wp_insert_post(array(
            'post_title' => 'Hot Right Now',
            'post_content' => '[hot_posts]',
            'post_status' => 'publish',
            'post_type' => 'page'
        ));
    }
}
