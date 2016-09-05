<?php
$key = 'dict.1.1.20160819T080857Z.a21f9f5c92e0e7b9.ab24906e2b9b24a62bede201ca3067abadaf5752';
$text = 'fuck';
$langs = 'en-ru';
//$url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang='.$langs.'&text='.$text, $key);
$url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang='.$langs.'&text='.$text, $key);
$data = json_decode(file_get_contents($url));
/*
// Забираем в массив до 5 вариантов перевода
for ($i = 0; $i<=4; $i++){
    $trans[$i] = $data->def[0]->tr[$i]->text;
}
//убираем пустые значения из массива и считаем его длину
$transfiltered = array_filter ($trans);
$translenght = count($transfiltered);
//выдаём не пустые значения перевода через запятую
for ($j = 0; $j <= $translenght-1; $j++) {
    echo $transfiltered[$j];
    if ($j!=$translenght-1){
        echo ', ';
    }
    }
echo '.';
}
*/
/* Натужная попытка сделать через foreach
foreach ($data->def[0]->tr as $value){
    $trans = $value->text;
}
*/
for ($i = 0; $i<=4; $i++) {
    $trans[$i] = $data->def[0]->tr[$i]->text;
}
$transfiltered = array_filter ($trans);
$result = 'The word "'.$text.'" translates like: '.implode(', ', $transfiltered).'.';
echo $result;
//echo 'Array lenght is '.$translenght;