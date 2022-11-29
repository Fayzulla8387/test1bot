<?php
require_once "Telegram.php";
require_once "connect.php";
$telegram = new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$name = $telegram->FirstName();
$last_name = $telegram->LastName();
$username = $telegram->Username();
$start_text = "Salom botimizga hush kelibsiz 😊 $name.$last_name";
$about_text = "Biz haqimizda.<a href='https://telegra.ph/Tabiiy-asalni-asalarichilardan-oling-11-26'>Batafsil</a>";
$order_type = ["1 kg - 50000 so'm", " 1.5 kg(1l) -75000 so'm", "4,5 kg(3l) - 220000 so'm", "7,5 kg(5l) - 370000 so'm"];

$data = $telegram->getData();
$message = $data["message"];
//$telegram->sendMessage([
//    "chat_id" => $telegram->ChatID(),
//    "text" => $message['contact']['phone_number'],
//]);
//$text = $message["text"];
//$chat_id = $message["chat"]["id"];
error_reporting(E_ALL);
ini_set("display_errors", 1);
$e_message = "!Xatolik";
try {
    $sql = "SELECT 'page' FROM `users` WHERE `chat_id` = '$chat_id'";
    $result = $conn->query($sql);
    $page = $result->fetch_assoc()['page'];
    switch ($page) {
        case "main":
            {
                switch ($text) {
                    case "Batafsil ma'lumot 🐝":
                        haqimizda();
                        break;
                    case "Buyurtma berish 🛒":
                        buyurtma();
                        break;

                }

            }
            break;
        case "order":
            {
                if ($text == "Orqaga 🔙") {
                    show_start();
                } elseif (in_array($text, $order_type)) {
                    aloqa();
                }
            }
            break;
        case "phone":
            {
                if ($text == "Orqaga 🔙") {
                    buyurtma();
                } else {
                    $phone = $message['contact']['phone_number'];
                    $sql = "UPDATE `users` SET `phone` = '$phone', page='delivery' WHERE `chat_id` = '$chat_id'";
                    $conn->query($sql);
                }
            }
            switch ($text) {
                case "/start":
                    show_start();
                    break;
                case "Batafsil ma'lumot 🐝":
                    haqimizda();
                    break;
                case "Buyurtma berish 🍯":
                    buyurtma();
                    break;
                case "1 kg - 50000 so'm":
                    aloqa();
                    break;
                case "1.5 kg(1l) -75000 so'm":
                    aloqa();
                    break;
                case "4,5 kg(3l) - 220000 so'm":
                    aloqa();
                    break;
                case "7,5 kg(5l) - 370000 so'm":
                    aloqa();
                    break;
                case "delivery":
                    showDelivery();

                default:
                    alert();
                    break;
//        if (in_array($text, $order_type)) {
//            file_put_contents("users/massa.txt", $text);
//            aloqa();
//        } else {
//            switch (file_get_contents('users/step.txt')) {
//                case "phone":
//                    if ($message["contact"]["phone_number"] != " ") {
//                        $phone = $message["contact"]["phone_number"];
//                        file_put_contents("users/phone.txt", $phone);
//                    } else {
//                        file_put_contents("users/phone.txt", $text);
//                    }
//
//                    showDelivery();
//                    break;
//            }
//
//
//        }

            }


///////function
            function show_start()
            {
                global $telegram, $conn;
                global $chat_id, $start_text;
                global $name, $last_name, $username;
                $sql = "SELECT * FROM `users` WHERE `chat_id` = '$chat_id'";
                $result = $conn->query($sql);
                if ($result->num_rows == 0) {
                    $sql = "INSERT INTO users (chat_id, page, `name`) VALUES ('$chat_id', 'main','$name')";
                    $conn->query($sql);
                }
//        else {
//            $sql = "UPDATE `users` SET `page` = 'main' WHERE `chat_id` = '$chat_id'";
//            $conn->query($sql);
//        }
//        $conn->query($sql);
                $option = array(
                    array($telegram->buildKeyboardButton("Batafsil ma'lumot 🐝")),
                    //Second row
                    array($telegram->buildKeyboardButton("Buyurtma berish 🛒")),
                );
                $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);

                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    "reply_markup" => $keyb,
                    'text' => $start_text,
                ]);
            }

            function haqimizda()
            {
                global $telegram, $chat_id, $about_text;
                $option = array(
                    //First row
                    array($telegram->buildKeyboardButton("🔙Orqaga")),
                    //Second row
                );
                $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    "reply_markup" => $keyb,
                    'text' => $about_text,
                    'parse_mode' => 'html'
                ]);
            }

            function buyurtma()
            {
                global $telegram, $chat_id;
                $sql = "UPDATE users SET page='order' WHERE chat_id='$chat_id'";
                $option = array(
                    //First row
                    array($telegram->buildKeyboardButton("1 kg - 50000 so'm")),
                    //Second row
                    array($telegram->buildKeyboardButton("1.5 kg(1l) -75000 so'm")),
                    //Third row
                    array($telegram->buildKeyboardButton("4,5 kg(3l) - 220000 so'm")),
                    //Fourth row
                    array($telegram->buildKeyboardButton("7,5 kg(5l) - 370000 so'm")),
                    //Fifth row
                    array($telegram->buildKeyboardButton("🔙Orqaga")),
                );
                $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    "reply_markup" => $keyb,
                    'text' => "Kerekli miqdorini tanlang",
                    'parse_mode' => 'html'
                ]);
            }

            function aloqa()
            {
                global $telegram, $conn, $chat_id, $message;
                $sql = "UPDATE users SET page='phone' WHERE chat_id='$chat_id'";
                $conn->query($sql);


                $option = array(
                    //First row
                    array($telegram->buildKeyboardButton("Raqamni jo'natish", $request_contact = true)),
                    //Second row
                    array($telegram->buildKeyboardButton("🔙Orqaga")),
                    //Third row

                );
                $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    "reply_markup" => $keyb,
                    'text' => "Kerakli miqdor tanlandi endi raqamingizni yuboring",
                    'parse_mode' => 'html'
                ]);
            }

            function showDelivery()
            {
                global $telegram, $chat_id;
                $option = array(
                    //First row
                    array($telegram->buildKeyboardButton("✈️Yetkazib berish✈️", $request_location = true)),
                    //Second row
                    array($telegram->buildKeyboardButton("🚶‍Borib olish🚶‍")),
                    //Third row
                    array($telegram->buildKeyboardButton("🔙Orqaga")),

                );
                $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
                $telegram->sendMessage([
                    'chat_id' => $chat_id,
                    "reply_markup" => $keyb,
                    'text' => "Buyurtma qabul qilindi",
                    'parse_mode' => 'html'
                ]);
            }
    }
} catch (Throwable $e) {
    $e_message .= $e->getMessage() . "\n Qator-";
    $e_message .= $e->getLine() . "\n File-";
    $e_message .= $e->getFile();
    sendMessage($e_message);

}
function sendMessage($message)
{
    global $telegram, $chat_id;
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => $message,
    ]);
}