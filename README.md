# WP AI Chatbot

A WordPress plugin that integrates an AI chatbot powered by the Gemini API. It uses a custom post type called `chatbot-memory` to store knowledge and respond to user queries. The plugin enables seamless interaction with the AI via a shortcode, allowing dynamic responses based on the content stored in the `chatbot-memory` post type.

## Features

- Custom post type `chatbot-memory` for storing chatbot knowledge.
- Tags support for categorizing memories.
- Seamless integration with the Gemini API for content summarization.
- Fully customizable chatbot UI with avatars for both user and AI.
- Shortcode support for easy integration into any page or post.
- Support for REST API queries to fetch relevant chatbot memories and summarize responses.

## Installation

### 1. Download the Plugin
Download the plugin files or clone this repository into your WordPress `wp-content/plugins/` directory.

### 2. Install and Activate the Plugin
1. Go to your WordPress Admin Dashboard.
2. Navigate to **Plugins → Add New → Upload Plugin**.
3. Select the downloaded zip file and click **Install Now**.
4. After the installation is complete, click **Activate**.

### 3. Register the Custom Post Type and Tags
- After activation, the plugin will automatically register the `chatbot-memory` post type and enable tags for this custom post type.
- Go to **Chatbot Memory → Add New** to start adding memories for your chatbot.

### 4. Configure the API Key
The plugin requires an API key to integrate with the Gemini API for summarization. To keep your API key secure and prevent it from being exposed in version control, follow these steps:

1. Create a new file called `apikey.php` in the `includes/` directory of the plugin.
2. In the `apikey.php` file, add the following code:

    ```php
    <?php
    $api_key = 'YOUR_API_KEY'; // Replace with your Gemini API key
    ```

3. Replace `'YOUR_API_KEY'` with your actual Gemini API key.
4. Do not commit this file to version control (e.g., GitHub). Add it to `.gitignore` to prevent it from being pushed to the repository.

    Example `.gitignore` entry:
    ```bash
    includes/apikey.php
    ```

5. Ensure that `apikey.php` is included securely in your plugin files:

    ```php
    include_once( WP_PLUGIN_DIR . '/wp-ai-chatbot/includes/apikey.php' );
    ```

### 5. Use the Shortcode
To display the chatbot on any page or post, simply add the following shortcode:

```shortcode
[wp_ai_chatbot]
```

This will render the chatbot interface on the front end of your site.

## Usage

### Adding New Memories
1. Go to **Chatbot Memory → Add New** in your WordPress Admin Panel.
2. Enter a title and content for your memory. The content will be the knowledge or answer that the chatbot will use to respond to user queries.
3. Optionally, add tags to help categorize the chatbot memories.
4. Click **Publish**.

### Chatbot Interaction
Once you’ve added some memories, visit the page where you’ve placed the shortcode `[wp_ai_chatbot]`. You can start interacting with the chatbot by typing in the input field. The chatbot will summarize the content of relevant memories based on your query and provide a response.

### Chatbot Configuration
- **API Key**: Configure the Gemini API key in the `apikey.php` file.
- **Avatars**: Set a user avatar (Gravatar) and a bot avatar (custom AI image URL) for a more personalized experience.

## Customizing the Plugin

- **CSS Customization**: Modify the chatbot UI using the `assets/chatbot.css` file.
- **JavaScript Customization**: Change chatbot behavior or add features using the `assets/chatbot.js` file.
- **API Integration**: Update the `custom_api_get_ai_response()` function in `includes/api-handler.php` to modify the API request.

## Contributing

Contributions are welcome! Please fork this repository, make changes, and submit a pull request.

### Steps to Contribute:
1. Fork the repository.
2. Create a new branch:
    ```bash
    git checkout -b feature/your-feature
    ```
3. Commit your changes:
    ```bash
    git commit -am 'Add some feature'
    ```
4. Push to the branch:
    ```bash
    git push origin feature/your-feature
    ```
5. Create a new pull request.

## License

This project is licensed under the MIT License - see the `LICENSE.md` file for details.

## Example of Use in a Page/Post

Add the shortcode `[wp_ai_chatbot]` wherever you want the chatbot to appear:

```html
<div class="chatbot-container">
     <h2>Ask the Chatbot:</h2>
     [wp_ai_chatbot]
</div>
```

## FAQ

### 1. How do I add memories to the chatbot?
Go to the **Chatbot Memory** menu in your admin panel and add a new post with a title and content. You can also add tags for better categorization.

### 2. Can I change the AI model?
The plugin uses the Gemini API for summarization. If you wish to change the AI model, you can modify the API call in the `custom_api_get_ai_response()` function in `includes/api-handler.php`.

### 3. How do I customize the appearance of the chatbot?
Modify the `assets/chatbot.css` file to change the look and feel of the chatbot UI (e.g., colors, avatars, fonts).

## API Key Security

**IMPORTANT**: Your Gemini API key is stored in the `includes/apikey.php` file. This file should never be committed to GitHub or version control. Ensure that you add `apikey.php` to your `.gitignore` file to prevent it from being accidentally exposed.

### Steps to Add Your API Key:
1. Create the `apikey.php` file inside the `includes/` folder.
2. Paste your API key into the file as follows:

    ```php
    <?php
    $api_key = 'YOUR_API_KEY';
    ```

3. Add `apikey.php` to your `.gitignore` file:

    ```bash
    includes/apikey.php
    ```
