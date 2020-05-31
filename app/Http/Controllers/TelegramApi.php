<?php

//bot
$bot_api_key = "AIzaSyB4m7BiZyecAuakH9COdYCFr5uTXScVeeE";

//telegram


$token = "1289008457:AAEGlaYNMV3KHpxSrgtGUU7Iv8cHCIO9588";
$website = "https://api.telegram.org/bot" . $token;
//
//$request_params = [
//    "chat_id" => $user_id,
//    "text" => $mssg
//];

//echo "Hello World";;
$update_debug = $website . "/getupdates";

$update = json_decode(file_get_contents($update_debug), true);
$chatIds = array();
$chatTexts = array();
$userNames = array();
$userIds = array();
print_r($update);
if($update["result"]!=null) {
    for ($i = 0; $i < sizeof($update["result"]); $i++) {
        $chatIds[$i] = $update["result"][$i]["message"]["chat"]["id"];
        //echo "   ";
        $chatTexts[$i] = $update["result"][$i]["message"]["text"];
        $userNames[$i] = $update["result"][$i]["message"]["username"] ;
        $userIds[$i] = $chatIds[$i];
        //echo "/n/n";
    }

    for ($i = 0; $i < sizeof($update["result"]); $i++) {
        print("\n");
        print("\n");
        print("\n");
        //print_r($update["result"]);







        if(true){
            //return file_get_contents('http://gdata.youtube.com/feeds/api/videos/'+ $video->id +'?v=2&alt=jsonc');
            $sendMessage = file_get_contents($website . "/sendmessage?chat_id=" . $chatIds[$i] . "&text=" . "This feature is being tested. Please try again next week!");
//            $sendMessage = file_get_contents($website . "/sendmessage?chat_id=" . $chatIds[$i] . "&text=" . "Share your invitation Link below");
        }
        else{
//            $result_array = search_by_keyword(null , $chatTexts[$i] , 5, $yt_search_url,  $yt_api_key);
//            $json_response = read_Json(json_decode($result_array));
//            for($j = 0;$j < sizeof($json_response);$j++) {
            $sendMessage = file_get_contents($website . "/sendmessage?chat_id=" . $chatIds[$i] . "&text=" . "Please open shimmer app and add your telegram account username and comeback!");
//            }
        }
    }

    //$request_url = "https://api.telegram.org/bot" . $token . "/sendMessage?" . http_build_query($request_params);
}
?>
