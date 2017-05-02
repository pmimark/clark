<?php get_header();
if( function_exists('simple_fields_fieldgroup') ):
    $team = simple_fields_fieldgroup('team', HOME_ID);
    $compare_programs = simple_fields_fieldgroup('compare_programs', HOME_ID);
    $compare_programs_items = simple_fields_fieldgroup('compare_programs_items', HOME_ID);
    $training_programs_top = simple_fields_fieldgroup('training_programs_top', HOME_ID);
    $training_programs_bot = simple_fields_fieldgroup('training_programs_bot', HOME_ID);
    $main_slider = simple_fields_fieldgroup('main_slider', HOME_ID);
endif;
$events_list = get_posts( array('post_type'=>'sc_event') );
?>
<div class="social-block">
	<ul class="social-network">
        <li><a href="http://instagram.com/mc_cricketacademy" target="_blank" class="instagram">instagram</a></li>
		<li><a href="https://www.facebook.com/michaelclarkecricketacademy" target="_blank" class="facebook">facebook</a></li>
		<li><a href="http://www.twitter.com/_MCCA_" target="_blank" class="twitter">twitter</a></li>
		<li><a href="https://www.youtube.com/channel/UCoXTCBvxYDESVT_oIBsgNqQ" target="_blank" class="youtube">youtube</a></li>
	</ul>
	<span>SOCIAL NETWORK</span>
</div>
    <div class="add-form-box">
        <div class="form-holder">
            <div class="box">
                <span>SPRING SESSION: <span class="mark">SEPTEMBER 22-26, 2014</span></span>
            </div>
        </div>
    </div>
<?php if( !empty($main_slider) ):?>
<div class="gallery-holder">
    <div class="gallery-box">
        <?php foreach( $main_slider as $slide): ?>
	<div class="slick-slide">
            <div class="slide-text">
                <div class="text">
                    <h2><?php echo $slide['title'];?></h2>
                    <?php echo $slide['content'];?>
                    <div class="link-box">
                        <a href="<?php echo $slide['left_link'];?>"><?php echo $slide['left_link_title'];?></a>
                        <a href="<?php echo $slide['right_link'];?>"><?php echo $slide['right_link_title'];?></a>
                    </div>
                </div>
            </div>
            <img src="<?php echo wp_get_attachment_url($slide['img']) ?>">
        </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>
