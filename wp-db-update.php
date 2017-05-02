<?php require_once 'wp-load.php';
ini_set('max_execution_time','600');
$new_site_url_tmp = 'http://'.$_SERVER['HTTP_HOST'].str_replace('/wp-db-update.php','',$_SERVER['REQUEST_URI']);
$old_site_url_tmp = str_replace('http://','',get_option('home'));

$tables = array();
$fields = array();

$errors = array();
	
if(isset($_POST['submitted'])){
	$new_site_url = str_replace('http://','',$_POST['siteurl']);

	$tables_result = mysql_list_tables(DB_NAME);

	while($row = mysql_fetch_array($tables_result,MYSQL_NUM)){
		$tables[] = $row[0];
	}	
	
	foreach($tables as $table){
		$result = mysql_list_fields(DB_NAME,$table);
		$columns = mysql_num_fields($result);
		for ($i = 0; $i < $columns; $i++) {
		    $fields[$table][] = mysql_field_name($result, $i);
		}
	}
	
	if($new_site_url == $old_site_url_tmp){
		$errors[] = 'The old and the new domain should be different';
	}
	if(empty($errors)){
		foreach($fields as $table=>$field){
			$query = "UPDATE $table SET ";
			foreach($field as $one){
				$query .= "$one = REPLACE($one,'$old_site_url_tmp','$new_site_url'),";
			}
			$query = substr($query,0,strlen($query)-1);
			mysql_query($query);
		}
		$message = 'Data Base have been updated.';	
	}
}

// нужно что б при обновлении выводить не закешированый результат
function get_wp_blog_url(){
	global $wpdb;
    
    $home = $wpdb->get_row("SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'home'");
    return $home->option_value;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<html>
<head>
	<title>Wordpress Host Update script by LAZER</title>
	<style type="text/css">
		html{background:#e4f9e9;}
		body {font:13px/18px "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif; color:#333; padding:10px;}
		a{ color:#224466; text-decoration:none; }
		a:hover{ color:#D54E21; }
		img {border:none;}
		form {border:none;}
		form fieldset{border:1px solid #80B5D0; padding:10px;-moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px; border-radius: 10px; }
		form label{ font-weight:bold; padding:0 0 3px; }
		form label em { font-style:normal; font-weight:normal; }
		form input.text { padding:4px; color: #555; font-size:18px; width: 97%; }
		form input.submit {
			color:#224466;
			background-color:#CEE1EF;
			border:1px solid #80B5D0;
			cursor:default;
			font:bold 13px "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;
			padding:3px 5px;
			text-decoration:none;
			-moz-border-radius: 10px; /* Firefox */
			-webkit-border-radius: 10px; /* Safari, Chrome */
			-khtml-border-radius: 10px; /* KHTML */
			border-radius: 10px; /* CSS3 */
			cursor:pointer;

		}
		form input.submit:hover { border-color:#328AB2; color:#D54E21; }
		#header {border-bottom:5px solid #464646; padding:0 0 10px; overflow:hidden; height:70px;}
		#header .left{ float:left; }
		#header .right{ float:right; }
		#content { background:#eaf3fa; width:450px; padding:20px; margin:75px auto 0; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px; border-radius: 10px;}
		#content p { margin:0; padding: 0 0 10px; }
		#content p.buttons { margin:20px 0 0; width:435px; } 
		#content .errors { color:#d00; font-weight:bold; padding:0 0 10px; }
		#content .messages { color:#0d0; font-weight:bold; padding:0 0 10px; }
		#footer {border-top:5px solid #464646; margin:75px auto 0; padding:20px; text-align:center; font-size:14px;}
	</style>
</head>
<body>
	<div id="header">
		<a title="Powered by WordPress" href="http://wordpress.org/" class="left"><img src="wp-admin/images/wordpress-logo.png"></a>
		
	</div>
	<div id="content">
		<?php 
			if(!empty($errors)){
				foreach($errors as $error){
					echo "<p class='errors'>$error</p>";
				}
			}
			if(!empty($message)){
				echo "<p class='messages'>$message</p>";
			}
		?>
		<form action="" method="post">
			<fieldset>
				
				<label for="siteurl">Enter Your blog site url</label><br />
				<input id="siteurl" type="text" name="siteurl" size="40" value="<?php echo $new_site_url_tmp ?>" class="text" /><br />
				<span>current url is: <b><?php echo get_wp_blog_url() ?></b></span><br /><br />
				
				<p class="buttons" align="right">
					<input type="submit" name="submitted" value="Update" class="submit" />
				</p>
			</fieldset>
		</form>
	</div>
	<div id="footer">	
		Copyright &copy;<?php echo date('Y'); ?> <a href="http://vkontakte.ru/xlazerx" target="_blank"><b>LAZER</b></a>. All rights reserved.
	</div>
</body>
</html>