<?php
/**
 * Class TagController
 * описує всі дії користувача 
 */
class TagController extends Controller{

	function __construct()
	{
		$this->model = new TagModel();
		$this->view = new View();
	}
	// Додає теги у базу даних
	function add_tag($tag)
	{
		$ret=$this->model-> model_add_tag($tag);
		return $ret;
	}
	// Додає звязки між тегами та постами у базу даних
	function add_tag_post_connect($tag)
	{
		$ret=$this->model-> model_add_tag_post_connect($tag);
		return $ret;
	}
	/*
	function edit_tag_post_connect($tag)
	{
		$ret=$this->model-> model_edit_tag_post_connect($tag);
		return $ret;
	}
	*/
	// Видаляє звязки між тегами та постами з бази даних коли видаляється пост з бази даних; параметром є $id - який відповідає $id посту  
	function delete_tag_post_connect($id)
	{
		$ret= $this->model-> model_delete_tag_post_connect($id);
		return $ret;
	}
	//Показує всі теги які звязані з постом $id
	function show_tag($id)
	{
		$ret=$this->model-> model_show_tag($id);
		return $ret;
	}
}
?>
