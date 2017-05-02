<div id="footer">
			<div class="footer-holder">
                <div class="footer-block">
                    <div class="footer-content">
                        <div class="content-holder">
                            <div class="add-col-box">
                                <?php $posts = get_posts('numberposts=3'); ?>
                                <?php if(!empty($posts)){ ?>
                                    <div class="box">
                                        <h3>RECENT POSTS</h3>
                                        <ul class="list">
                                            <?php foreach($posts as $post){ ?>
                                                <li>
                                                    <?php
                                                        $tID = get_post_thumbnail_id($post->ID);
                                                        if(!empty($tID))
                                                            echo '<img src="'.THEME_URI.'resize.php?src='.wp_get_attachment_url($tID).'&w=55&h=45" width="55" height="45" />';
                                                    ?>
                                                    <div class="info">
                                                        <p><a href="<?php echo get_permalink($post->ID) ?>"><?php echo $post->post_title ?></a></p>
                                                        <span class="date"><?php echo get_the_time('F j, Y',$post->ID) ?></span>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                                <div class="box">
                                    <h3>QUICK LINKS</h3>
                                    <?php wp_nav_menu(array(
                                                'theme_location' => 'footer_quick_links',
                                                'container' => '',
                                                'menu_class' => 'list'
                                            ));
                                    ?>
                                </div>
                                <?php if(is_active_sidebar('footer_text')) { ?>
                                    <?php dynamic_sidebar('footer_text'); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-box" >
                        <h3>instagram</h3>
                        <div class="photos">
                            <?php get_in_photos() ?>
                        </div>
                        <div class="social-box">
                            <span>CONNECT WITH US</span>
                            <ul class="social-network">
                                <li><a target="_blank" href="https://www.facebook.com/michaelclarkecricketacademy" class="facebook">facebook</a></li>
                                <li><a target="_blank" href="http://www.twitter.com/_MCCA_" class="twitter">twitter</a></li>
                                <li><a target="_blank" href="http://instagram.com/mc_cricketacademy" class="instagram">instagram</a></li>
                                <li><a target="_blank" href="https://www.youtube.com/channel/UCoXTCBvxYDESVT_oIBsgNqQ" class="youtube">youtube</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="partner-box">
                    <h3>KEY PARTNERS</h3>
                    <ul class="list">
                        <li><img src="<?php echo THEME_URI ?>images/logo-3.png" width="103" height="34" alt=""></li>
                        <li><img src="<?php echo THEME_URI ?>images/logo-4.png" width="156" height="25"  alt=""></li>
                        <li><img src="http://michaelclarkeacademy.com/wp-content/uploads/2015/05/gatorade.png" width="33" height="34" alt="Gatorade"></li>
                        <li><img src="http://michaelclarkeacademy.com/wp-content/uploads/2015/05/hublot.png" width="64" height="34"  alt=""></li>
                    </ul>
                </div>
			</div>
		</div>
		<div class="footer-row">
			<div class="footer-holder">
				<span class="copyright"> <?php echo ThemexCore::getOption('copyright', '&copy; COPYRIGHT MICHAEL CLARKE CRICKET ACADEMY, '.date('Y')); ?></span>
                <div class="social-box">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer_menu',
                        'container' => '',
                        'menu_class' => 'list'
                    ));
                    ?>
                </div>
            </div>
		</div>
	</div>
    </div>
    <?php wp_footer(); ?>
<?php /*?>    <?php if(is_front_page()){?>
		<style>
        .fancybox-skin {
        background: #000 !important;
        }
        </style>
        <script>
        jQuery(document).ready(function(e) {
            var str = '<?php if (get_option( 'home_page_video')){ echo stripslashes(get_option( 'home_page_video')); }else{ echo "No Data Found.";} ?>';
            jQuery.fancybox({content: jQuery.trim(str),width: 640,height: 384,closeBtn: true});
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                jQuery('iframe').attr('width','100%');
            }
        }); 
        </script>
    <?php } ?>
<?php */?>
</body>
</html>