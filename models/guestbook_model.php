<?php
/**
 * Class GuestbookModel
 * обробляє всі дії користувача 
 */
class GuestbookModel extends Model{
	private $error="";
	
	function __construct()
	{
		$this->tag = new TagController();
	}
	/**
	* метод update(),оновлює час останнього звернення до сторінок ГК;
	* і робить незначну валідацію
	*/
	private function update()
	{	$times=date("YmdHis",time());
		$id = $_SESSION['user']['id'];
		$sql="UPDATE `users` SET `last_time`='$times' WHERE `id`='$id';";
		$query=mysql_query($sql);
		if(!$query) return $error="Помилка при підключенні до бази даних!!!";
	}
	
	/*
	Метод, який здійснює пошук по всіх постах за назвою, текстом і датою !!!
	*/
	public function model_search(){
		$this->update();
		$_POST['search']=htmlspecialchars($_POST['search']);
		if(empty($_POST['search']))return "Ви нічого не ввели!!!";
		$search = $_POST['search'];
		if ( !preg_match("/^[A-Za-z0-9_\-\s\.,:]+$/", $_POST['search']) ) 
		{
			return $error.="Ви ввели не допустимі символи!!!";
		}
		$sql="SELECT * FROM `guestbook` WHERE `create_time` LIKE '%$search%' OR MATCH `name` AGAINST('$search') OR MATCH `short_text` AGAINST('$search') ;";
		$query = mysql_query($sql);
		if (!$query) return "неможливо вибрати дані з таблиці!";	
	    while($data=mysql_fetch_assoc($query))
	    {
			 $login=$data['id_user'];
			 $sql2="SELECT `email`,`last_time` FROM `users` WHERE `id`='$login';";	
			 $query2 = mysql_query($sql2);
			 if (!$query2) return "неможливо вибрати дані з таблиці!";
			 $dat=mysql_fetch_assoc($query2);
			 $data['email']=$dat['email'];
			 $data['last_time']=$dat['last_time'];
			 
			 $data['tags']=$this->tag->show_tag($data['id']);
			 
			 $datas[]=$data;
		}
	return $datas;
	
	}
	
