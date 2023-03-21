<?php
function sendGPT3Request($prompt, $apiKey, $modelId) {
    // Prepare API request
    $postData = array(
        'prompt' => $prompt,
        'model' => $modelId,
        'max_tokens' => 64,
        'temperature' => 0.5,
        'n' => 1,
        'stop' => '\n'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ));

    // Send API request and get response
    $response = curl_exec($ch);
    curl_close($ch);

    $emailContent = json_decode($response, true);
//    $emailContent = $json['choices'][0]['text'];

    return array(
        'body' => $emailContent
    );
}
?>