<div class="main-content">
	<?php if( !empty($training_programs_top) ):?>
		<div class="info-block clarke-bg">
			<div class="info-holder">
		    <h2><?php echo $training_programs_top['title'];?></h2>
		    <div class="col-holder">
			<div class="col">
			   <strong><?php echo $training_programs_top['left_title'];?></strong>
			    <span class="date"><?php echo $training_programs_top['left_date'];?></span>
			    <?php echo $training_programs_top['left_content'];?>
			    <a href="<?php echo $training_programs_top['left_link'];?>">VIEW THIS <span> PROGRAM</span></a>
			</div>
			<div class="col">
			    <strong><?php echo $training_programs_top['right_title'];?></strong>
			    <span class="date"><?php echo $training_programs_top['right_date'];?></span>
			    <?php echo $training_programs_top['right_content'];?>
			    <a href="<?php echo $training_programs_top['right_link'];?>">VIEW THIS <span> PROGRAM</span></a>
			</div>
		    </div>
			</div>
		</div>
	<?php endif;?>
	<?php if( !empty($events_list) ):?>	
		<?php  echo do_shortcode('[sc_events_calendar]');?>
	<?php endif;?>
    <?php if( !empty($training_programs_bot) ):?>
	<div class="info-block-1">
	    <div class="info-holder">
		<h2><?php echo $training_programs_bot['title'];?></h2>
		<div class="col-holder">
		    <div class="col">
			<strong><?php echo $training_programs_bot['left_title'];?></strong>
			<span class="date"><?php echo $training_programs_bot['left_date'];?></span>
			<?php echo $training_programs_bot['left_content'];?>
			<a href="<?php echo $training_programs_bot['left_link'];?>">SEE <span> PROGRAM</span></a>
		    </div>
		    <div class="col">
			<strong><?php echo $training_programs_bot['right_title'];?></strong>
			<span class="date"><?php echo $training_programs_bot['right_date'];?></span>
			<?php echo $training_programs_bot['right_content'];?>
			<a href="<?php echo $training_programs_bot['right_link'];?>">SEE <span> PROGRAM</span></a>
		    </div>
		</div>
	    </div>
	</div>
    <?php endif;?>
    <?php get_countdown();?>
    <?php if( !empty($compare_programs) ):?>
	<div class="program-box">
	    <?php if( !empty($compare_programs['title'])):?>
		    <h2><?php echo $compare_programs['title'];?></h2>
	    <?php endif; if( !empty($compare_programs['description'])):?>
		    <?php echo $compare_programs['description'];?>
	    <?php endif;?>
	    <ul class="list-box">
		<?php foreach( $compare_programs_items as $compare_programs_item):?>
		<li  class="box">
		    <h3><?php echo $compare_programs_item['title'];?></h3>
		    <strong><?php echo $compare_programs_item['subtitle'];?></strong>
		    <div class="logo-block">
			<img src="<?php echo wp_get_attachment_url($compare_programs_item['img']) ?>" alt="<?php echo $compare_programs_item['title'];?>">
		    </div>
		    <ul class="list">
                <li><?php echo $compare_programs_item['feature_1'];?></li>
                <li><?php echo $compare_programs_item['feature_2'];?></li>
                <li><?php echo $compare_programs_item['feature_3'];?></li>
                <li><?php echo $compare_programs_item['feature_4'];?></li>
                <li><?php echo $compare_programs_item['feature_5'];?></li>
		    </ul>
            <div class="link-box">
		        <a href="<?php echo $compare_programs_item['read_more'];?>" class="more">READ <span>MORE</span></a>
		        <a href="<?php echo $compare_programs_item['apply_now'];?>" class="link-now"><?php echo $compare_programs_item['link_title'];?></a>
            </div>
        </li>
		<?php endforeach;?>
	    </ul>
	</div>
    <?php endif;?>
    <?php if( !empty($compare_programs_items) ):?>
	<div class="team-box">
	    <div class="text-box">
		<h2>MEET THE TEAM</h2>
		<p>Michael has personally selected his coaching and mentoring team for the Academy and they all share his vision of creating a centre of excellence for young talented cricketers from Australia and around the globe.</p>
	    </div>
	    <div class="slide-holder">
		<?php foreach( $team as $item):?>
		<div class="slide-box">
		    <a>
    			<img src="<?php echo wp_get_attachment_url($item['img']) ?>" alt="<?php echo $item['name'];?>">
    			<span class="tooltip"><strong><?php echo $item['name'];?></strong><?php echo $item['option'];?></span>
		    </a>
		</div>
		<?php endforeach;?>
	    </div>
	</div>
    <?php endif;?>
    <div class="social-box">
        <div class="social-holder">
            <h2>SOCIAL NETWORK</h2>
            <ul class="social-list">
                <li class="facebook-block">
                    <p><?php echo getLastFacebookPost();?></p>
                    <a href="https://www.facebook.com/michaelclarkecricketacademy" class="facebook" target="_blank">Like our page</a>
                </li>
                <li class="twitter-block">
                    <p><?php echo getLastTwitt();?></p>
                    <a href="http://www.twitter.com/_MCCA_" target="_blank" class="twitter">Follow us</a>
                </li>
                <li class="instagram-block instagram-box">
                    <div class="photo">
                        <?php get_in_photos() ?>
                    </div>
                    <a href="http://instagram.com/mc_cricketacademy" target="_blank" class="instagram">See more photos</a>
                </li>
                <!--<li class="youtube-block">
                    <div class="img-holder">
                        <img src="<?php echo getLatestYoutubeVideo();?>">
                    </div>
                    <a href="https://www.youtube.com/channel/UCoXTCBvxYDESVT_oIBsgNqQ" target="_blank" class="youtube">Go to our channel</a>
                </li>-->
            </ul>
        </div>
    </div>
    <?php get_countdown('second-counter');?>
<?php get_footer() ?>