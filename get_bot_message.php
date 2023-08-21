<?php
date_default_timezone_set('Africa/Lagos');
require_once 'dbconfig/config.php';

$apiKey = 'YOUR_API_KEY'; // Replace with your actual API key
$baseUrl = 'https://api.botpress.com'; // Replace with the API base URL

$nextToken = 'wwNgQn6tWNR/IHhKGHv/sg9zcIAGsxOk0TfmM+DdmcWkBZrXYjVvcfSZIZSs4ppCr/g=';

$url = "{$baseUrl}/conversations?nextToken={$nextToken}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey
]);

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);

// Check if the response data structure matches the expected format
if (isset($responseData['conversations']) && isset($responseData['meta']['nextToken'])) {
    // Loop through conversations and process each one
    foreach ($responseData['conversations'] as $conversation) {
        // Extract relevant conversation data, assuming your API response format
        $messages = $conversation['messages'];

        // Process each message in the conversation
        foreach ($messages as $message) {
            if ($message['role'] === 'bot') {
                $botResponse = $message['content'];

                // Insert bot response into the database
                $added_on = date('Y-m-d H:i:s'); // Using capital 'H' for 24-hour format
                $type = 'bot';

                $insertQuery = "INSERT INTO message(message, added_on, type) VALUES(:message, :added_on, :type)";
                $insertStatement = $db->prepare($insertQuery);
                $insertStatement->bindParam(':message', $botResponse);
                $insertStatement->bindParam(':added_on', $added_on);
                $insertStatement->bindParam(':type', $type);
                $insertStatement->execute();

                // Display the bot's response to the user
                echo $botResponse . '<br>';
            }
        }
    }
} else {
    // Handle case when the API response structure is not as expected
    
}
?>