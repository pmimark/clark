<?php
require_once(THEME_PATH."api/twitterAuth/TwitterAPIExchange.php");

// Get Last Twitt
function getLastTwitt(){
   $settings = array(
      'oauth_access_token' => TW_ACCES_TOKEN,
      'oauth_access_token_secret' => TW_ACCES_TOKEN_SECRET,
      'consumer_key' => TW_CON_KEY,
      'consumer_secret' => TW_CON_SECRET
   );
   
   $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
   $getfield = '?screen_name=' . TW_PAGE . '&count=10';
   $requestMethod = 'GET';
   
   $twitter = new TwitterAPIExchange($settings);
   $result = $twitter->setGetfield($getfield)
                ->buildOauth($url, $requestMethod)
                ->performRequest();
   $result = json_decode($result);

   return cut_paragraph($result[0]->text);
}