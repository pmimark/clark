<?php
//Error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);

//Define constants
define('SITE_URL', home_url().'/');
define('AJAX_URL', admin_url('admin-ajax.php'));
define('THEME_PATH', get_template_directory().'/');
define('CHILD_PATH', get_stylesheet_directory().'/');
define('THEME_URI', get_template_directory_uri().'/');
define('CHILD_URI', get_stylesheet_directory_uri().'/');
define('THEMEX_PATH', THEME_PATH.'framework/');
define('THEMEX_URI', THEME_URI.'framework/');
define('THEMEX_PREFIX', 'themex_');
define('IN_CLIENT_ID','1b00628d7dd54186b3bdc0e7a6ac79ef');
define('IN_CLIENT_SECRET','def8b7407f7d44a7b152b9886194aa0e');
define('IN_CLARK_ID','1440776726');
define('HOME_ID',136);
define('FB_APP_ID','836809286357944');

define('TW_PAGE','_MCCA_');
define('TW_ACCES_TOKEN','3005330170-VoKQpgLkHDA3DaZmI6G1fS5YymxH4uFUtmxptB3');
define('TW_ACCES_TOKEN_SECRET','uamPJ43Q49nvAXVZw1dgv4Q9YgNTtY67los8cKMnpNdde');
define('TW_CON_KEY','42Z3xz5CUcaRsSKsAB87gRqrc');
define('TW_CON_SECRET','Xkq9F0ctGZwqu1Ydlw4npNeAZB05ptPvSJsGiGZ2TRRqnSIFlv');

define('FB_PAGE','michaelclarkecricketacademy');
define('FB_APP_ID','1404381646534051');
define('FB_APP_SECRET','03aae847df5dacacc9fb4c58530844c7');
define('FB_TOKEN','1404381646534051|4Ir79EAnvrqmbCQxoPkL9e_phHs');

date_default_timezone_set("Australia/ACT");

function pa($mixed, $stop = false) {
   echo '<pre>';
   if(!empty($mixed))
      print_r($mixed);
   else
      var_dump($mixed);
   echo '</pre>';
   
   if($stop)
       exit;
}

//Set content width
$content_width=1140;

//Load language files
load_theme_textdomain('academy', THEME_PATH.'languages');

//Include theme functions
include(THEMEX_PATH.'functions.php');

//Include configuration
include(THEMEX_PATH.'config.php');

//Include core class
include(THEMEX_PATH.'classes/themex.core.php');

//Create theme instance
$themex=new ThemexCore($config);

add_action('wp_ajax_nopriv_themex_login_user', 'themex_login_user');
function themex_login_user(){
    $user = get_user_by('login',$_POST['username']);
    if(empty($user)){
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Invalid username or password'
        ));
        
        exit;
    }
    
    if(!wp_check_password($_POST['pass'],$user->user_pass, $user->ID)){
        echo json_encode(array(
            'status' => 'fail',
            'message' => 'Invalid username or password'
        ));
        
        exit;
    }

    wp_set_auth_cookie($user->ID);
    
    echo json_encode(array(
        'status' => 'ok',
        'redirect' => get_author_posts_url($user->ID),
        'message' => 'User successfully logged'
    ));
    
    exit;
}

function breadcrumbs(){
    global $post;
    
    function build($p,$bc = array()){
        $bc[] = $p;
        if($p->post_parent > 0){
            $bc = build(get_post($p->post_parent),$bc);
        }
        
        return $bc;
    }
    
    $breadcrumbs = build($post);
    
    echo '<ul class="breadcrumbs">';
        echo '<li><a href="'.get_bloginfo('home').'">Home</a></li>';
        for($i=count($breadcrumbs)-1;$i>=0;$i--){
            echo '<li>';
            if($i>0)
                echo '<a href="'.get_permalink($breadcrumbs[$i]->ID).'">'.$breadcrumbs[$i]->post_title.'</a>';
            else
                echo $breadcrumbs[$i]->post_title;
            echo '</li>';
        }
    echo '</ul>';
}

function curlGetContent($url,$postData = false){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:9.0.1) Gecko/20100101 Firefox/9.0.1");

    $headers = array(
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3',
        'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7'
    );

    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    if($postData){
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }
    
    $result = curl_exec($ch);
    
    curl_close($ch);
    
    return $result;
}

function get_inst_btn(){
    return '<a href="https://api.instagram.com/oauth/authorize/?client_id='.IN_CLIENT_ID.'&redirect_uri='.IN_REDIRECT_URI.'&response_type=code">get token</a>';
}

function get_contact_link(){
    $p = 152;
    return get_permalink($p);
}

