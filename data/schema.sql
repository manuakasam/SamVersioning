CREATE TABLE IF NOT EXISTS `sam_versioned_objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `object_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_serialized` longtext COLLATE utf8_unicode_ci NOT NULL,
  `object_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `search_idx` (`object_name`,`object_id`,`object_date`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;