<?php
mysql_query("CREATE TABLE IF NOT EXISTS `tags`(
     `id` INT NOT NULL AUTO_INCREMENT,
   `tag` VARCHAR(50),
  PRIMARY KEY(id)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
?>