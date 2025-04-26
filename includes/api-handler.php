<?php

add_action('rest_api_init', function () {
    register_rest_route('api/v1', '/chatbot-query', [
        'methods' => 'POST',
        'callback' => 'custom_api_handle_chatbot_query',
        'permission_callback' => '__return_true', // Make sure this is safe for your setup, adjust as needed.
    ]);
});

function custom_api_handle_chatbot_query($request) {
    // Get the query parameter sent from the front end
    $query = sanitize_text_field($request->get_param('query'));

    // Search the 'chatbot-memory' post type for relevant posts
    $posts = get_posts([
        'post_type' => 'chatbot-memory',
        // 's' => $query,
        'posts_per_page' => -1, // Return the top 5 posts
    ]);

    // If no posts are found, return a fallback response
    if (empty($posts)) {
        return new WP_REST_Response(['reply' => 'Sorry, I couldn’t find anything relevant.'], 200);
    }

    // Concatenate the content of the found posts for summarization
    $content = '';
    foreach ($posts as $post) {
        $content .= "Title: {$post->post_title}\nContent: {$post->post_content}\n\n";
    }

    // Send the content to the AI service (Gemini API) for summarization
    $summary = custom_api_get_ai_response($content, $query);

    // Return the summarized response to the frontend
    return new WP_REST_Response(['reply' => $summary], 200);
}

// Function to send the request to Gemini API for content summarization
function custom_api_get_ai_response($content, $query) {
    include_once( WP_PLUGIN_DIR . '/wp-ai-chatbot/includes/apikey.php' );
    $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $api_key;

    // Create the prompt for the AI model
    $prompt = "Using the following content:\n\n$content\n\nSummarize this and answer the query:\n\n$query \n\n Only Provide answer that is relevant to user query. dont use any type of encoding or ****";

    // Make the request to the Gemini API
    $response = wp_remote_post($endpoint, [
        'headers' => ['Content-Type' => 'application/json'],
        'body' => json_encode([
            'contents' => [[
                'parts' => [[ 'text' => $prompt ]]
            ]]
        ]),
        'timeout' => 20,
    ]);

    // Check if the request was successful
    if (is_wp_error($response)) {
        return 'Error occurred while calling the AI service.';
    }

    // Parse the response from Gemini API
    $body = json_decode(wp_remote_retrieve_body($response), true);

    // Return the AI-generated summary
    return isset($body['candidates'][0]['content']['parts'][0]['text']) ?
        trim($body['candidates'][0]['content']['parts'][0]['text']) :
        'The AI service did not return a valid response.';
}