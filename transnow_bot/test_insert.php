<?php

$access_token = '261062241:AAHYU1rMeyMW4I0z6bxrwP3HpeaJKLVNXxs';
$api = 'https://api.telegram.org/bot' . $access_token;

$input_json = file_get_contents('php://input');
$output = json_decode($input_json, TRUE);

$chat_id = $output['message']['chat']['id'];
$message = $output['message']['text'];
$username = $output['message']['from']['first_name'].' '.$output['message']['from']['last_name'];

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

function addArticle($input_text, $article, $lang_type_code)
{
    $db = db();
    $encode = $db->prepare('SET NAMES "utf8"');
    $encode->execute();
    $stmt = $db->prepare('INSERT INTO article (input_text, article, lang_type_code) VALUES (:input_text, :article, :lang_type_code)');
    $stmt->bindParam(':input_text', $input_text);
    $stmt->bindParam(':article', $article);
    $stmt->bindParam(':lang_type_code', $lang_type_code);
    $stmt->execute();
}

$input_text = $message;
$article = 'hat';
$lang_type_code = 'ru-en';
addArticle($input_text, $article, $lang_type_code);

echo 'done!';