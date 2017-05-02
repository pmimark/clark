<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0 " />
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
	
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo THEME_URI; ?>js/html5.js"></script>
	<![endif]-->
	
    <script>var ajaxUrl = '<?php echo AJAX_URL ?>';</script>
    
	<?php wp_head(); ?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '802339399869473');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=802339399869473&ev=PageView&noscript=1"
/></noscript>
<!-- DO NOT MODIFY -->
<!-- End Facebook Pixel Code -->

</head>
<body <?php body_class(); ?>>
<div class="site-wrap">
	<div class="header-wrap">
        <div class="site-header">
            <div class="link-box">
                <?php if(get_option('users_can_register')) { ?>
                    <div class="button-wrap left">
                        <a href="<?php echo ThemexCore::getURL('register'); ?>" class="button">
                            <span class="button-icon register"></span><?php _e('APPLY NOW','academy'); ?>
                        </a>
                    </div>
                <?php } ?>
                <div class="button-wrap left tooltip login-button">
                    <a href="#" class="button dark"><span class="button-icon login"></span><?php _e('Sign In','academy'); ?></a>
                    <div class="tooltip-wrap">
                        <div class="tooltip-text">
                            <form action="<?php echo AJAX_URL; ?>" class="ajax-form popup-form" method="POST">
                                <div class="message"></div>
                                <div class="field-wrap">
                                    <input type="text" name="user_login" value="<?php _e('Username','academy'); ?>" />
                                </div>
                                <div class="field-wrap">
                                    <input type="password" name="user_password" value="<?php _e('Password','academy'); ?>" />
                                </div>
                                <div class="button-wrap left nomargin">
                                    <a href="#" class="button submit-button"><?php _e('Sign In','academy'); ?></a>
                                </div>
                                <?php if(ThemexFacebook::isActive()) { ?>
                                    <div class="button-wrap left">
                                        <a href="<?php echo ThemexFacebook::getURL(); ?>" title="<?php _e('Sign in with Facebook','academy'); ?>" class="button facebook-button">
                                            <span class="button-icon facebook"></span>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="button-wrap switch-button left">
                                    <a href="#" class="button dark forgot-pass" title="<?php _e('Password Recovery','academy'); ?>">
                                        <span class="button-icon help">Forgot password</span>
                                    </a>
                                </div>
                                <input type="hidden" name="user_action" value="login_user" />
                                <input type="hidden" name="user_redirect" value="<?php echo themex_value($_POST, 'user_redirect'); ?>" />
                                <input type="hidden" name="nonce" class="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
                                <input type="hidden" name="action" class="action" value="<?php echo THEMEX_PREFIX; ?>update_user" />
                            </form>
                        </div>
                    </div>
                    <div class="tooltip-wrap password-form">
                        <div class="tooltip-text">
                            <form action="<?php echo AJAX_URL; ?>" class="ajax-form popup-form" method="POST">
                                <div class="message"></div>
                                <div class="field-wrap">
                                    <input type="text" name="user_email" value="<?php _e('Email','academy'); ?>" />
                                </div>
                                <div class="button-wrap left nomargin">
                                    <a href="#" class="reset-bnt button submit-button"><?php _e('Reset','academy'); ?></a>
                                </div>
                                <input type="hidden" name="user_action" value="reset_password" />
                                <input type="hidden" name="nonce" class="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
                                <input type="hidden" name="action" class="action" value="<?php echo THEMEX_PREFIX; ?>update_user" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-box">
                <a href="#" class="menu">menu</a>
                <div class="img-header-wrap">
                    <img src="<?php echo THEME_URI; ?>images/img-14.png" alt="">
                </div>
                <div class="social-box">
                    <ul class="social-network">
                        <li><a target="_blank" href="http://instagram.com/mc_cricketacademy" class="instagram">instagram</a></li>
                        <li><a target="_blank" href="https://www.facebook.com/michaelclarkecricketacademy" class="facebook">facebook</a></li>
                        <li><a target="_blank" href="http://www.twitter.com/_MCCA_" class="twitter">twitter</a></li>
                        <li><a target="_blank" href="https://www.youtube.com/channel/UCoXTCBvxYDESVT_oIBsgNqQ" class="youtube">youtube</a></li>
                    </ul>
                    <span>mcca social network</span>
                </div>
                <div class="logo-box"><a href="<?php echo SITE_URL ?>"><img src="<?php echo THEME_URI; ?>images/new-logo.png" alt=""></a></div>
            </div>
        </div>
        <div class="header-content">
            <div class="nav-holder">
                <?php wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'container' => '',
                    'menu_class' => 'menu-header-menu'
                ));
                ?>
                <ul class="nav">
                    <li><a href="<?php echo get_permalink(2) ?>">THE ACADEMY</a></li>
                    <li><a class="line" href="<?php echo get_permalink(142) ?>">MICHAEL CLARKE</a></li>
                    <li><a href="<?php echo get_permalink(143) ?>">LATEST NEWS</a></li>
                    <li><a class="line" href="<?php echo get_permalink(146) ?>">PHOTO GALLERY</a></li>
                    <li><a href="#" class="account-link">MY ACCOUNT</a></li>
                    <li><a class="button dark" href="<?php echo ThemexCore::getURL('register'); ?>">SIGN IN</a></li>
                    <!--li><a class="button" href="<?php echo ThemexCore::getURL('register'); ?>">APPLY NOW</a></li-->
                </ul>
            </div>
        </div>
   	</div>
</div>