<?php
require_once "Telegram.php";
$telegram=new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id=$telegram->ChatID();
$text=$telegram->Text();
if($text=="/start"){
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Men haqimda 📖")),

        );
    $keyb = $telegram->buildKeyBoard($option, $onetime=false, $resize=true);

$telegram->sendMessage([
'chat_id'=>$chat_id,
"reply_markup" => $keyb,
'text'=>"Salom botimga hush kelibsiz 😊"
]);
}
elseif($text=="Men haqimda 📖") {
    haqimizda();
}
else if($text=="🔙Orqaga") {
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Men haqimda 📖")),
        //Second row
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);

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
        'text'=>"Men haqimda.<a href='https://telegra.ph/Salom-11-25-8'>Batafsil</a>"
    ]);
}










