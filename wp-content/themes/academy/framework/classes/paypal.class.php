<?php

class PaypalClass{
    
    function init(){
        add_action('admin_menu',array(__CLASS__,'payBtnOpt'));
        add_action('wp_ajax_pay_deposit',array(__CLASS__,'pay_deposit'));
        add_action('woocommerce_api_wc_gateway_paypal',array(__CLASS__,'payCompleted'));
        
        add_filter('woocommerce_paypal_args',array(__CLASS__,'paypal_args'));
    }
    
    static function pay_deposit($product_id = false){
        $prod_id = $product_id ? $product_id : $_POST['product_id'];
        if(self::in_cart($prod_id)){
            echo json_encode(array('in_cart' => true));
            exit;
        }
        
        echo json_encode(array('in_cart' => false));
        
        exit();
    }
    
    static function in_cart($prod_id){
        global $woocommerce;
        
        $prods = $woocommerce->cart->get_cart();
        
        foreach($prods as $prod){
            if($prod['product_id'] == $prod_id){
                return true;
            }
        }
        
        return false;
    }
    
    static function payCompleted(){
        if(strtolower($_POST['payment_status']) == 'completed'){
            $custom = unserialize(stripcslashes($_POST['custom']));
            
            update_user_meta($custom['user_id'],'MCCA_'.$custom['action'],'completed');
        }
    }
    
    static function paypal_args($paypal_args){
        global $current_user,$woocommerce;
        
        $action = 'balance';
        
        $deposit = get_post_by_name('deposit','product');
        if(self::in_cart($deposit->ID)){
            $action = 'deposit';
        }
        
        $custom = unserialize($paypal_args['custom']);
        $custom['user_id'] = $current_user->ID; 
        $custom['action'] = $action;
        
        $paypal_args['custom'] = serialize($custom);
        
        update_user_meta($current_user->ID,'MCCA_'.$action,'pending');
        
        return $paypal_args;
    }
    
    static function payBtnOpt(){
        add_submenu_page('options-general.php','Pay Buttons','Pay Buttons','manage_options','pay-buttons',array(__CLASS__,'payButtonsPage'));
    }
    
    static function payButtonsPage(){
        if(isset($_POST['save'])){
            $data = array(
                'deposit' => isset($_POST['deposit']) ? true : false,
                'balance' => isset($_POST['balance']) ? true : false
            );
            
            update_option('pay-buttons',$data);
        }
        
        include THEMEX_PATH.'templates/pay-buttons.php';
    }
}