<?php
/**
 * Class TagModel
 * обробляє всі дії користувача 
 */
class TagModel extends Model{
	// Додає теги у базу даних
	public function model_add_tag($tags)
	{
		foreach ($tags as $value)
			{	
				$sql="select `tag` from `tags` where `tag`='$value';";
				$query=mysql_query($sql);
				if(!$query){return "Помилка при підключенні до БД";}
				else{ $error="Ok";}
				$flag=mysql_fetch_assoc($query);
				if ($flag==false)
				{
					$sql="insert into tags (`tag`) values ('$value');";
					$query=mysql_query($sql);
					if (!$query) $error="При добавленні сталася помилка";
					else $error="Ok";
				}
				
			}
		return $error;
		
	}
	// Додає звязки між тегами та постами у базу даних
	public function model_add_tag_post_connect($tags){
			foreach ($tags as $value)
			{
				$sql="select `id` from `tags` where `tag`='$value';";
				$query=mysql_query($sql);
				$data=mysql_fetch_assoc($query);
				$sql2="select `id` from `guestbook` where `name`='$_POST[name]' and `short_text`='$_POST[short_text]' and `long_text`='$_POST[long_text]';";
				$query2=mysql_query($sql2);
				$data2=mysql_fetch_assoc($query2);
				$value1=$data2['id'];
				$value2=$data['id'];
		
				$sql3="insert into `post_tags` (`id_post`,`id_tag`) values ('$value1','$value2');";
				$query3=mysql_query($sql3);
				
				if (!$query3)  $error="При добавленні сталася помилка";
				else $error="Ok";	
			}
		return $error;
	
	}
	/*
	public function model_edit_tag_post_connect($tags){
			foreach ($tags as $value)
			{
				
				
			}
		return $error;
	
	}
	*/
	// Видаляє звязки між тегами та постами з бази даних коли видаляється пост з бази даних; параметром є $id - який відповідає $id посту  
	public function model_delete_tag_post_connect($id){
		$sql="DELETE FROM `post_tags` WHERE `id_post`=".$id.";";
		$query=mysql_query($sql);
		if (!$query)  $error="При добавленні сталася помилка";
		else  $error="Ok";
		return $error;
	}
	//Показує всі теги які звязані з постом $id
	public function model_show_tag($id){
		
		$sql=" SELECT `tags`.`tag` FROM `tags` INNER JOIN `post_tags` ON `tags`.`id` = `post_tags`.`id_tag` INNER JOIN `guestbook` ON `guestbook`.`id` = `post_tags`.`id_post`   WHERE `guestbook`.`id` = '$id';";
		$query = mysql_query($sql);
		if (!$query) return "неможливо вибрати дані з таблиці!";
		while ($data=mysql_fetch_assoc($query))
		{
			$ret.=$data['tag'].",";
		}
		return $ret;
	}
	
}
?>
