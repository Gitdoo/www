<html>
<head>
	<title>Гостьова Книга</title>
	<meta charset="utf-8">
</head>
<body bgcolor=#dddddd>
	<div id="header" style="height:100px;">
	Гостьова Книга!!!
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!
    <br>
		<div id="search" style="float:right;top:50px;">
        <form action="/guestbook/search" method="post">
         
        <input type='text' name="search"><input type='submit' value="Пошук">
        <br>
        (Дата у форматі yyyy-mm-dd hh:mm:ss) 
        </form>
        </div>
		
	</div>

<div id="conteiner" style="float:left;padding:10px;margin:20px;width:95%;height:auto;">
    	<h1 align="center">Гостьова Книга</h1>
<?php 
echo $logform;
?>   	
<div id="content" style="float:left;width:80%;">
<a href="/" style="float:right;"><h4>Вернутися на головну</h4></a>
<h3>Записи </h3>
<?php 
echo $content;
?>   
</div>
</div>
<hr>
<div id="footer" id="height:100px; padding:10px;margin:20px;clear: left;">
	
	Гостьова Книга!!!
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!
</div>    
</body>
</html>


