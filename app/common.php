<?php
function request($url, $data = null, $isPOST = false)
{
    if ($isPOST == false && !is_null($data)) {
        $url .= '?' . http_build_query($data);
    }
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, $isPOST);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    if ($isPOST) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
    }

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $response = ['code' => 0, 'msg' => curl_error($ch)];
    } else {
        $response = json_decode($response, true);
    }

    curl_close($ch);
    return $response;
}

function weather($url, $data = null)
{
    if (!is_null($data)) {
        $url .= '?' . http_build_query($data);
    }
    $url = "https://ku4up3t22a.re.qweatherapi.com" . $url;
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept-Encoding: gzip, deflate'
    ]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-QW-Api-Key: " . env("APIKEY", '')
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $response = ['code' => 0, 'msg' => curl_error($ch)];
    } else {
        $response = json_decode($response, true);
    }

    curl_close($ch);
    return $response;
}
