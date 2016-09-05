<?php

$key = 'dict.1.1.20160819T080857Z.a21f9f5c92e0e7b9.ab24906e2b9b24a62bede201ca3067abadaf5752';
$text = 'инкрустация';
$langs = 'ru-en';
//$url = sprintf('https://translate.yandex.net/api/v1.5/tr.json/getLangs?key=%s&ui=ru', $key);
$url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang=en-ru&text=time', $key);
$data = json_decode(file_get_contents($url));

echo $data->def[0]->text;
//var_dump($data);
//echo '<pre>' . var_export($data, true) . '</pre>';