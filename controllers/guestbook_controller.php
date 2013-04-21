<?php
/**
 * Class GuestbookController
 * описує всі дії користувача 
 */
class GuestbookController extends Controller{

	function __construct()
	{
		$this->model = new GuestbookModel();
		$this->view = new View();
	}
	/**
	* метод add(),який генерує форму для введення даних
	*  
	*/
	function add()
	{	
		$this->view->generate('form.tpl', 'main.tpl');
	}
	/**
	* метод insert(),який вставляє введені дані з форми у базу даних
	*  
	*/
	function insert()
	{
		$data=$this->model->model_insert();
		$this->view->generate('view.tpl', 'main.tpl',$data);	
	}
	/**
	* метод edit(),вибирає дані з бази даних,записує їх у форму;
	* якщо $id=insert записує редаговані дані в базу даних;
	* і повертає повідомлення про результат видалення;
	*/
	function edit($id)
	{	
		if($id==="insert"){
		$data=$this->model->model_edit();
		$this->view->generate('view.tpl', 'main.tpl',$data);
		}
		else
		{
		$data=$this->model->model_view($id);
		$this->view->generate('form.tpl', 'main.tpl',$data);
		
		}
	}
	/**
	* видаляє дані з бази даних,і повертає повідомлення про результат видалення;
	*/
	function delete($id)
	{
		$data=$this->model->model_delete($id);
		$this->view->generate('view.tpl', 'main.tpl',$data);
	}
	/**
	* показує один пост 
	*/
	function view($id)
	{
		$data=$this->model->model_view($id);
		$this->view->generate('view.tpl', 'main.tpl', $data);
	}
	/**
	* показує пости на сторінці  pagenum
	*/
	function lists($pagenum)
	{
		$data=$this->model->model_lists($pagenum);
		$this->view->generate('lists.tpl', 'main.tpl', $data);
	}
	/**
	* показує повідомлення про те, що такої сторінки не існує
	*/
	function not_exist()
	{
		$this->view->generate('view.tpl', 'main.tpl', "Такої сторінки не знайдено");
	}
	function __destruct()
	{
		unset($this->model);
		unset($this->view);
	}
}
?>

