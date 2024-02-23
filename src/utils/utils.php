<?php

function callApi($method, $url, $data = null)
{
    $curl = curl_init();

    switch ($method) {
        case "POST":

            curl_setopt($curl, CURLOPT_POST, true);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;

        case "PUT":

            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            break;

        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }


    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    $tokenHeader = array(
        'Content-Type:application/json'
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $tokenHeader);

    $result = curl_exec($curl);

    if (curl_errno($curl)) {
        return false;
    }

    curl_close($curl);

    return $result;
}

function startsWith($haystack, $needles) {
    if(!is_array($needles)) $needles = [$needles];
    foreach ($needles as $needle) {
        if (substr($haystack, 0, strlen($needle)) === $needle) {
            return true;
        }
    }
    return false;
}