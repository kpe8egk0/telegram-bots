<?php
$key = 'dict.1.1.20160819T080857Z.a21f9f5c92e0e7b9.ab24906e2b9b24a62bede201ca3067abadaf5752';
$text = 'шапка';
$langs = 'ru-en';
//$url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang='.$langs.'&text='.$text, $key);
$url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang='.$langs.'&text='.$text, $key);
$data = json_decode(file_get_contents($url));
/*
for ($i = 0; $i<=4; $i++) {
    $trans[$i] = $data->def[0]->tr[$i]->text;
}
$transfiltered = array_filter ($trans);
$translenght = count($transfiltered);
$result = 'The word "'.$text.'" translates like: '.implode(', ', $transfiltered).'.';
echo $result;
echo '. Array lenght is '.$translenght;
*/
switch ($text) {
    case '/start':
        echo 'start command';
        exit();
    case '/help':
        echo 'help command';
        exit();
    default:
        break;
}
$empt = $data->def[0]->tr[0]->text;
echo $empt;
if (empty($empt))
{
    echo 'empty';
}
if (!empty($empt))
{
    echo 'not empty';
}
echo file_get_contents($url);