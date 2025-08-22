<?php
//function decryptData() {
//    private $appid;
//    private $sessionKey;
//}

function request($url, $isPOST = false, $data = null)
{
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
        return json_encode(['code' => 0, 'errmsg' => curl_error($ch)], JSON_UNESCAPED_UNICODE);
    }

    curl_close($ch);
    return json_decode($response, true);
}
