<?php


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;


/**
 * Helper function to initate a get request
 *
 * @param [type] $url
 * @param array $data
 * @param array $headers
 * @param boolean $log
 */
function get(string $url, array $data = [], array $headers = [], bool $log = false)
{
    // Append query parameters to the URL if provided.
    if (!empty($data)) {
        $queryString = http_build_query($data);
        $url .= (strpos($url, '?') === false ? '?' : '&') . $queryString;
    }

    // Define a default User-Agent header.
    $defaultUserAgent = "User-Agent: Mozilla/5.0";

    // Ensure the default User-Agent header is included.
    $hasUserAgent = false;
    foreach ($headers as $header) {
        if (stripos($header, 'User-Agent:') === 0) {
            $hasUserAgent = true;
            break;
        }
    }
    if (!$hasUserAgent) {
        array_unshift($headers, $defaultUserAgent);
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($log) {
        Log::info("GET Request URL: " . $url);
        Log::info("Response: " . $response);
    }
    if ($error) {
        return ['error' => $error];
    }
    $decoded = json_decode($response);
    return $decoded !== null ? $decoded : $response;
}



/**
 * Helper function to return a standardized json response
 *
 * @param [type] $message
 * @param array $data
 * @param integer $status
 * @param integer $code
 * @param boolean $suppress_logging
 * @return void
 */
function result($message, $data = [], $status = 200, $suppress_logging = false)
{
    $error = (!($status == 200 || $status == 201) || ($status == -1));
    $status = ($status == -1) ? 200 : $status;

    if (!empty($data)) {
        $response = [
            'status' => $status,
            'error' => $error,
            'message' => $message,
            'data' => $data
        ];
    } else {
        $response = [
            'status' => $status,
            'error' => $error,
            'message' => $message
        ];
    }

    // Skip logging for sensitive information
    if ($suppress_logging) {
        return response($response, $status);
    }

    if (!request('draw', false) && !request('photoImage', false)) {
        Log::info("Response: " . json_encode($response));
    }

    return response($response, $status);
}



function removeKeysFromObj($obj, array $keysToRemove): object
{
    $data = is_array($obj) ? $obj : (array) $obj;
    // Remove specified keys.
    foreach ($keysToRemove as $key) {
        unset($data[$key]);
    }
    return (object) $data;
}
