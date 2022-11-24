<?php
require_once "telegram.php";
$telegram=new Telegram("5869126547:AAHVuiF1-pcPiTyldLE68NmHhRfGnzewIAM");
$chat_id=$telegram->ChatID();
$text=$telegram->Text();
$telegram->sendMessage([
'chat_id'=>$chat_id,
'text'=>$text
]);



