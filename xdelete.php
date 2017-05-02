<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
$time = ini_set('max_execution_time','0');

$pass = '152a3e24'; // Пароль для запуска интерфейса скрипта. Если хотите можите его изменить :)

if(isset($_POST['pass']) && $_POST['pass']==$pass){
	$_SESSION['xdelete_user'] = 'yes';
}

if(!isset($_SESSION['xdelete_user'])){
	echo '<form action="" method="post">
		Enter password <br/>
		<input type="text" name="pass" />
		<input type="submit" value="Ok!" />
	</form>';
	exit();
}

if(isset($_GET['dir'])){
	$path = $_GET['dir'];
}else{
	$path = dirname(__FILE__);
}

$script_name = basename(__FILE__);

$deleted_files = array();
$deleted_dirs = array();
$message = array();
$errors = array();
$free_space = diskfreespace(dirname($_SERVER['DOCUMENT_ROOT']));

if(isset($_POST['submit'])){
	if(!empty($_POST['files'])){
		foreach($_POST['files'] as $file){
			$res = @unlink($file);
			if($res==FALSE){
				$deleted_files[] = $file;
			}
		}
	}
	if(!empty($_POST['dirs'])){
		foreach($_POST['dirs'] as $dir){
			$res = clear_dir($dir);
			if($res==FALSE){
				$deleted_dirs[] = $dir;
			}
		}
	}
	if(empty($deleted_files) && empty($deleted_dirs)){
		$message[] = 'Файлы удалены!';
	}
}

if(isset($_POST['archiv'])){
	$cmd_part = 'tar -czvf '.$path.'/backup_'.date('Y.m.d').'.tar.gz';
	$path_to_script = dirname(__FILE__);
	if(!empty($_POST['files'])){
		foreach($_POST['files'] as $file){
			$cmd_part .= ' '.str_replace($path_to_script.'/','',$file);
		}
	}
	if(!empty($_POST['dirs'])){
		foreach($_POST['dirs'] as $dir){
			$cmd_part .= ' '.str_replace($path_to_script.'/','',$dir);			
		}
	}
	exec($cmd_part,$out,$ret);
	if($ret == 0){
		$message[] = 'Архив создан успешно!';
	}else{
		$errors[] = 'При архивации возникли ошибки :(';
	}
}



if(isset($_POST['unarchiv'])){
	if(!empty($_POST['files'])){
		foreach($_POST['files'] as $file){
			if(strrchr($file,'.')=='.gz'){
				$query = 'tar -xvf';
				$query .= ' '.$file;
				$query .= ' -C '.$path;
				exec($query,$out,$ret);
				if($ret == 0){
					$message[] = 'Архив разпакован успешно!';
				}else{
					$errors[] = 'Не удалось разпаковать архив :(';
				}
			}elseif(strrchr($file,'.')=='.zip'){
				$query = 'unzip '.$file.' -d '.$path;
				exec($query,$out,$ret);
				if($ret == 0){
					$message[] = 'Архив разпакован успешно!';
				}else{
					$errors[] = 'Не удалось разпаковать архив :(';
				}
			}
		}
	}
}

if(isset($_GET['download'])){
	header('Accept-Ranges: bytes');
	header('Content-Length: '.filesize($_GET['file']));
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$_GET['name'].'"');
	readfile($_GET['file']);
	exit();
}

if(isset($_POST['upload']) && !empty($_FILES['upload_file']['tmp_name'])){
	$upl = upload_file($path,$_FILES['upload_file']['tmp_name'],$_FILES['upload_file']['name'],10000);
	if($upl){
		$message[] = 'Файл закачан!';
	}else{
		$errors[] = 'Файл не закачан :(';
	}	
}

if(isset($_POST['find'])){
	$find_files = find_file($path,$_POST['find_name']);
}

$dir_files = @scandir($path);

$dirs = array(); 
$files = array();
if(!empty($dir_files)){
	foreach($dir_files as $item){
		if($item != '.' && $item != '..'){
			if(is_dir($path.'/'.$item)){
				$dirs[] = $item;
			}elseif(is_file($path.'/'.$item)){
				$files[] = $item;
			}
		}
	}
}

$path_up = substr($path,0,strrpos($path,'/'));

function clear_dir($path){
	$dir_files = scandir($path);
	if(!empty($dir_files)){
		foreach($dir_files as $item){
			if($item != '.' && $item != '..'){
				if(is_file($path.'/'.$item)){
					@unlink($path.'/'.$item);
				}elseif(is_dir($path.'/'.$item)){
					clear_dir($path.'/'.$item);
					@rmdir($path.'/'.$item);
				}
			}
		}
	}
	$res = @rmdir($path);
	return $res;
}

