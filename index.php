<?php
require_once "Telegram.php";
$telegram=new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id=$telegram->ChatID();
$text=$telegram->Text();
$name=$telegram->FirstName();
$last_name=$telegram->LastName();
$username=$telegram->Username();


if($text=="/start"){
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Men haqimda 📖")),
        );
    $keyb = $telegram->buildKeyBoard($option, $onetime=false, $resize=true);

$telegram->sendMessage([
'chat_id'=>$chat_id,
"reply_markup" => $keyb,
'text'=>"Salom botimga hush kelibsiz 😊 $name.$last_name"
]);
}

elseif($text=="Men haqimda 📖") {
    haqimizda();
}
elseif($text=="🔙Orqaga") {
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Men haqimda 📖")),
        //Second row
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
  $telegram->sendMessage([
        'chat_id' => $chat_id,
        "reply_markup" => $keyb,
        'text' => "Salom botimga hush kelibsiz ??"
    ]);
}



///////function
function haqimizda(){
    global $telegram, $chat_id;
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("🔙Orqaga")),
        //Second row
            );
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $telegram->sendMessage([
        'chat_id'=>$chat_id,
        "reply_markup" => $keyb,
        'text'=>"Men haqimda.<a href='https://telegra.ph/Salom-11-25-8'>Batafsil</a>",
        'parse_mode'=>'html'
    ]);
}










