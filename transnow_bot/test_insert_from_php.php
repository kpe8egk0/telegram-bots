<?php

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
    $stmt = $db->prepare('INSERT INTO article (input_text, article, lang_type_code) VALUES (:input_text, :article, :lang_type_code)');
    $stmt->bindParam(':input_text', $input_text);
    $stmt->bindParam(':article', $article);
    $stmt->bindParam(':lang_type_code', $lang_type_code);
    $stmt->execute();
}
$message = 'тестовая запись из php';
$input_text = mb_convert_encoding($message, "UTF-8");
$article = 'hat';
$lang_type_code = 'ru-en';
addArticle($input_text, $article, $lang_type_code);

echo 'done!';