<?php 
/*
Template Name: full width text
*/
get_header(); ?>
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
        <div class="full-width-text article-box"><?php echo apply_filters('the_content',$post->post_content); ?></div>
    <?php } ?>
    <?php get_countdown();?>
</div>
<?php get_footer(); ?>