<?php
mysql_query("CREATE TABLE  IF NOT EXISTS `guestbook`(
                      `id` INT NOT NULL AUTO_INCREMENT ,
                      `name` VARCHAR(100),
                      FULLTEXT (`name`),
                      
                     `short_text` TEXT NOT NULL,
                     FULLTEXT (`short_text`),
                     `long_text` TEXT NOT NULL,
                     `create_time` TIMESTAMP,
                     INDEX (`create_time`),
                     `edit_time` TIMESTAMP ,
                     
                     `id_user`INT NOT NULL,
                      PRIMARY KEY (id),
                      FOREIGN KEY (`id_user`) REFERENCES `users`(`id`)
                      )ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
?>