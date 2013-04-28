<?php 
if(!empty($data)){
	if(is_array($data))
    {
	foreach($data as $temp)
	{
		$local=$temp['id'];
		if(time()-strtotime($temp['last_time'])>60) $status=$temp['last_time'];else $status="Online";
?>	
	
		<hr>
		<b><u>Назва:</u> </b> <?php echo $temp['name']; ?><br>
		<br><b><u>Короткий текст:</u> </b><?php echo $temp['short_text'];?><br>
		<br><b><u>Повний текст:</u></b><?php echo $temp['long_text']; ?><br>
		<br><b><u>Дата написання:</u></b><?php echo $temp['create_time'];?>
        <br><b><u>Теги:</u></b><?php echo $temp['tags'];?>
		<br><b><u>Запис додав:</u></b><?php echo $temp['email'];?>
		<b><u>Останній візит:</u></b><?php echo $status; ?>
		
		<?php
		 if($temp['edit_time']!="0000-00-00 00:00:00"){
		?>
		<div><br><b>Дата редагування:</b> <?php echo $temp['edit_time'];?> </div> 
		 <?php
		 }
		 if(!empty($_SESSION['user']['id'])&&$_SESSION['user']['id']===$temp['id_user'] )
		 {
		?>                                     
		<br><br><form action='/guestbook/edit/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Редагувати'></form>
		<form action='/guestbook/delete/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Видалити'></form>
		<form action='/guestbook/view/<?php echo $local;?>' method='post'><input type='submit' name='submit'value='Показати'></form>
		
<?php 
		}
	}
    
    }
    else
    {
    	echo $data;
    }
    
?>
		
<?php
	}
	else
	{
	echo "Нічого не знайдено за вашим запитом";
	}
?>

