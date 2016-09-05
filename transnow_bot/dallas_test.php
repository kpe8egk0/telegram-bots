<?php
header('Content-Type: text/html; charset=UTF-8');
//echo phpinfo();

$key = 'dict.1.1.20160819T080857Z.a21f9f5c92e0e7b9.ab24906e2b9b24a62bede201ca3067abadaf5752';
$input_text = 'fuck';
$langs = 'en-ru';
//$url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang='.$langs.'&text='.$input_text, $key);
$url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang=' . $langs . '&text=' . $input_text, $key);
$json_data = file_get_contents($url);
// echo $json_data;


function db()
{
    define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
    define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
    define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
    define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
    define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';port=' . DB_PORT;
    $dbh = new PDO($dsn, DB_USER, DB_PASS);
    return $dbh;
}

function sendMessage($chat_id, $message)
{
    file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message));
}

// Получение статьи из БД
function getArticleFromDB($source, $lang, $input_text)
{
    $db = db();
    $stmt = $db->prepare('SELECT article FROM article WHERE input_text = :input_text AND lang_type_code = :lang'); //
    $stmt->bindParam(':input_text', $input_text);
    $stmt->bindParam(':lang', $lang);
    $stmt->execute();
    echo $stmt->rowCount();
    $row = $stmt->fetch();


    $json_data = $row['article'];

    return $json_data;
}

// Получение статьи из внешнего источника
function getArticleFromSource($source, $lang, $input_text, $key)
{
    $url = sprintf('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?key=%s&lang=%s&text=%s', $key, $lang, $input_text);
    $json_data = file_get_contents($url);
    return $json_data;
}

$message = 'мяч';
$lang = 'ru-en';

//Попытка получить статью из БД
$article_from_db = getArticleFromDB($source, $lang, $message);
if ($article_from_db != NULL) {
    // Если получена статья из БД
    echo 'pass';
    echo '<br/>';
    echo $article_from_db;
} else {
    // Если не получена  статья из БД
    // Попытка получить статью из внешнего источника
    $article_from_source = getArticleFromSource($source, $lang, $message, $yandex_key);
    echo 'pass 2';
    echo '<br/>';
    echo json_encode($article_from_source, JSON_PRETTY_PRINT);
}