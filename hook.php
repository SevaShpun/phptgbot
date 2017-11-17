<?php
require "telegrambot.php"; // подключаем telegrambot.php
$bot = new BOT(); // в переменную $bot создаем экземпляр нашего класса BOT
#############################################################################
$output         = json_decode(file_get_contents('php://input'), true);  // Получим то, что передано скрипту ботом в POST-сообщении и распарсим

$chat_id        = @$output['message']['chat']['id'];                    // идентификатор чата
$user_id        = @$output['message']['from']['id'];                    // идентификатор пользователя
$username       = @$output['message']['from']['username'];              // username пользователя
$first_name     = @$output['message']['chat']['first_name'];            // имя собеседника
$last_name      = @$output['message']['chat']['last_name'];             // фамилию собеседника
$chat_time      = @$output['message']['date'];                          // дата сообщения
$message        = @$output['message']['text'];                          // Выделим сообщение собеседника (регистр по умолчанию)
$msg            = mb_strtolower(@$output['message']['text'], "utf8");   // Выделим сообщение собеседника (нижний регистр)

$callback_query = @$output["callback_query"];                           // callback запросы
$data           = $callback_query['data'];                              // callback данные для обработки inline кнопок

$message_id     = $callback_query['message']['message_id'];             // идентификатор последнего сообщения
$chat_id_in     = $callback_query['message']['chat']['id'];             // идентификатор чата
#############################################################################

switch($message) {
    case '/start':           $bot->sendMessage($user_id, "Привет ".$first_name, [['Здравствуй бот', 'Как меня зовут ?'], ['Случайное число', 'Удалить кнопки']]); break;
    case 'Здравствуй бот': $bot->sendMessage($user_id, "Здравствуй <i>".$first_name."</i>! Посмотри этот сайт https://core.telegram.org/", [['Здравствуй бот', 'Как меня зовут ?'], ['Случайное число', 'Удалить кнопки']], ['keyboard', false, true], ['html', false]); break;
    case 'Как меня зовут ?': $bot->sendMessage($user_id, "Тебя зовут ".$first_name, []); break;
    case 'Случайное число':  $bot->sendMessage($user_id, "Число ".rand(10, 10000), []); break;
    case 'Удалить кнопки':   $bot->sendMessage($user_id, "Кнопочки удалены", [0]); break;
    
    default: $bot->sendMessage($user_id, "Неизвестная команда");
}

?>