<?php 
global $current_user,$post;

$user_resources = get_user_meta($current_user->ID,'user_resources',true);

$is_own = isset($current_user->caps['administrator']) ? true : false;

if(!empty($user_resources)){
    foreach($user_resources as $res){
        if($res == $post->ID){
            $is_own = true;
        }
    }
}

if(!$is_own){
    wp_redirect(get_bloginfo('home'));
    exit;
}

get_header(); ?>

<div class="title-box">
	<div class="title-holder">
        <?php breadcrumbs() ?>
		
		<div class="info">	
            <?php
                $category = wp_get_post_terms($post->ID,'resources');
            ?>		
			<h1><?php echo $category[0]->name ?></h1>
		</div>
		<div class="img-holder">
			<img src="<?php echo THEME_URI ?>images/img-1.png"  alt="">
		</div>
	</div>
</div>
<div class="account-box">
    <?php get_sidebar('menu') ?>
    <div class="content">
        <div class="content-holder">
            <?php echo apply_filters('the_content',$post->post_content); ?>
            <?php $content = simple_fields_fieldgroup('page_content'); ?>
            <?php if(!empty($content)){ ?>
                <?php foreach($content as $row){ ?>
                	<div class="article-box">
                        <?php $img = wp_get_attachment_url($row['img']) ?>
                        <?php $text = apply_filters('the_content',$row['text']) ?>
                        <div class="col <?php echo ($row['side_img'] == 'radiobutton_num_2') ? 'left' : 'right'; ?>">
                            <img src="<?php echo $img ?>"  alt="">
                		</div>
                		<div class="col">
                			<div class="col-holder">
                				<?php 
                                    echo $text;
                                    if(!empty($row['share']))
                                        echo '<a href="#">SHARE THIS</a>';
                                ?>
                            </div>
                		</div>
                	</div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<script>
(function( $ ) {
$(function() {
    if($('.ngg-galleryoverview').length){
        $('.account-box').addClass('resources');
    }
});
})(jQuery);
</script>
<?php get_footer(); ?>
