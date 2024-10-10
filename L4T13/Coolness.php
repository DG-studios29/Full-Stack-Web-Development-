<?php
/*
Plugin Name: Coolness
Plugin URI: https://www.hyperiondev.com/
Description: A plugin that keeps track of post views
Version: 1.1
Author: Dhillan
Author URI: https://www.hyperiondev.com/
Licence: UNLICENCED
*/

function coolness_new_view(){
    if (!is_single()) return null;
    global $post;
    $views = get_post_meta($post->ID, 'coolness_views', true);
    if (!$views) $views = 0;
    $views++;
    update_post_meta($post->ID, 'coolness_views', $views);
    return $views;
}

add_action('wp_head', 'coolness_new_view');

function coolness_views(){
    global $post;
    $views = get_post_meta($post->ID, 'coolness_views', true);
    if (!$views) $views = 0;
    $plural = ($views === 1) ? '' : 's'; // Dynamic plural based on view count
    return "This post has {$views} view{$plural}.";
}

add_action('the_content', 'coolness_display_views');

function coolness_display_views(){
    global $post;
    $views = get_post_meta($post->ID, 'coolness_views', true);
    if (!$views) $views = 0;
    echo '<p style="text-align: center">View count: ' . $views . '</p>';
}

// Set new posts' view counts to 0
function coolness_set_new_post_views($post_id){
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;

    $post_type = get_post_type($post_id);
    if ($post_type != 'post') return;

    $post_status = get_post_status($post_id);
    if ($post_status != 'publish') return;

    $views = get_post_meta($post_id, 'coolness_views', true);
    if (!$views) {
        update_post_meta($post_id, 'coolness_views', 0);
    }
}
add_action('save_post', 'coolness_set_new_post_views');

// Display view count in top posts listing
function coolness_list(){
    $searchParams = [
        'posts_per_page'=>10,
        'post_type'=>'post',
        'post_status'=>'publish',
        'meta_key'=>'coolness_views',
        'orderby'=>'meta_value_num',
        'order'=>'DESC'
    ];
    $list = new WP_Query($searchParams);
    if ($list->have_posts()){
        global $post;
        echo '<ol>';
        while($list->have_posts()){
            $list->the_post();
            $views = get_post_meta($post->ID, 'coolness_views', true);
            echo '<li><a href="'.get_permalink($post->ID).'">';
            the_title();
            echo '</a> - Views: ' . $views;
            echo '</li>';
        }
        echo '</ol>';
    }
}
