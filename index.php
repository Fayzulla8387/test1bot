<?php
require_once "Telegram.php";
$telegram = new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id = $telegram->ChatID();
$text = $telegram->Text();
$name = $telegram->FirstName();
$last_name = $telegram->LastName();
$username = $telegram->Username();
$start_text = "Salom botimizga hush kelibsiz 😊 $name.$last_name";
$about_text = "Biz haqimizda.<a href='https://telegra.ph/Tabiiy-asalni-asalarichilardan-oling-11-26'>Batafsil</a>";
$order_type = ["1 kg - 50000 so'm", " 1.5 kg(1l) -75000 so'm", "4,5 kg(3l) - 220000 so'm", "7,5 kg(5l) - 370000 so'm"];

if ($text == "/start") {
    show_start();
} elseif ($text == "Batafsil ma'lumot 🐝") {
    haqimizda();
} elseif ($text == "Buyurtma berish 🍯") {
    buyurtma();
} elseif (in_array($text, $order_type)) {
    aloqa();
}

switch ($text){
    case "/start":
        show_start();
        break;
    case "Batafsil ma'lumot 🐝":
        haqimizda();
        break;
    case "Buyurtma berish 🍯":
        buyurtma();
        break;
    case in_array($text, $order_type):
        aloqa();
        break;
        default:
            break;
}


///////function
function show_start()
{
    global $telegram;
    global $chat_id,$srart_text;
    global $name, $last_name, $username;
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
        'text' => $srart_text,
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
//        array($telegram->buildKeyboardButton("🔙Orqaga")),
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
    global $telegram, $chat_id;
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Raqamni jo'natish", $request_contact = true)),
        //Second row

        //Third row
//        array($telegram->buildKeyboardButton("🔙Orqaga")),
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $telegram->sendMessage([
        'chat_id' => $chat_id,
        "reply_markup" => $keyb,
        'text' => "Kerakli miqdor tanlandi endi raqamingizni yuboring",
        'parse_mode' => 'html'
    ]);
}