function find_file($path,$find_string,$find_files=array()){
	$dir_files = scandir($path); 
	if(!empty($dir_files)){
		foreach($dir_files as $item){
			if($item != '.' && $item != '..'){
				if(is_file($path.'/'.$item)){
					if($item == $find_string){
						$find_files[] = $path.'/'.$item;
					}
				}elseif(is_dir($path.'/'.$item)){
					if($item == $find_string){
						$find_files[] = $path.'/'.$item;
					}
					$find_files = find_file($path.'/'.$item,$find_string,$find_files);
				}
			}
		}
	}
	return $find_files;
}

function upload_file($path,$tmp_name,$filename,$part_size){
	$filesize = filesize($tmp_name);
	$count = (int)$filesize/$part_size;
	if((float)($filesize/$part_size) - $count != 0) $count++;
	
	for($i=0; $i<$count; ++$i){

		$f = fopen($tmp_name,'r');
		fseek($f,$i*$part_size);
		$part = fread($f,$part_size);
		fclose($f);
		
		$fp = fopen($path."/".$filename,"a");
		fwrite($fp,$part);
		fclose($fp);
	}
	
	
	if($filesize == filesize($path."/".$filename)){
		return TRUE;
	}
	return FALSE;
}

function dir_size($path){
	$size = 0;
	$dir_files = scandir($path);
	if(!empty($dir_files)){
		foreach($dir_files as $item){
			if($item != '.' && $item != '..'){
				if(is_file($path.'/'.$item)){
					$size += filesize($path.'/'.$item);
				}elseif(is_dir($path.'/'.$item)){
					$size += dir_size($path.'/'.$item);
				}
			}
		}
		return $size;
	}
	return 0;
}

