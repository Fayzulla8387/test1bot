<?php
$e_message = "!Xatolik";
try {
require_once 'connect.php';
include 'Telegram.php';

$telegram = new Telegram('5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM');
$chat_id = $telegram->ChatID();
$text = $telegram->Text();
global $conn;

$admin_chat_id = 1432311261;

date_default_timezone_set('Asia/Tashkent');

$data = $telegram->getData();
$message = $data['message'];
$name = $message['from']['first_name'];
$date = date('Y-m-d H:i:s', $message['date']);

$step = "";
$sql = "SELECT * FROM users where chat_id = '$chat_id'";
$result = $conn->query($sql);
if ($result->num_rows != 0) {
    $sql = "SELECT page FROM users where chat_id = '$chat_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $step = $row['page'];
}

//$message['contact']['phone_number'];
$orders = [
    "1kg - 50 000 so'm",
    "1.5kg(1L) - 75 000 so'm",
    "4.5kg(3L) - 220 000 so'm",
    "7.5kg(5L) - 370 000 so'm",
];

if ($text == "/start") {
    showStart();
}

switch ($step) {
    case "start":
        switch ($text) {
            case "/start":
                showStart();
                break;
            case "📜 Biz haqimizda":
                showAbout();
                break;
            case "🚛 Buyurtma berish":
                showOrder();
                break;
            default:
                alert();
        }
        break;
    case "order":
        if (in_array($text, $orders)) {
            $index = array_search($text, $orders);
            $sql = "UPDATE users SET page = 'phone' WHERE chat_id = '$chat_id'";
            $conn->query($sql);
            askContact();
        } elseif ($text == "🔙 Orqaga") {
            showStart();
        } else alert();
        break;
    case "phone":
        if ($text == "🔙 Orqaga") {
            showOrder();
        }
        if ($message['contact']['phone_number'] != "") {
            $phone = $message['contact']['phone_number'];
            $sql = "UPDATE users SET page = 'delivery', phone = '$phone' WHERE chat_id = '$chat_id'";
            $conn->query($sql);
            showDelivery();
        }
        break;
    case "delivery":
        switch ($text) {
            case "✈️Yetkazib berish ✈️" :
                askLocation();
                break;
            case "🍯️  O'zim borib olaman 🍯️":
                giveMe();
                break;
            case "🔙 Orqaga":
                $sql = "UPDATE users SET page = 'phone' WHERE chat_id = '$chat_id'";
                $conn->query($sql);
                askContact();
                break;
            default:
                alert();
        }
        break;
    case "location" :
        $latitude = $message['location']['latitude'];
        $longitude = $message['location']['longitude'];
        if ($text == "🔙 Orqaga") {
            $sql = "UPDATE users SET page = 'delivery' WHERE chat_id = '$chat_id' and step != 'saved'";
            $conn->query($sql);
            showDelivery();
        }
        if ($latitude != "" && $longitude != "") {
            $sql = "UPDATE users SET page = 'wait', latitude = '$latitude', longitude = '$longitude' WHERE chat_id = '$chat_id'";
            $conn->query($sql);
            giveMe();
        }
        break;
    case "wait":
        switch ($text) {
            case "Boshqa buyurtma berish":
                saved();
                break;
//            case "Bekor qilish":
//                otkaz();
//                break;
            default: alert();
        }
        break;
}

} catch (Throwable $e) {
    $e_message .= $e->getMessage() . "\n Qator-";
    $e_message .= $e->getLine() . "\n File-";
    $e_message .= $e->getFile();
    sendMessage($e_message);

}
function showStart()
{
    global $telegram, $chat_id, $name, $date, $conn;
    $sql = "SELECT * from users WHERE chat_id='$chat_id'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $sql = "insert into users (chat_id,name,page) values ('$chat_id','$name','start')";
    } else {
        $sql = "UPDATE users SET page = 'start' WHERE chat_id = '$chat_id'";
    }
    $conn->query($sql);
    $option = array(
        array($telegram->buildKeyboardButton("📜 Biz haqimizda")),
        array($telegram->buildKeyboardButton("🚛 Buyurtma berish")),
    );
    $keyboard = $telegram->buildKeyBoard($option, true, true);
    $content = [
        'chat_id' => $chat_id,
        'reply_markup' => $keyboard,
        'text' => "Assalomu aleykum $name, Botimizga xush kelibsiz !  Bot orqali masofadan turib 🍯 asal buyurtma qilishingiz mumkin !"
    ];
    $telegram->sendMessage($content);
}

function showAbout()
{
    global $telegram, $chat_id;
    $content = [
        'chat_id' => $chat_id,
        'text' => "Biz haqimizda ma'lumot. <a href='https://telegra.ph/Biz-haqimizda-08-27-2'>Ko'rish</a>",
        'parse_mode' => 'html',
    ];
    $telegram->sendMessage($content);
}

