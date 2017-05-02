<div class="sidebar">
    <div class="box">
        <?php echo get_avatar(ThemexUser::$data['active_user']['ID'], 158); ?>
        <h2><?php echo ThemexUser::$data['active_user']['login'] ?></h2>
        <span>GRADUATE SEPTEMBER 2014</span>
        <a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>?page=edit" class="link">EDIT MY PROFILE</a>
        <p>Select a link below to access <br /> your graduate resources.</p>
    </div>
    
    <ul class="add-nav">
        <li <?php echo (!is_singular('user-resources') && !isset($_GET['page'])) ? 'class="active"' : ''; ?>><a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>">WELCOME!</a></li>
        <li <?php echo (isset($_GET['page']) && $_GET['page'] == 'edit') ? 'class="active"' : ''; ?>><a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>?page=edit">MY PROFILE</a></li>
        <li <?php echo (is_singular('user-resources') || (isset($_GET['page']) && $_GET['page'] == 'view')) ? 'class="active"' : ''; ?>><a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>?page=view">MY RESOURCES</a></li>
        <!-- li><a href="<?php echo get_academy() ?>">ACADEMY</a></li -->
        <li style="display: none;"><a href="#">MESSAGES FROM MC <span>3 new</span></a></li>
        <li <?php echo (isset($_GET['page']) && $_GET['page'] == 'pay') ? 'class="active"' : ''; ?>><a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>?page=pay">PAYMENTS</a></li>
    </ul>
</div>