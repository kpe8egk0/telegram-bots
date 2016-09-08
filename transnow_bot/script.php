<?php

//https://api.telegram.org/bot261062241:AAHYU1rMeyMW4I0z6bxrwP3HpeaJKLVNXxs/setWebhook?url=https://transnow-ironyman.rhcloud.com/transnow_bot/script.php

// Доступ к боту
$bot_access_token = '261062241:AAHYU1rMeyMW4I0z6bxrwP3HpeaJKLVNXxs';
$api = 'https://api.telegram.org/bot' . $bot_access_token;

// Доступ к словарю Яндекса
$yandex_key = 'dict.1.1.20160819T080857Z.a21f9f5c92e0e7b9.ab24906e2b9b24a62bede201ca3067abadaf5752';


$input = json_decode(file_get_contents('php://input'), TRUE);

$chat_id = $input['message']['chat']['id'];
$message = $input['message']['text'];
$username = $input['message']['from']['username'];

$user = getUser($username);
if ($user['user'] != '') {
    addUser($username);
}


// Функции
// Базовая функция доступа к БД
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

function getUser($user) {
    $db = db();
    $stmt = $db->prepare('SELECT * FROM user WHERE user = :user');
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    $row = $stmt->fetch();

    return $row;
}

// Регистрация нового пользователя
function addUser($user)
{
    $db = db();
    $stmt = $db->prepare('INSERT INTO user (user, reg_date) VALUES (:user, NOW())');
    $stmt->bindParam(':user', $user);
    $stmt->execute();
}

// Добавление статьи в БД
function addArticle($input_text, $article, $lang_type_code)
{
    $db = db();
    //$encode = $db->prepare('SET NAMES "utf8"');
    //$encode->execute();
    $stmt = $db->prepare('INSERT INTO article (input_text, article, lang_type_code) VALUES (:input_text, :article, :lang_type_code)');
    $stmt->bindParam(':input_text', $input_text);
    $stmt->bindParam(':article', $article);
    $stmt->bindParam(':lang_type_code', $lang_type_code);
    $stmt->execute();
}

// Отправка сообщения
function sendMessage($chat_id, $message)
{
    file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message));
}