function showOrder()
{
    global $telegram, $chat_id, $conn, $orders;
    $sql = "UPDATE users SET page = 'order' WHERE chat_id = '$chat_id'";
    $conn->query($sql);
    $option = array(
        array($telegram->buildKeyboardButton($orders[0])),
        array($telegram->buildKeyboardButton($orders[1])),
        array($telegram->buildKeyboardButton($orders[2])),
        array($telegram->buildKeyboardButton($orders[3])),
        array($telegram->buildKeyboardButton("🔙 Orqaga")),
    );
    $keyboard = $telegram->buildKeyBoard($option, false, true);
    $content = [
        'chat_id' => $chat_id,
        'reply_markup' => $keyboard,
        'text' => "Buyurtma berish uchun hajmlardan birini tanlang.",
    ];
    $telegram->sendMessage($content);
}

function askContact()
{
    global $telegram, $chat_id;
    $option = array(
        array($telegram->buildKeyboardButton("Raqamni jo'natish", true, false)),
        array($telegram->buildKeyboardButton("🔙 Orqaga")),
    );
    $keyboard = $telegram->buildKeyBoard($option, false, true);
    $content = [
        'chat_id' => $chat_id,
        'reply_markup' => $keyboard,
        'text' => "Hajm tanlandi. Endi telefon raqamingizni jo'nating.",
    ];
    $telegram->sendMessage($content);
}

function showDelivery()
{
    global $telegram, $chat_id;
    $option = array(
        array($telegram->buildKeyboardButton("✈️Yetkazib berish ✈️")),
        array($telegram->buildKeyboardButton("🍯️  O'zim borib olaman 🍯️")),
        array($telegram->buildKeyboardButton("🔙 Orqaga")),
    );
    $keyboard = $telegram->buildKeyBoard($option, false, true);

    $content = [
        'chat_id' => $chat_id,
        'reply_markup' => $keyboard,
        'text' => "Manzilimiz hali yo'q",
    ];
    $telegram->sendMessage($content);
}

function askLocation()
{
    global $telegram, $chat_id, $conn;
    $sql = "UPDATE users SET page = 'location' WHERE chat_id = '$chat_id'";
    $conn->query($sql);
    $option = array(
        array($telegram->buildKeyboardButton("Manzilni jo'natish", false, true)),
        array($telegram->buildKeyboardButton("🔙 Orqaga")),
    );
    $keyboard = $telegram->buildKeyBoard($option, false, true);
    $content = [
        'chat_id' => $chat_id,
        'reply_markup' => $keyboard,
        'text' => "Endi manzilingizni jo'nating",
    ];
    $telegram->sendMessage($content);
}

function giveMe()
{
    global $telegram, $chat_id, $conn, $date, $orders, $admin_chat_id;

    $sql = "SELECT * FROM users where chat_id = '$chat_id' AND page != 'saved'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $adminText = "Buyurtmachi: " . $row['name'] . "\n" .
        "Telefon raqami: " . $row['phone'] . "\n" ;


    $content = [
        'chat_id' => $admin_chat_id,
        'text' => $adminText,
    ];
    $telegram->sendMessage($content);
    if ($row['latitude'] != "" && $row['longitude'] != "") {
        $content = [
            'chat_id' => $admin_chat_id,
            'latitude' => floatval($row['latitude']),
            'longitude' => floatval($row['longitude']),
        ];
        $telegram->sendLocation($content);
    }

    $sql = "UPDATE users SET page = 'wait' WHERE chat_id = '$chat_id'";
    $conn->query($sql);
    $option = array(
        array($telegram->buildKeyboardButton("Boshqa buyurtma berish")),
//        array($telegram->buildKeyboardButton("Bekor qilish")),
    );
    $keyboard = $telegram->buildKeyBoard($option, false, true);
    $content = [
        'chat_id' => $chat_id,
        'reply_markup' => $keyboard,
        'text' => "Buyurtma qabul qilindi. Siz bilan bog'lanamiz",
    ];
    $telegram->sendMessage($content);
}

function saved()
{
    global $chat_id, $connect;

    $sql = "UPDATE users SET page = 'saved' WHERE chat_id = '$chat_id' and page != 'saved'";
    $connect->query($sql);
    showStart();
}

function otkaz()
{
    global $telegram, $chat_id, $conn;
    $sql = "UPDATE users SET page = 'saved', status = 0 WHERE chat_id = '$chat_id'  and step != 'saved'";
    $conn->query($sql);

    $content = [
        'chat_id' => $chat_id,
        'text' => "Buyurtma bekor qilindi!",
    ];
    $telegram->sendMessage($content);
}

function alert()
{
    global $telegram, $chat_id;
    $content = [
        'chat_id' => $chat_id,
        'text' => "⚠️ Bunday buyruq mavjud emas ! \nIltimos quyidagi tugmalardan birini tanlang 👇",
    ];
    $telegram->sendMessage($content);
}

function sendMessage($text)
{
    global $chat_id, $telegram;
    $content = [
        'chat_id' => $chat_id,
        'text' => $text
    ];
    $telegram->sendMessage($content);
}
?>