<?php
// https://api.telegram.org/bot261062241:AAHYU1rMeyMW4I0z6bxrwP3HpeaJKLVNXxs/setWebhook?url=https://transnow-ironyman.rhcloud.com/transnow_bot/test_bot2.php

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

sendMessage($chat_id, $message);
$article_from_source = getArticleFromSource($source, $lang, $message, $yandex_key);
sendMessage($chat_id, $article_from_source);
exit();

function sendMessage($chat_id, $message)
{
    file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message));
}

function getArticleFromSource($source, $lang, $input_text, $key)
{
    $url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang='.$langs.'&text='.$text, $key);
 $data = file_get_contents($url);
    //   $data = json_decode(file_get_contents($url));
    for ($i = 0; $i<=4; $i++) {
        $trans[$i] = $data->def[0]->tr[$i]->text;
    }
    $transfiltered = array_filter ($trans);
    $json_data = 'The word "'.$text.'" translates like: '.implode(', ', $transfiltered).'.';
    return $json_data;
}