jQuery(document).ready(function ($) {
  let threadCounter = 0;

  function appendChatMessage(sender, message) {
      const threadId = 'thread-' + threadCounter++;
      const senderClass = sender === 'user' ? 'user-message' : 'ai-message';
      const senderAvatar = sender === 'user' 
          ? '<img src="http://localhost/playground/wp-content/uploads/2025/04/Profile-Site-Icon.jpg" alt="User Avatar" class="chat-avatar user-avatar">' 
          : '<img src="http://localhost/playground/wp-content/uploads/2025/04/4789251.png" alt="AI Avatar" class="chat-avatar ai-avatar">';
      
      const alignment = sender === 'user' ? 'flex-start' : 'flex-end'; // Left for user, right for AI

      const threadHtml = `
          <div id="${threadId}" class="chat-thread" style="display: flex; justify-content: ${alignment}; margin-bottom: 20px;">
              <div class="chat-avatar-container">
                  ${senderAvatar}
              </div>
              <div class="${senderClass}">
                  <strong>${sender === 'user' ? 'You' : 'AI'}</strong>
                  <p>${message}</p>
              </div>
          </div>`;

      $('#chat-log').append(threadHtml);
      $('#chat-log').scrollTop($('#chat-log')[0].scrollHeight);
  }

  // Send message when 'Send' button is clicked
  $('#chat-send').click(function () {
      const userInput = $('#chat-input').val();
      if (!userInput.trim()) return;

      // Append user message with avatar and alignment
      appendChatMessage('user', userInput);

      $('#chat-input').val(''); // Clear the input field

      // Send the user input to the backend API
      $.ajax({
          url: WpAiChatbotData.rest_url,
          method: 'POST',
          data: JSON.stringify({ query: userInput }),
          contentType: 'application/json',
          success: function (response) {
              // Append AI response with avatar and alignment
              appendChatMessage('ai', response.reply);
          }
      });
  });

  // Optional: Allow pressing 'Enter' to send the message as well
  $('#chat-input').on('keypress', function (e) {
      if (e.which === 13) { // Enter key
          $('#chat-send').click();
      }
  });
});
