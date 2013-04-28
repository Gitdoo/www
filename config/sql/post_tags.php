<?php
mysql_query("CREATE TABLE IF NOT EXISTS `post_tags`(
     `id` INT NOT NULL AUTO_INCREMENT,
	  `id_post`INT NOT NULL,
	  `id_tag` INT NOT NULL,
  PRIMARY KEY(id),
   FOREIGN KEY (`id_post`) REFERENCES `guestbook`(`id`),
    FOREIGN KEY (`id_tag`) REFERENCES `tag`(`id`)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
/*
SELECT tags.tag  
FROM tags 
INNER JOIN post_tags ON tags.id = post_tags.id_tag 
INNER JOIN guestbook ON guestbook.Id = post_tags.id_post   
WHERE guestbook.id = 2
*/
?>
