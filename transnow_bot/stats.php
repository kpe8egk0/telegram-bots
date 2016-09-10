<?php



echo 'Всего запросов: ' . getLookupTotalAmount() . '<br/>';
echo 'Всего статей: ' . getArticleTotalAmount() . '<br/>';
echo 'Последние 5 запросов: <br/>' . getLookupLastN();

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

}

function getLookupLastN() {

}