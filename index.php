<?php
session_start();
	require_once 'Model.php';
	require_once 'View.php';
	require_once 'Controller.php';
	//require_once 'models/guestbook_model.php';
	//require_once 'controllers/guestbook_controller.php';
	//require_once 'models/user_model.php';
	//require_once 'controllers/user_controller.php';
	
	require_once "config/config.php";
	
	function __autoload($class_name) 
	{	
		$class_name=strtolower($class_name);
		$pos=strpos($class_name,"controller");
		if($pos!==false)
		{
			$class_file_name=substr($class_name, 0, $pos)."_".substr($class_name, $pos).".php";
			$class_path=substr($class_name, $pos)."s/";
		}
		else
		{
			$pos=strpos($class_name,"model");
			$class_file_name=substr($class_name, 0, $pos)."_".substr($class_name, $pos).".php";
			$class_path=substr($class_name, $pos)."s/";
		} 
    	 require_once($class_path.$class_file_name); 
	}
	
	//��� � ����� ���������� �� ����������� GuestbookModel
	$controller_name = 'guestbook';
	$action = 'lists';
	$pagenum=1;
	$url = explode('/', $_SERVER['REQUEST_URI']);
		//�������� ��� ����������
		if ( !empty($url[1]) )
		{
			$controller_name = $url[1];
		}
		// �������� ��� ������
		if ( !empty($url[2]) )
		{
			$action= $url[2];
		}
		$controller_name=ucfirst($controller_name);
		$controller_name.="Controller";
		$controller = new $controller_name();
		//echo $controller_name."<br>";
		//echo $action;
		
		// �������� �������� ��� ������
		if ( !empty($url[3]) )
		{
			if( $url[3]==="page" && !empty($url[4]) )
			{
				//��������� ����� lists � ���������� $pagenum
				$pagenum=$url[4];
				$controller->$action($pagenum);
			}
			else
			{	
				$value=$url[3];
				if(method_exists($controller, $action))
				{
					// ��������� ����� ����������� � ����������
					$controller->$action($value);
				}
			}
			
		}
		else{
			if( method_exists($controller, $action) )
			{
				// ��������� ����� �����������
				if($action==="lists")
				{
					$controller->$action($pagenum);
				}
				else
				{
					$controller->$action();
				}
			}
			else 
			{
				$controller->not_exist();
			}
		}
		unset($controller);		
?>

