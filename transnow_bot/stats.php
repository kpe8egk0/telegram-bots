<?php

$n = 10;

echo 'Всего запросов: ' . getLookupTotalAmount() . '<br/>';
echo 'Всего статей: ' . getArticleTotalAmount() . '<br/>';
echo 'Последние '. $n . ' запросов: ' . getLookupLastN($n);

function db()
{
    define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
    define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
    define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
    define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
    define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));
    $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8';
    $dbh = new PDO($dsn, DB_USER, DB_PASS);
    return $dbh;
}

function getLookupTotalAmount() {
    $db = db();
    $stmt = $db->prepare('SELECT COUNT(*) FROM lookup');
    $stmt->execute();

    $output = $stmt->fetchColumn();

    return $output;
}

function getArticleTotalAmount() {
    $db = db();
    $stmt = $db->prepare('SELECT COUNT(*) FROM article');
    $stmt->execute();

    $output = $stmt->fetchColumn();

    return $output;
}

function getLookupLastN($n) {
    $db = db();
    $stmt = $db->prepare('SELECT * FROM lookup lkp LEFT JOIN article rtcl ON lkp.input_text = rtcl.input_text ORDER BY id DESC LIMIT :n');
    $stmt->bindParam(':n', $n, PDO::PARAM_INT);
    $stmt->execute();

    $output = '';
    foreach ($stmt as $row) {
        $output = $output . '<br/>[' . $row['lookup.date'] . '] ' . $row['lookup.user'] . ': "' . $row['lookup.input_text'] . '"';
    }

    return $output;
}