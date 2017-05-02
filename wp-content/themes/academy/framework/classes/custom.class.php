<?php

class CustomClass{
    
    function init(){
        add_action('admin_menu', array(__CLASS__,'register_import'));
    }
    
    static function register_import(){
        add_submenu_page('tools.php', 'MCCA Import Users', 'MCCA Import Users', 'manage_options', 'mcc-import-users', array(__CLASS__,'import_page')); 
    }
    
    static function import_page(){
        ini_set("auto_detect_line_endings", true);
        
        include THEMEX_PATH.'templates/mcca-import-users.php';
    }
    
    static function import_users(){
        $data = self::parse_csv();
        if(empty($data))
            return false;
        
        echo '<p>Total '.count($data).'</p>';
        $i=0;
        foreach($data as $user){ $i++;
            $email = $user[5]['value'];
            $name = $user[0]['value'].' '.$user[1]['value'];
            $login = (!empty($user[3]['value']) && $user[3]['value'] != '*') ?  sanitize_title($user[3]['value']) : sanitize_title($name);
            $pass = $user[4]['value'];
            
            $userByEmail = get_user_by('email',$email);
            if(!empty($userByEmail)){
                echo '<p class="error">'.$i.') '.$email.' already exist</p>';
                continue;
            }
            
            $user_data = array(
                'user_login' => $login,
                'user_email' => $email,
                'display_name' => $name,
                'user_pass' => !empty($pass) ? $pass : '12345'
            );
            
            $user_id = wp_insert_user($user_data);
            
            if(is_object($user_id)){
                $m = array_pop(array_pop($user_id->errors));
                echo '<p class="error">'.$i.') '.$email.' '.$m.'</p>';
                continue;
            }
            
            update_user_meta($user_id,'user_data',$user);
            
            echo '<p class="save">'.$i.') '.$email.' saved</p>';
            flush();
        }
    }
    
    static function parse_csv(){
        if(empty($_FILES['csv_file']['tmp_name']))
            return false;
        
        $file = array();
        
        $i = 0;
        
        $delimeter = self::get_delimeter($_FILES['csv_file']['tmp_name']);
        $handle = fopen($_FILES['csv_file']['tmp_name'], "r");
        
        while (($data = fgetcsv($handle, 0, $delimeter)) !== FALSE) { $i++;
            if($i == 1){
                $keys = $data;
            }else{
                $row = array();
                foreach($keys as $i => $key){
                    $row[] = array(
                        'title' => $key,
                        'value' => $data[$i]
                    );
                }
                
                $file[] = $row;
            }
        }
        fclose($handle);
        
        return $file;
    }
    
    static function get_delimeter($path){
        $handle = fopen($path, "r");
        $data = fgetcsv($handle, 0, ";" );
        fclose($handle);
        
        if(count($data) > 30)
            return ';';
        
        return ',';
    }
}