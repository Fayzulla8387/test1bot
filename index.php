<?php
require_once "Telegram.php";
$telegram=new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id=$telegram->ChatID();
$text=$telegram->Text();
if($text=="/start"){
$telegram->sendMessage([
'chat_id'=>$chat_id,
'text'=>"Salom mening ismim Fayzulla"
]);
}
else{
$telegram->sendMessage([
'chat_id'=>$chat_id,
'text'=>$text
]);

}






