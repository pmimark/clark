<?php get_header(); ?>
<?php global $post; ?>
<div class="social-block">
	<ul class="social-network">
		<li><a href="http://instagram.com/mc_cricketacademy" target="_blank" class="instagram">instagram</a></li>
		<li><a href="https://www.facebook.com/michaelclarkecricketacademy" target="_blank" class="facebook">facebook</a></li>
		<li><a href="http://www.twitter.com/_MCCA_" target="_blank" class="twitter">twitter</a></li>
		<li><a href="https://www.youtube.com/channel/UCoXTCBvxYDESVT_oIBsgNqQ" target="_blank" class="youtube">youtube</a></li>
	</ul>
	<span>CONNECT WITH US</span>
</div>
<div class="title-box">
	<div class="title-holder">
		<?php breadcrumbs() ?>
		<div class="info">			
			<h1><?php echo $post->post_title ?></h1>
			<?php  
                $sub = simple_fields_fieldgroup('sub_title');
                if(!empty($sub))
                    echo '<strong>'.$sub.'</strong>';
            ?>
		</div>
		<div class="img-holder">
			<img src="<?php echo THEME_URI ?>images/img-1.png"  alt="">
		</div>
	</div>
</div>
<div class="main-content">
    <?php if(post_password_required()){ ?>
        <div class="to-center"><?php the_content(); ?></div>
    <?php }else{ ?>
        <?php echo apply_filters('the_content',$post->post_content); ?>
        <?php $content = simple_fields_fieldgroup('page_content'); ?>
        <?php if(!empty($content)){ ?>
            <?php foreach($content as $row){ ?>
            	<div class="article-box">
                    <?php $img = wp_get_attachment_url($row['img']) ?>
                    <?php $text = apply_filters('the_content',$row['text']) ?>
                    <div class="col <?php echo ($row['side_img'] == 'radiobutton_num_2') ? 'left' : 'right'; ?>">
                        <img class="box-image" src="<?php echo $img ?>"  alt="" />
            		</div>
            		<div class="col body-text">
            			<div class="col-holder">
            				<?php 
                                echo $text;
                                if(!empty($row['share']))
                                    echo '<a class="share-btn" href="https://www.facebook.com/dialog/feed?app_id='.FB_APP_ID.'&link='.get_permalink($post->ID).'&picture='.$img.'&name='.$post->post_title.'&description='.cut_text($text,200).'&redirect_uri='.admin_url("admin-ajax.php").'?action=fbredirect">SHARE THIS</a>';
                            ?>
                        </div>
            		</div>
            	</div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <?php get_countdown();?>
</div>
<?php get_footer(); ?>