	/**
	* метод insert(),який вставляє введені дані з форми у базу даних;
	* і робить незначну валідацію
	*/
	public function model_insert(){
		$this->update();
		$flag=false;
		$times=date("YmdHis",time());	
		$_POST['name']=htmlspecialchars($_POST['name']);
		
		$_POST['short_text']=htmlspecialchars($_POST['short_text']);
		
		$_POST['long_text']=htmlspecialchars($_POST['long_text']);
		
		$_POST['tags']=htmlspecialchars($_POST['tags']);
		if( empty($_POST['name']) or empty($_POST['short_text'])  or empty($_POST['long_text']) or empty($_POST['tags'])) 
		{	
			$error.="Ви не заповнили всі поля!<br>";
			$flag=true;
		}
		
		if(!$flag)
		{	
			if ( !preg_match("/^[A-Za-z0-9_\-\s\.,]+$/", $_POST['name']) or !preg_match("/^[A-Za-z0-9_\-\s\.,]+$/", $_POST['short_text']) or !preg_match("/^[A-Za-z0-9_\-\s\.,]+$/", $_POST['long_text'])  or !preg_match("/^[A-Za-z0-9_\-\s\.,]+$/", $_POST['tags'])) 
			{
				return $error.="Ви ввели не допустимі символи!!!";
			}
			$login=$_SESSION['user']['login'];
			$sql="SELECT `id` FROM `users` WHERE email='$login';";
			$query = mysql_query($sql);
			$data=mysql_fetch_assoc($query);
			$sql="insert into `guestbook` (`name`,`short_text`,`long_text`,`create_time`,`id_user`) values ('$_POST[name]','$_POST[short_text]','$_POST[long_text]','$times','$data[id]')";
			$query=mysql_query($sql);
			
			$tags=explode(',', $_POST['tags']);
			
			$ret=$this->tag->add_tag($tags);
			$ret2=$this->tag->add_tag_post_connect($tags);
			
			
			if($query and $ret=="Ok" and $ret2=="Ok") 
			{	
				$error.="Запис додано успішно";
			}
			else
			{
				$error.="Помилка в підключенні до бази даних!";
			}
		}
		return $error; 
		
	}
	/**
	* видаляє дані з бази даних;
	*/
	public function model_delete($id){
		$this->update();
		if ( !preg_match("/^[0-9]+$/", $id) ) 
			return $error="Ви не пройшли валідацію!!!";
		
		if( isset( $_POST['submit'] ) ){
			$sql="DELETE FROM `guestbook` WHERE id=".$id.";";
			
			$ret=$this->tag->delete_tag_post_connect($id);
			
			if(mysql_query($sql) and $ret="Ok") 
			{
			return $error="Дані успішно видалені";
			}
			else
			{
				return $error="Не можливо видалити данi";
			}
		}
	
	}
    /**
	* метод edit(),вибирає дані з бази даних,записує їх у форму;
	* і робить незначну валідацію
	*/        
	public function model_edit(){
		$this->update();
		$times=date("YmdHis",time());
		$error="";
		$_POST['name']=htmlspecialchars($_POST['name']);
		
		$_POST['short_text']=htmlspecialchars($_POST['short_text']);
		
		$_POST['long_text']=htmlspecialchars($_POST['long_text']);              	
			if( empty($_POST['name']) or empty($_POST['short_text'])  or empty($_POST['long_text'])  or empty($_POST['tags'])) 
		{	
			$error.="Ви не заповнили всі поля!<br>";
			$flag=true;
		}
			
			if(!$flag){
				if ( !preg_match("/^[A-Za-z0-9_\-\s\.,]+$/", $_POST['name']) or !preg_match("/^[A-Za-z0-9_\-\s\.,]+$/", $_POST['short_text']) or !preg_match("/^[A-Za-z0-9_\-\s\.,]+$/", $_POST['long_text'])  or !preg_match("/^[A-Za-z0-9_\-\s\.,]+$/", $_POST['tags']) ) 
				{
					return $error.="Ви ввели не допустимі символи!!!";
				}
				$sql="UPDATE `guestbook` SET `name`='{$_POST['name']}', `short_text`='{$_POST['short_text']}',
										 `long_text`='{$_POST['long_text']}',`edit_time`='$times' WHERE id='{$_POST['id']}';";
				$add=mysql_query($sql);
				
				$tags=explode(',', $_POST['tags']);
			
				$ret=$this->tag->add_tag($tags);
				//$ret2=$this->tag->edit_tag_post_connect($tags);
				
				if($add and $ret=="Ok")
				{
					$error.="дані редаговано";
				}
				else
				{
					$error.="При добавленні повідомлення сталася помилка! ";
				}
			}
		return $error;		
	}
	/**
	* Вибирає дані з бази даних відповідно до $id і показує їх
	*/
	public function model_view($id){
		$this->update();
		if ( !preg_match("/^[0-9]+$/", $id) ) 
			return $error="Ви не пройшли валідацію!!!";
		
		if( !empty( $_POST['submit'] ) ){
			$sql="SELECT * FROM `guestbook` WHERE id=".$id.";";
			$query = mysql_query($sql);
		    if (!$query) return "неможливо вибрати дані з таблиці!";	
			$data=mysql_fetch_assoc($query);
			$login=$data['id_user'];
			$sql2="SELECT `email` FROM `users` WHERE `id`='$login';";	
			$query2 = mysql_query($sql2);
			if (!$query2) return "неможливо вибрати дані з таблиці!";
			$dat=mysql_fetch_assoc($query2);
			$data['email']=$dat['email'];
			
			$data['tags']=$this->tag->show_tag($data['id']);
			
			return $data;
		}
		else 
		{ 
			return "Неможливо показати сторінку";
		}
	}
	/**
	* Вибирає  дані з бази даних Відповідно до сторінки та кількості постів на одній сторінці
	*/
	public function model_lists($pagenum){
		$this->update();
		if ( !preg_match("/^[0-9]+$/", $pagenum) ) return "";
		
		$query = mysql_query("SELECT COUNT(`id`) AS `count` FROM `guestbook`");
		$row = mysql_fetch_assoc($query);
		$rows_max=$row['count'];		
		$show_posts=5;
		
		$_SESSION['post_count']=$rows_max;
		$_SESSION['pagenum']=$pagenum;
		$_SESSION['show_posts']=$show_posts;
		
		$offset=$show_posts * ($pagenum-1);
		
		$sql="SELECT * FROM `guestbook` ORDER BY 'create_time' DESC LIMIT $offset, $show_posts;";	
		$query = mysql_query($sql);
		if (!$query) return "неможливо вибрати дані з таблиці!";	
		while ($data=mysql_fetch_assoc($query))
		{	
			 $login=$data['id_user'];
			 $sql2="SELECT `email`,`last_time` FROM `users` WHERE `id`='$login';";	
			 $query2 = mysql_query($sql2);
			 if (!$query2) return "неможливо вибрати дані з таблиці!";
			 $dat=mysql_fetch_assoc($query2);
			 $data['email']=$dat['email'];
			 $data['last_time']=$dat['last_time'];
			 
			 $data['tags']=$this->tag->show_tag($data['id']);		 
			 $datas[]=$data;
		}
	 return $datas;
	}
	function __destruct()
	{
		mysql_close();
		
	}
}
?>
