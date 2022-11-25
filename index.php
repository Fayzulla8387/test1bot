<?php
require_once "Telegram.php";
$telegram=new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id=$telegram->ChatID();
$text=$telegram->Text();
if($text=="/start"){
    $option = array(
        //First row
        array($telegram->buildKeyboardButton("Nagap"), $telegram->buildKeyboardButton("Button 2")),
        //Second row
        array($telegram->buildKeyboardButton("Button 3"), $telegram->buildKeyboardButton("Button 4"), $telegram->buildKeyboardButton("Button 5")),
        //Third row
        array($telegram->buildKeyboardButton("Button 6")) );
    $keyb = $telegram->buildKeyBoard($option, $onetime=false);

$telegram->sendMessage([
'chat_id'=>$chat_id,
"reply_markup" => $keyb,
'text'=>"Salom mening ismim Fayzulla"
]);
}
else{
$telegram->sendMessage([
'chat_id'=>$chat_id,
'text'=>$text
]);
}






