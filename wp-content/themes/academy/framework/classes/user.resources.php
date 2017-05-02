<?php

class UserResources{
    static $user = null;
    
    function init(){
        add_action('init',array(__CLASS__,'resourcesType'));
        add_action('edit_user_profile',array(__CLASS__,'profile_html'));
        add_action('show_user_profile',array(__CLASS__,'profile_html'));
        add_action('manage_users_columns',array(__CLASS__,'custom_columns'));
        add_action('manage_users_custom_column',array(__CLASS__,'display_column'),10,3);
        
        add_action('wp_ajax_resourceAjax',array(__CLASS__,'AJAXCallback'));
        
        if(!empty($_GET['user_id']))
            self::$user = get_user_by('id',$_GET['user_id']);
        else{
            self::$user = wp_get_current_user();
        }
    }
    
    static function resourcesType(){
        $labels = array(
            'name'                => 'User Resources',
            'singular_name'       => 'User Resource',
            'menu_name'           => 'User Resources',
            'parent_item_colon'   => 'Parent Resource',
            'all_items'           => 'All Resources',
            'view_item'           => 'View Resource',
            'add_new_item'        => 'Add New Resource',
            'add_new'             => 'Add New',
            'edit_item'           => 'Edit Resource',
            'update_item'         => 'Update Resource',
            'search_items'        => 'Search Resource',
            'not_found'           => 'Not Found',
            'not_found_in_trash'  => 'Not found in Trash',
        );
         
        $args = array(
            'label'               => 'User Resources',
            'description'         => '',
            'labels'              => $labels,
            'supports'            => array( 'title','editor' ),
            'taxonomies'          => array(),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type('user-resources', $args );
        
        $labels = array(
        	'name' => 'Resources Categories'
        	,'singular_name' => 'Category'
        	,'search_items' => 'Search Category'
        	,'all_items' => 'All Categories'
        	,'parent_item' => 'Parent Category'
        	,'parent_item_colon' => 'Parent Category:'
        	,'edit_item' => 'Edit Category'
        	,'update_item' => 'Update Category'
        	,'add_new_item' => 'Add New Category'
        	,'new_item_name' => 'New Category Name'
        	,'menu_name' => 'Categories'
        ); 

        $args = array(
        	'label' => '' 
        	,'labels' => $labels
        	,'public' => true
        	,'show_in_nav_menus' => true 
        	,'show_ui' => true 	
        	,'show_tagcloud' => true 
        	,'hierarchical' => true
        	,'update_count_callback' => ''
        	,'rewrite' => true
        	,'query_var' => ''
        	,'capabilities' => array()
        	,'_builtin' => false
        );
        register_taxonomy('resources', 'user-resources', $args);
    }
    
    static function profile_html(){
        include THEMEX_PATH.'templates/profile.php';
    }
    
    static function display($data = array()){
        echo json_encode($data);
        die;
    }
    
    static function custom_columns($columns){
        $columns['resources'] = 'attached resources';
        return $columns;
    }
    
    static function display_column($a,$column,$user_id){
        if($column != 'resources')
            return false;
        
        $html = '<ol>';
        $resources = array();
        $user_resources = get_user_meta($user_id,'user_resources',true);
        if(!empty($user_resources)){
            foreach($user_resources as $res){
                $post = get_post($res);
                
                $html .= '<li><a target="_blank" href="post.php?post='.$post->ID.'&action=edit">'.$post->post_title.'</a></li>';
            }
        }else{
            $html .= 'no resources';
        }
        
        $html .= '</ol>';
        
        return $html;
    }
    
    static function AJAXCallback(){
        if(empty($_POST['method']))
            self::display(array('status' => 'error', 'error' => 'unknown method'));
        
        switch($_POST['method']){
            case 'get_resources': {
                    $tax_query = array(
                        'taxonomy' => 'resources',
                        'field' => 'term_id'
                    );
                    
                    $post_args = array(
                        'showposts' => -1,
                        'post_type' => 'user-resources'
                    );
                    
                    $tax_query['terms'] = $_POST['cat_id'];
                    $post_args['tax_query'] = array($tax_query);
                    
                    $resources = get_posts($post_args);
                    
                    self::display(array('status' => 'ok', 'data' => $resources));
                break;
            }
            case 'add': {
                    if(empty($_POST['resources']))
                        self::display(array('status' => 'error'));
                    
                    $user_resources = get_user_meta($_POST['user_id'],'user_resources',true);
                    if(empty($user_resources))
                        $user_resources = array();
                    
                    foreach($_POST['resources'] as $res){
                        $user_resources[$res] = $res;
                    }
                    
                    update_user_meta($_POST['user_id'],'user_resources',$user_resources);
                    
                    $data = array();
                    foreach($user_resources as $res){
                        $data[] = get_post($res);
                    }
                    
                    self::display(array('status' => 'ok','data' => $data));
                break;
            }
            case 'remove':{
                    if(empty($_POST['resources']))
                        self::display(array('status' => 'error'));
                    
                    $user_resources = get_user_meta($_POST['user_id'],'user_resources',true);
                    foreach($user_resources as $key => $res){
                        if(in_array($res,$_POST['resources']))
                            unset($user_resources[$key]);
                    }
                    
                    update_user_meta($_POST['user_id'],'user_resources',$user_resources);
                    
                    $data = array();
                    foreach($user_resources as $res){
                        $data[] = get_post($res);
                    }
                    
                    self::display(array('status' => 'ok','data' => $data));
                break;
            }
            case 'updateUser':{
                    update_user_meta($_POST['user_id'],'user_data',$_POST['data']);
                    wp_redirect($_POST['redirect']);
                break;
            }
        }
        
        exit;
    }
}