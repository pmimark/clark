<?php get_header();?>
<?php global $post;
if( function_exists('simple_fields_fieldgroup') ):
    $author = simple_fields_fieldgroup('author', $post->ID);
endif;
$post_thmb = get_the_post_thumbnail($post->ID, "medium");
?>
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
			<?php $category = get_the_category($post->ID);?>
			<h1><?php echo $category[0]->name;?></h1>
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

	<div class="to-center">
		<div class="post">
            <div class="img-holder">
                <?php echo  get_the_post_thumbnail($post->ID, 'medium');?>
            </div>
			<div class="text-box <?php echo (empty($post_thmb)?"full-width-text":"");?>">
			    <h2><?php echo get_the_title($post->ID);?></h2>
			    <div>
				<div class="date"> <?php echo get_the_date('F d, Y', $post->ID);?></div>
				<?php if(!empty($author)):?>
				<div class="date"><?php echo $author;?></div>
				<?php endif;?>
			    </div>
			    <p><?php echo apply_filters('the_content',$post->post_content);?></p>
			</div>

		</div>
	</div>

	<?php get_countdown();?>
</div>
<?php get_footer(); ?>