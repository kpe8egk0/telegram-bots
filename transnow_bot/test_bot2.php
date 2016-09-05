<?php
// https://api.telegram.org/bot261062241:AAHYU1rMeyMW4I0z6bxrwP3HpeaJKLVNXxs/setWebhook?url=https://transnow-ironyman.rhcloud.com/transnow_bot/test_bot2.php
$trans = array();
$source = 'yandex';
$yandex_key = 'dict.1.1.20160819T080857Z.a21f9f5c92e0e7b9.ab24906e2b9b24a62bede201ca3067abadaf5752';

$access_token = '261062241:AAHYU1rMeyMW4I0z6bxrwP3HpeaJKLVNXxs';
$api = 'https://api.telegram.org/bot' . $access_token;

$input_json = file_get_contents('php://input');
$output = json_decode($input_json, TRUE);

$chat_id = $output['message']['chat']['id'];
$message = $output['message']['text'];
$username = $output['message']['from']['username'];
$lang = 'ru-en';

$url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang=%s&text=%s', $key, $lang, $message);
$data = json_decode(file_get_contents($url));
for ($i = 0; $i<=4; $i++) {
    $trans[$i] = $data->def[0]->tr[$i]->text;
}
$transfiltered = array_filter ($trans);
$reply = 'Dear '.$username.'! The word "'.$message.'" translates like: '.implode(', ', $transfiltered).'. The translated array length is '.count($transfiltered).'.';
file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($reply));
echo $reply;
exit();