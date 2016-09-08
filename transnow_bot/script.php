<?php

//https://api.telegram.org/bot261062241:AAHYU1rMeyMW4I0z6bxrwP3HpeaJKLVNXxs/setWebhook?url=https://transnow-ironyman.rhcloud.com/transnow_bot/script.php

// Доступ к боту
$bot_access_token = '261062241:AAHYU1rMeyMW4I0z6bxrwP3HpeaJKLVNXxs';
$api = 'https://api.telegram.org/bot' . $bot_access_token;

// Доступ к словарю Яндекса
$yandex_key = 'dict.1.1.20160819T080857Z.a21f9f5c92e0e7b9.ab24906e2b9b24a62bede201ca3067abadaf5752';

//Доступ к переводчику Яндекса
$yandex_trans_key = 'trnsl.1.1.20160906T144940Z.7b9bdff453462ecd.bcabb5b47a3afe432e57931793362ad73e47898f';

$input = json_decode(file_get_contents('php://input'), TRUE);

$chat_id = $input['message']['chat']['id'];
$message = $input['message']['text'];
$username = $input['message']['from']['username'];

// Проверка наличия пользователя в БД. Если пользователь не найден, выполняется добавление.
$user = getUser($username);
if (!isset($user['user'])) {
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

// Определение языка вводимого слова (работает только через Яндекс переводчик)
function lang_def($message, $key)
{
    //hint - это предполагаемые языки. Пока что оставил en, ru. Можно подумать над этим моментом ещё.
    $url = sprintf('https://translate.yandex.net/api/v1.5/tr.json/detect?hint=en,ru&key=%s&text=%s', $key, $message);
    $json_data = file_get_contents($url);
    $data = json_decode($json_data);
    $result = $data->lang;
    return $result;
}

// Вывод нескольких вариантов перевода
function full_output($input, $article)
{
    $data = json_decode($article);
    for ($i = 0; $i<=4; $i++) {
        $trans[$i] = $data->def[0]->tr[$i]->text;
    }
    $transfiltered = array_filter ($trans);
    $result = 'The word "'.$input.'" translates like: '.implode(', ', $transfiltered).'.';
    return $result;
}

// Вывод одного вариант перевода с частью речи и синонимом, если есть
function short_output_detailed($input, $article)
{
    $data = json_decode($article);
    $trans = $data->def[0]->tr[0]->text;
    $pos = $data->def[0]->tr[0]->pos;
    $syn = $data->def[0]->tr[0]->syn[0]->text;
    //Если синонима нет, выводим просто перевод и часть речи
    if (empty($syn))
    {
        $result = $trans.' ('.$pos.').';
    }
    else
    {
        $syn_pos = $data->def[0]->tr[0]->syn[0]->pos;
        $result = $trans.' ('.$pos.'), synonym - '.$syn.'. ('.$syn_pos.').';
    }
    return $result;
}

// Вывод одного варианта перевода
function shortest_output($article)
{
    $data = json_decode($article);
    $result = $data->def[0]->tr[0]->text;
    return $result;
}