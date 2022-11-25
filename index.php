<?php
require_once "Telegram.php";
$telegram=new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id=$telegram->ChatID();
$text=$telegram->Text();
if($text=="/start"){
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Biz haqimizda 📖")),
        //Second row
        array($telegram->buildKeyboardButton("Buyurtma berish 📝")),
        );
    $keyb = $telegram->buildKeyBoard($option, $onetime=false, $resize=true);

$telegram->sendMessage([
'chat_id'=>$chat_id,
"reply_markup" => $keyb,
'text'=>"Salom mening ismim Fayzulla"
]);
}
else if($text=="Biz haqimizda 📖") {
    haqimizda();
}



function haqimizda(){
    global $telegram, $chat_id;
    $telegram->sendMessage([
        'chat_id'=>$chat_id,
        'text'=>"Bizning kompaniyamiz 2019 yilda tashkil topgan"
        ]);
}




