<?php
//https://developer.amazon.com/alexa/console/ask/
//Flash Briefing skill
$date = new \DateTime('now');
$datestring=$date->format('Y-m-d\TH:i:s\.\0\Z');
header("Content-Type: application/json; charset=UTF-8");
echo '{
  "uid": "'.base64_encode($datestring).'",
  "updateDate": "'.$datestring.'",
  "titleText": "Weather",
  "streamUrl": "*URL TO T2_PUBLIC*",
  "mainText":"",
  "redirectionUrl": "https://developer.amazon.com/public/community/blog"
}';
?>
