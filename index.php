<?php
require_once "Telegram.php";
$telegram = new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$name = $telegram->FirstName();
$last_name = $telegram->LastName();
$username = $telegram->Username();


if ($text == "/start") {
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Batafsil ma'lumot 🐝")),
        //Second row
        array($telegram->buildKeyboardButton("Buyurtma berish 🍯")),
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);

    $telegram->sendMessage([
        'chat_id' => $chat_id,
        "reply_markup" => $keyb,
        'text' => "Salom botimizga hush kelibsiz 😊 $name.$last_name"
    ]);
}
elseif($text == "Batafsil ma'lumot 🐝") {
    haqimizda();
}elseif ($text == "Buyurtma berish 🍯") {
    buyurtma();
}elseif ($text == "🔙Orqaga") {
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Batafsil ma'lumot 🐝")),
        //Second row
        array($telegram->buildKeyboardButton("Buyurtma berish 🍯")),
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        "reply_markup" => $keyb,

    ]);
}
if ($text == "1 kg asal 50000 so'm") {
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Raqamni jo'natish", $request_contact = true)),
        //Second row

        //Third row
//        array($telegram->buildKeyboardButton("🔙Orqaga")),
    );
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => "Kerakli miqdor tanlandi endi raqamingizni yuboring",
        'parse_mode' => 'html'
    ]);
}



///////function
function haqimizda()
{
    global $telegram, $chat_id;
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("🔙Orqaga")),
        //Second row
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        "reply_markup" => $keyb,
        'text' => "Biz haqimizda.<a href='https://telegra.ph/Tabiiy-asalni-asalarichilardan-oling-11-26'>Batafsil</a>",
        'parse_mode' => 'html'
    ]);
}

function buyurtma()
{
    global $telegram, $chat_id;
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("1 kg asal 50000 so'm")),
        //Second row
        array($telegram->buildKeyboardButton("2 kg asal 900000 so'm")),
        //Third row
        array($telegram->buildKeyboardButton("3 kg asal 130000 so'm")),
        //Fourth row
        array($telegram->buildKeyboardButton("🔙Orqaga")),
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        "reply_markup" => $keyb,
        'text' => "Kereki miqdorini tanlang",
        'parse_mode' => 'html'
    ]);
}