function get_in_photos(){
    $data = get_option('in_data');
    $current_time = time();

    if($current_time - $data['time'] > 3600*4){
        $json = curlGetContent('https://api.instagram.com/v1/users/'.IN_CLARK_ID.'/media/recent/?count=8&client_id='.IN_CLIENT_ID);
        $result = json_decode($json,true);

        if(!empty($result['data'])){
            $html = '';
            foreach($result['data'] as $img){
                $html .= '<img src="'.$img['images']['thumbnail']['url'].'" width="60" height="60" />';
            }
            
            update_option('in_data',array('time' => $current_time,'html' => $html));
        }
        
        echo $html;
        return true;
    }
    
    echo $data['html'];
    return true;
}

function get_post_by_name($name,$post_type = 'post'){
    global $wpdb;
    
    return $wpdb->get_row("SELECT * FROM wp_posts WHERE post_name = '$name' and post_type = '$post_type'");
}

function is_deposit_completed(){
    global $current_user;
    
    $deposit = get_user_meta($current_user->ID,'MCCA_deposit',true);
    if(!empty($deposit) && $deposit == 'completed')
        return true;
    return false;
}

function is_balance_completed(){
    global $current_user;
    
    $balance = get_user_meta($current_user->ID,'MCCA_balance',true);
    if(!empty($balance) && $balance == 'completed')
        return true;
    return false;
}

function get_academy(){
    global $current_user;
    
    $user_resources = get_user_meta($current_user->ID,'user_resources',true);
    if(!empty($user_resources)){
        foreach($user_resources as $res){
            $cats = wp_get_post_terms($res,'resources');
            foreach($cats as $cat){
                if($cat->slug == 'nutrition-plan'){
                    $file = simple_fields_fieldgroup('file',$res);
                    if(!empty($file))
                        return wp_get_attachment_url($file);
                }
            }
        }    
    }
    
    return '#';
}

function cut_text($text,$len = 100){
    $text = strip_tags($text);
    
    if(strlen($text) > $len)
        return substr($text,0,$len).'...';
    return $text;
}

add_action('wp_ajax_fbredirect', 'fbRedirect');
add_action('wp_ajax_nopriv_fbredirect', 'fbRedirect');
function fbRedirect() {
    echo '<script>window.close();</script>';
    die();
}


//Social api
require_once(THEME_PATH."api/getLatestTwitt.php");
require_once(THEME_PATH."api/getLatestFacebookPost.php");

function getLatestYoutubeVideo(){
   $feedURL = 'http://gdata.youtube.com/feeds/api/users/UCoXTCBvxYDESVT_oIBsgNqQ/uploads?max-results=1';
   $sxml = simplexml_load_file($feedURL);

   foreach ($sxml->entry as $entry) {
      $media = $entry->children('media', true);
      $watch = (string)$media->group->player->attributes()->url;
      $thumbnail = (string)$media->group->thumbnail[0]->attributes()->url;
   }
   return $thumbnail;
}

function cut_paragraph($string){
   $your_desired_width = 120;
   $string = substr($string, 0, $your_desired_width+1);
   
   if (strlen($string) > $your_desired_width)
   {
       $string = wordwrap($string, $your_desired_width);
       $i = strpos($string, "\n");
       if ($i) {
           $string = substr($string, 0, $i);
       }
   }
   return $string.'...';
}

// Delete calendar cache
add_action( 'wp_trash_post', 'clear_cache' );
add_action( 'save_post', 'clear_cache' );

function clear_cache($post_id){
   if( isset($post_id) && !empty($post_id)){
      $post_type = get_post_type( $post_id );
      if('sc_event'==$post_type){
         update_option('event_calendar', '');
         update_option('event_calendar_list', '');
      }   
   }
}

