
<h1>MY RESOURCES</h1>
<span>Once available, your Michael Clarke Cricket Academy resources will be available below. </span>
<div class="holder-box">
    <?php $cats = get_terms('resources',array('hide_empty' => false)); ?>
    <?php if(!empty($cats)){ ?>
        <?php
            global $current_user;
            $user_resources = get_user_meta($current_user->ID,'user_resources',true);
            $resources = array();
            
            if(!empty($user_resources)){
                foreach($user_resources as $res){
                    $post = get_post($res);
                    $post->cats = wp_get_post_terms($res,'resources');
                    $resources[] = $post;
                }    
            }
        ?>
        <?php for($i=0;$i<8;$i++){ 
                $cat = $cats[$i];
        ?>
            <div class="box">
                <?php if(!empty($cat)){ ?>
                    <?php
                        $link = '#';
                        foreach($resources as $resource){
                            foreach($resource->cats as $resource_cat){
                                if($cat->term_id == $resource_cat->term_id){
                                    $file = simple_fields_fieldgroup('file',$resource->ID);
                                    
                                    if(!empty($file)){
                                        $link = wp_get_attachment_url($file);
                                    }else{
                                        $link = get_permalink($resource->ID);
                                    }
                                }
                            }
                        }
                    ?>
                    <div class="img-holder">
                        <img class="holder" src="<?php echo THEME_URI ?>images/bg-border.png" width="158" height="158" alt="">
                        <img src="<?php echo THEME_URI ?>resize.php?src=<?php echo z_taxonomy_image_url($cat->term_id) ?>&w=158&h=158<?php echo ($link == '#') ? '&gc=on' : '' ?>"  width="158" height="158" alt="">
                    </div>
                    <a <?php echo ($link != '#') ? 'href="'.$link.'"' : ''; ?> class="link <?php echo ($link == '#') ? 'gray-link' : ''; ?>"><?php echo $cat->name ?></a>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
    
</div>
       