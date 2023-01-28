<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);


$url = 
"https://graph.facebook.com/v2.6/me/messages?access_token=EAAKIOHVx8NUBAKBZAPQ5AhojHJwiQHP2iL1rP1Y4yfNMQZAZBjgZC4RWQG1aprL7qg9JZBlTm7RvkSMyRws4WMsKIGTniB7urzdwz5Gni7YdDtBx6ZCf5mAngANiJtnwGjZCZBWGA9c51G6AfVXZAbZAmVjh6d3ARU5vvgaeDIZBgUTccVPrDC6Iobq";

$ch = curl_init($url);
$jsonMenuData = '{
	"persistent_menu":[
    {
		"locale": "default",
		"composer_input_disabled": false,
		"call_to_actions":[{
			"type":"nested",
				"title":"📑 Цэс",
				"call_to_actions":[	
				{
					"type":"postback",
					"title":"📑 Үндсэн цэс",
					"payload":"MAIN_MENU"
				},
				{
					"type":"postback",
					"title":"🏠 Салбар/АТМ хайх",
					"payload":"BRANCH_SEARCH"
				},
				{
					"type":"postback",
					"title":"💱 Валютын ханш харах",
					"payload":"VALUT_CHOOSER"
				}]
			},
			{
			"type":"nested",
			"title":"❓ Асуудал тулгарсан",
			"call_to_actions":[
			{
				"type":"postback",
				"title":"Мост монитой холбоотой",
				"payload":"PROBLEM_MOST_MONEY"		
			},
			{
				"type":"postback",
				"title":"Ebank-тай холбоотой",
				"payload":"PROBLEM_EBANK"		
			},
			{
				"type":"postback",
				"title":"Карттай холбоотой",
				"payload":"PROBLEM_CARD"		
			},
			{
				"type":"postback",
				"title":"Санал/Гомдол",
				"payload":"COMPLAINT"		
			}]
			},
			{
				"type":"nested",
				"title":"Бусад",
				"call_to_actions":[
			{
				"type":"postback",
				"title":"👄 Хэл сонгох/Choose language",
				"payload":"LANGUAGE_CHOOSER"
			},
			{
				"type":"postback",
				"title":"✪ Үнэлгээ өгөх/Rate me",
				"payload":"RATE_BOT"
			}	
			]}
		]
	}]}';
			
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonMenuData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
echo $result; 
if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
}

error_log($result);



?>