function true_load_posts(){
	$args = unserialize(stripslashes($_POST['query']));
	$args['paged'] = $_POST['page'] + 1;
	$args['post_status'] = 'publish';
	$q = new WP_Query($args);
	if( $q->have_posts() ):
		while($q->have_posts()): $q->the_post();
			?>
                        <div class="post">
                           <div class="img-holder">
                               <a href="<?php the_permalink();?>"><?php the_post_thumbnail('thumbnail');?></a>
                           </div>
                           <div class="text-box">
                               <h2><a href="<?php the_permalink();?>"><?php the_title()?></a></h2>
                               <div>
                                   <div class="date"> <?php echo get_the_date('F d, Y');?></div>
                               </div>
                               <p><?php the_excerpt();?> <a class="more" href="<?php echo get_permalink($post->ID); ?>"><?php
                                       _e('Read
                               More', 'academy'); ?></a></p>
                           </div>
                       </div>
			<?php
		endwhile;
	endif;
	wp_reset_postdata();
	die();
}
 
 
add_action('wp_ajax_loadmore', 'true_load_posts');
add_action('wp_ajax_nopriv_loadmore', 'true_load_posts');

function get_countdown( $class = null){
   global $wpdb;
   $current_time = current_time('timestamp');

   $event = $wpdb->get_row("SELECT pm.meta_value as start_date, pm.post_id, p.post_title as title FROM wp_postmeta pm
                                INNER JOIN wp_posts p ON p.id=pm.post_id
                                WHERE pm.meta_key = 'sc_event_date_time' AND pm.meta_value > " . $current_time . " AND p.post_status='publish'
                                GROUP BY p.id
                                ORDER BY pm.meta_value ASC");
   $event_end_date = $wpdb->get_row("SELECT meta_value as end_date FROM wp_postmeta WHERE post_id =".$event->post_id." AND meta_key = 'sc_event_end_date'");

   $year = date('Y', $event->start_date);
   $month = date('n', $event->start_date);
   $day = date('d', $event->start_date);
   $hour = date('h', $event->start_date);
   $min = date('i', $event->start_date);
   $ampm = date('a', $event->start_date);
   
   if( function_exists('simple_fields_fieldgroup') ):
      $event_link = simple_fields_fieldgroup('events_button', $event->post_id);
   endif;

   if(!empty($event)){
   ?>
   <div class="link-box <?php echo $class;?>">
      <div class="link-holder">
      <p><?php echo $event->title.' '; _e('STARTS IN');?></p>
      <div class="date-box">
         <script>
        new Countdown({
               year : <?php echo $year?>,
               month : <?php echo $month?>,
               day : <?php echo $day?>,
               hour : <?php echo $hour?>,
               ampm : "<?php echo $ampm?>",
               minute : <?php echo $min?>,
               rangeHi : 'day',
               rangeLo : 'minute',
               width: 200,
               height: 50,
               hideLine : true,
               //style:"flip",
               labelText : {
                  minute : "MINS",
                  hour   : "HOURS",
                  day    : "DAYS",
               },
               numbers : {
                  font : "industrybook",
                  color : "#FFFFFF",
                  bkgd : "#0095c3",
                  rounded : 0,
                  shadow : {
                        x : 0,
                        y : 0,
                        s : 0,
                        c : 0,
                        a : 0
                     }
               },
               labels : {
                  font   : "industrybook",
                  color  : "#ffffff",
                  offset : 8,
                  textScale  : 1.2,
                  weight : "normal" 
               }
            });
         </script>
      </div>
      <?php
      if( isset($event_link) && !empty($event_link) ){
         echo $event_link;
      }
   ?>
      </div>
   </div>
   <?php
   }
}

function filter_plugin_updates( $update ) {
   global $config;
   $DISABLE_UPDATE = $config['disabled_plugins'];


    if( !is_array($DISABLE_UPDATE) || count($DISABLE_UPDATE) == 0 ){  return $update;  }
    foreach( $update->response as $name => $val ){
        foreach( $DISABLE_UPDATE as $plugin ){
            if( stripos($name,$plugin) !== false ){
                unset( $update->response[ $name ] );
            }
        }
    }
    return $update;
}

function video_widgets_init() {	
	register_sidebar(array(
	'name' => 'Home Page Onload Video',
	'id' => 'onload-video',
	'description' => '',
	'class'         => '',
	'before_widget' => '',
	'after_widget'  => '',
	'before_title'  => '<h2 style="display:none;">',
	'after_title'   => '</h2>'));
}
add_action( 'widgets_init', 'video_widgets_init' );

add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'fancybox-css', get_stylesheet_directory_uri() . '/css/jquery.fancybox.css' );
	wp_enqueue_script( 'fancybox-js', get_stylesheet_directory_uri() . '/js/jquery.fancybox.pack.js', array('jquery'), '', true );
}

add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {

	add_menu_page( 'Extra Settings', 'Extra Settings', 'administrator', 'extra-setting', 'my_cool_plugin_settings_page', 'dashicons-admin-tools',50 );
}

function my_cool_plugin_settings_page() {
	if(isset($_POST['submit']) && $_POST['submit']!=''){
		if(update_option( 'home_page_video', stripslashes($_POST['home_page_video']))){
			add_option( 'home_page_video', $_POST['home_page_video']);
		}
	}
?>
<style>
textarea {
    margin-top: 10px;
    padding: 4px 6px;
    width: 400px;
}
.ifream-level{
width:135px;
}
</style>
<div class="wrap">
<h2>Extra Settings</h2>
<form name="extra_setting" id="extra-setting" method="post" action="" enctype="multipart/form-data">
	<table class="form-table">
        <tr valign="top">
        	<td class="ifream-level"><strong>Home Page Video Ifream</strong></td>
            <td><textarea name="home_page_video" id="home_page_video" rows="5" cols="5"><?php echo get_option( 'home_page_video');?></textarea></td>
        </tr>
        <tr valign="top">
        	<td class="ifream-level"></td>
            <td><input type="submit" name="submit" value="submit"/></td>
        </tr>
    </table>
</form>
</div>
<?php } ?>