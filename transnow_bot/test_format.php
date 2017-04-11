<?php
$msg = 'шла саша по шоссе';
$key = 'trnsl.1.1.20160906T144940Z.7b9bdff453462ecd.bcabb5b47a3afe432e57931793362ad73e47898f';
echo detectInputLang($msg, $key);

function detectInputLang($message, $key)
{
    //hint - это предполагаемые языки. Пока что оставил en, ru. Можно подумать над этим моментом ещё.
    $url = sprintf('https://translate.yandex.net/api/v1.5/tr.json/detect?hint=en,ru&key=%s&text=%s', $key, $message);
    $json_data = file_get_contents($url);
    $data = json_decode($json_data);
    $result = $data->lang;
    return $result;
}

function getArticleFromSource($source, $lang, $input_text, $key)
{
$json_data = '';
    switch ($source) {
        case 'yandex_trans':
            $url = sprintf('https://translate.yandex.net/api/v1.5/tr.json/translate?key=%s&lang=%s&text=%s', $key, $lang, $input_text);
            $json_data = file_get_contents($url);
            break;
        case 'yandex_dict':
            $url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang=%s&text=%s', $key, $lang, $input_text);
            $json_data = file_get_contents($url);
            break;
        default:
            break;
    }

    return $json_data;
}