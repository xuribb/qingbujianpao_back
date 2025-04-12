<?php
function util_encrypt() {}

function util_sign() {}

function util_getAccessToken()
{
    $at = cache("access_token");
    if ($at == null) {
        $APPID = env('APPID');
        $APPSECRET = env('APPSECRET');
        $response = util_request("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$APPID}&secret={$APPSECRET}");
        $response = json_decode($response, true);
        if (@$response['code'] || @$response['errcode']) {
            return json_encode(['code' => 1, 'errmsg' => $response['errmsg']]);
        } else {
            cache("access_token", $response['access_token']);
            return json_encode(['code' => 0, 'data' => $response['access_token']]);
        }
    } else {
        return json_encode(['code' => 0, 'data' => $at]);
    }
}

function util_request($url, $isPOST = false, $data = null)
{
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, $isPOST);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if (env('APP_DEBUG')) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }
    if ($isPOST) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
    }

    $response = curl_exec($ch);
    $errno = curl_errno($ch);
    if ($errno) {
        return json_encode(['code' => $errno, 'errmsg' => curl_error($ch)]);
    }

    curl_close($ch);

    return $response;
}
