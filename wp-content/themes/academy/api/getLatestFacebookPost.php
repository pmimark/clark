<?php
  // Skip these two lines if you're using Composer
  define('FACEBOOK_SDK_V4_SRC_DIR', THEME_PATH.'api/facebook_sdk/src/Facebook/');
  require THEME_PATH . 'api/facebook_sdk/autoload.php';

  use Facebook\FacebookSession;
  use Facebook\FacebookRequest;
  use Facebook\GraphUser;
  use Facebook\FacebookRequestException;
  
  function getLastFacebookPost(){
    FacebookSession::setDefaultApplication(FB_APP_ID, FB_APP_SECRET);
    $session = new FacebookSession(FB_TOKEN);
  
    $request = new FacebookRequest($session, 'GET', '/' . FB_PAGE . '/posts?fields=message&limit=1');
    $obj = $request->execute()->getGraphObject(GraphUser::className());
    $result = $obj->asArray();
    if( isset($result['data'][0]->message) && !empty($result['data'][0]->message) ){
      $message = cut_paragraph($result['data'][0]->message);
      return $message;
    }
    return;
  }