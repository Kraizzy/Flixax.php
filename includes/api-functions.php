<?php
function fetchApiData($url) {
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "Accept: application/json\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        return null; // You could log this error if needed
    }

    $data = json_decode($response, true);
    return is_array($data) ? $data : null;
}
