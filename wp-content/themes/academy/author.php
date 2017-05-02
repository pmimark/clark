<?php get_header(); ?>
<div class="title-box">
	<div class="title-holder">
		<ul class="breadcrumbs">
            <li><a href="<?php bloginfo('home') ?>">Home</a></li>
            <li>MY PROFILE</li>
        </ul>
		<div class="info">			
			<h1>MY&nbsp;PROFILE</h1>
			<strong>ARE YOU READY TO DREAM BIG? START NOW!</strong>
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
<?php
    switch($_GET['page']){
        case 'edit':
            include 'profile-edit.php';
        break;
        case 'view':
            include 'profile-view.php';
        break;
        case 'pay':
            include 'profile-pay.php';
        break;
        default:
            include 'profile-welcome.php';
        break;
    }
?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
