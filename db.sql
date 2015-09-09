

# Dump of table CMS_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CMS_users`;

CREATE TABLE `CMS_users` (
  `memberID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `CMS_users` WRITE;
/*!40000 ALTER TABLE `CMS_users` DISABLE KEYS */;

INSERT INTO `CMS_users` (`memberID`, `username`, `password`, `email`)
VALUES
  (1,'Demo','$2a$12$TF8u1maUr5kADc42g1FB0ONJDEtt24ue.UTIuP13gij5AHsg5f5s2','simon@simon.com');

/*!40000 ALTER TABLE `CMS_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `postID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `postTitle` varchar(255) DEFAULT NULL,
  `postDesc` text,
  `postCont` text,
  `postDate` datetime DEFAULT NULL,
  PRIMARY KEY (`postID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`postID`, `postTitle`, `postDesc`, `postCont`, `postDate`)
VALUES
  (1,'Title','Title on the front page','Welcome!','2015-09-09 00:00:00'),
  (2,'TitleDescription','Description on the first page','This was pulled from the database','2015-09-09 23:10:35'),
  (3,'Paragraph 1','The paragraph just under the first header on the page','This text was populated by the database that you can access through the admin page, this allowes new text to be added or current text to be altered','2015-09-09 00:00:00'),;

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
