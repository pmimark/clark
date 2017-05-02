<?php

$welcome = get_post_by_name('profile-welcome','page');
$content = str_replace('{username}',strtoupper(ThemexUser::$data['active_user']['login']),$welcome->post_content);

echo apply_filters('the_content',$content);