function write_file($path,$text){
	$file = fopen($path,'w');
	fwrite($file,stripslashes($text));
	fclose($file);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>xDELETE script by LAZER</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="language" content="en" />
	<meta http-equiv="imagetoolbar" content="no" />
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
		#content { background:#eaf3fa; width:1000px; padding:20px; margin:75px auto 0; -moz-border-radius: 10px; -webkit-border-radius: 10px; -khtml-border-radius: 10px; border-radius: 10px;}
		#content p { margin:0; padding: 0 0 10px; }
		#content p.buttons { margin:20px 0 0; width:435px; } 
		#content .errors { color:#d00; font-weight:bold; padding:0 0 10px; }
		#content .messages { color:#0d0; font-weight:bold; padding:0 0 10px; }
		#footer {border-top:5px solid #464646; margin:75px auto 0; padding:20px; text-align:center; font-size:14px;}
	</style>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
		function del(){
			if(confirm('Вы уверены?')){
				return true;
			}else{
				return false;
			}
		}
		
		function check_all(){
			$('input[type=checkbox]').attr('checked','checked');
		}
		
		window_width = $(window).width()-50;
		window_height = $(window).height();
	</script>
</head>
<body>
	<div id="header">
		<?php
			if(isset($_POST['edit'])){
				write_file($_POST['path_file'],$_POST['edit_area']); ?>
				<script type="text/javascript">window.close();</script>
		<?php }
		?>
	</div>
	<div id="content">
		<?php 
			if(!empty($message)){
				foreach($message as $mess){
					echo "<p class='messages'>$mess</p>";
				}
			}
			if(!empty($errors)){
				foreach($errors as $error){
					echo "<p class='errors'>$error</p>";
				}
			}
		?>
		<form action="" method="post" enctype="multipart/form-data">
			<fieldset>
			<?php if(isset($_GET['edit'])){ ?>
				<textarea style="width:980px;height:700px;" name="edit_area"><?php readfile($_GET['file']); ?></textarea>
				<input type="hidden" name="path_file" value="<?=$_GET['file']?>" />
				<input type="submit" name="edit" onclick="if(!del())return false;" value="Обновить" />
				<input type="button" onclick="window.close();" value="Закрыть окно" />
			<?php }else{ ?>
                <div>Свободного пространства на диске: <?php echo round(($free_space/1024/1024),2); ?> Мб</div> 
				<div>Текущая директория: <?=$path?></div>
				<?php if($time == FALSE){ echo 'Ваш сервер ограничил время выполнения скрипта.. Если Вы будите архивировать большие файлы или разпаковувать то времени может не хватить.'; } ?>
				<?php if(isset($_POST['submit'])){
					if(!empty($deleted_dirs)){
						echo '<p style="padding:0;"><b>Ошибки при удалении папок:</b></p>';
						foreach($deleted_dirs as $del_dir){
							echo "<p style='padding:0;color:blue;'>".str_replace($path.'/','',$del_dir)."</p>";
						}
					}
					
					if(!empty($deleted_files)){
						echo '<p style="padding:0;"><b>Ошибки при удалении файлов:</b></p>';
						foreach($deleted_files as $del_file){
							echo "<p style='padding:0;color:blue;'>".str_replace($path.'/','',$del_file)."</p>";
						}
					}
								
				} ?>
				<?php
				if(!empty($path_up)){
					echo '<a href="?dir='.$path_up.'">На уровень выше</a> | '; 
				} ?>
				<a href="?defoult=yes">В исходную папку</a> 
				<ol>
				<?php $total_size = 0; $total_size_dirs = 0; $tatal_size_files = 0; ?>
				<?php if(!empty($dirs)){
						foreach($dirs as $dir){
							$size_dir = round((@dir_size($path.'/'.$dir)/1024/1024),2);
							$total_size_dirs += $size_dir;
							echo '<li><input type="checkbox" name="dirs[]" value="'.$path.'/'.$dir.'" /> <a href="?dir='.$path.'/'.$dir.'"><b>'.$dir.'</b></a> '.$size_dir.' Mб</li>';
						}
					}
					if(!empty($files)){
						foreach($files as $file){
							$file_size = round(filesize($path.'/'.$file)/1024,2);	
							$tatal_size_files += $file_size;
							if($file_size > 1024){
								$file_size = round($file_size / 1024,2).' Мб';
							}else{
								$file_size = $file_size.' Кб';
							}
							if($file == $script_name){
								echo '<li><input type="checkbox" name="files[]" value="'.$path.'/'.$file.'" /> <b style="color:green;">'.$file.'</b></li>';
							}else{ ?>
								<?php $file_path = $path.'/'.$file; ?>
								<li><input type="checkbox" name="files[]" value="<?=$path.'/'.$file?>" /> <a onclick="window.open('<?='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']?>?file=<?=$path.'/'.$file?>&edit=yes', 'popup', 'width='+window_width+',height='+window_height+',scrollbars')" href="javascript:void(0)"><?=$file?></a> | <b><?=$file_size?></b> <a href="<?='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']?>?download=yes&file=<?=$file_path?>&name=<?=basename($file_path)?>">Скачать</a></li>		
						<?php }
						}
					}
					if(empty($dirs) && empty($files)){
						echo '<li>Папка пуста или к ней нет доступа!</li>';
					}else{
						$total_size = $total_size_dirs + round($tatal_size_files/1024,2);
						echo "<li style='list-style:none;color:green;'><b>Общий размер файлов в папке ".$total_size." Мб</b></li>";
					} ?>
				</ol>
				<input type="submit" name="submit" onclick="if(!del())return false;" value="Удалить" />
				<input type="submit" name="archiv" onclick="if(!del())return false;" value="Создать архив!" />
				<input type="submit" name="unarchiv" onclick="if(!del())return false;" value="Разпаковать" />
				<input type="button" onclick="check_all();" value="Выделить все!" />
				<input type="reset" value="Сбросить" />
				<div>
					<label style="display:block;">Поиск файлов или папок</label>
					<input type="text" name="find_name" /> <input type="submit" name="find" value="Найти!" />
					<label style="display:block;">Загрузить файл в текущую папку</label>
					<input type="file" name="upload_file" /> <input type="submit" name="upload" value="Загрузить!" />
				</div>
				<?php if(isset($_POST['find'])){ ?>
					<?php if(!empty($find_files)){ ?>
						<b>Результат поиска:</b>
						<ol>
							<?php foreach($find_files as $find){ 
								$find_path = str_replace($path.'/','',$find);
								if(is_file($find)){
									$size = round(filesize($find)/1024,2);
								}else{
									$size = round((dir_size($find)/1024),2);
								}
									
								if($size > 1024){
									$size = round($size / 1024,2).' Мб';
								}else{
									$size = $size.' Кб';
								}
								if(is_file($find)){ ?>
									<li><input type="checkbox" name="files[]" value="<?=$find?>" /> <a onclick="window.open('<?='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']?>?file=<?=$find?>&edit=yes', 'popup', 'width='+window_width+',height='+window_height+',scrollbars')" href="javascript:void(0)"><?=$find_path?></a> | <b><?=$size?></b> <a href="<?='http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']?>?download=yes&file=<?=$find?>&name=<?=basename($find)?>">Скачать</a></li>
								<?php }else{ 
									echo '<li><input type="checkbox" name="dirs[]" value="'.$find.'" /> <a href="?dir='.$find.'"><b>'.$find_path.'</b></a> '.$size.'</li>';
								} ?>
							<?php } ?>
						</ol>
					<?php }else{
						echo '<b class="errors">Нечего не найдено.</b>';
					} ?>
				<?php } ?>
			<?php } ?>
			</fieldset>
		</form>
	</div>
	<div id="footer">	
		Copyright &copy;<?php echo date('Y'); ?> Powered by <a href="http://vkontakte.ru/xlazerx" target="_blank"><b>LAZER</b></a>. All rights reserved.
	</div>
</body>
</html>
