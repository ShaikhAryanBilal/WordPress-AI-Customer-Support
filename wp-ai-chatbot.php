<?php
/*
Plugin Name: WP AI Chatbot
Description: AI chatbot using custom post type "chatbot-memory" and powered by an external API
Version: 1.0
Author: Shaikh Aryan Bilal
*/

defined('ABSPATH') || exit;

// Include the API handler file for backend logic
require plugin_dir_path(__FILE__) . 'includes/api-handler.php';

// Register custom post type for chatbot-memory
add_action('init', function () {
    register_post_type('chatbot-memory', [
        'label' => 'Chatbot Memory',
        'description' => 'A custom post type for storing chatbot memories.',
        'public' => false, // Set this to false if you don’t want the post type to be publicly accessible.
        'show_ui' => true, // Show the post type in the WordPress admin panel
        'show_in_rest' => true, // Ensure it's available in REST API
        'supports' => ['title', 'editor'], // Supports title and editor for the post content
        'menu_icon' => 'dashicons-format-chat', // Icon for the post type in the admin menu
        'has_archive' => false, // This is not an archive-based post type
        'taxonomies' => ['post_tag'], // Enable tags for this post type
    ]);
});

// Register shortcode to display chatbot
add_shortcode('wp_ai_chatbot', function () {
    ob_start();
    ?>
    <div id="ai-chatbox">
        <div id="chat-log"></div>
        <div style="display: flex; gap: 10px;">
            <input type="text" id="chat-input" placeholder="Ask something...">
            <button id="chat-send">Send</button>
        </div>
    </div>
    <?php
    return ob_get_clean();
});

// Enqueue the CSS and JS files
add_action('wp_enqueue_scripts', function () {
    // Enqueue chatbot CSS
    wp_enqueue_style('wp-ai-chatbot-css', plugin_dir_url(__FILE__) . 'assets/chatbot.css');

    // Enqueue chatbot JavaScript
    wp_enqueue_script('wp-ai-chatbot-js', plugin_dir_url(__FILE__) . 'assets/chatbot.js', ['jquery'], null, true);

    // Localize the script to pass AJAX URL and nonce
    wp_localize_script('wp-ai-chatbot-js', 'WpAiChatbotData', [
        'rest_url' => esc_url_raw(rest_url('api/v1/chatbot-query')),
        'nonce' => wp_create_nonce('wp_rest'),
    ]);
});
