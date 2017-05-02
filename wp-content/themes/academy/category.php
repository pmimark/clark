<?php 
get_header(); 
global $post;
$category = $wp_query->queried_object;
$cur_cat_id = $category->term_id;
?>
<div class="social-block">
	<ul class="social-network">
		<li><a href="http://instagram.com/mc_cricketacademy" target="_blank" class="instagram">instagram</a></li>
		<li><a href="https://www.facebook.com/michaelclarkecricketacademy" target="_blank" class="facebook">facebook</a></li>
		<li><a href="http://www.twitter.com/_MCCA_" target="_blank" class="twitter">twitter</a></li>
		<li><a href="#" target="_blank" class="youtube">youtube</a></li>
	</ul>
	<span>CONNECT WITH US</span>
</div>
<div class="title-box">
	<div class="title-holder">
		<?php //breadcrumbs() ?>
		<div class="info">			
			<h1><?php echo get_category($cur_cat_id)->name;?></h1>
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
        <div class="full-width-text article-box">
		<?php if (have_posts()) : ?>          
			<?php while (have_posts()) : the_post();?>
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
			<?php endwhile; ?>
		<?php endif; ?>

		<?php if (  $wp_query->max_num_pages > 1 ) : ?>
			<script id="true_loadmore">
			var ajaxurl = '<?php echo AJAX_URL; ?>';
			var true_posts = '<?php echo serialize($wp_query->query_vars); ?>';
			var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
			</script>
		<?php endif; ?>
	</div>
	<div class="holder-div"><img src="<?php echo THEME_URI ?>images/ajax-loader.gif"/></div>
	<?php get_countdown();?>
</div>
<?php get_footer(); ?>