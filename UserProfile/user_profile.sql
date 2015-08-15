--
-- Table structure for table `user_profile`
--

CREATE TABLE /*_*/user_profile (
  `up_user_id` int(5) NOT NULL PRIMARY KEY default '0',
  `up_relationship` int(5) NOT NULL default '0',
  `up_occupation` varchar(255) default '',
  `up_whoami` text,
  `up_custom_1` text,
  `up_custom_2` text,
  `up_custom_3` text,
  `up_custom_4` text,
  `up_custom_5` text,
  `up_character1` text,
  `up_character2` text,
  `up_character3` text,
  `up_character4` text,
  `up_character5` text,
  `up_seiyuu1` text,
  `up_seiyuu2` text,
  `up_seiyuu3` text,
  `up_seiyuu4` text,
  `up_seiyuu5` text,
  `up_series1` text,
  `up_series2` text,
  `up_series3` text,
  `up_series4` text,
  `up_series5` text,
  `up_last_seen` datetime default NULL,
  `up_type` int(5) NOT NULL default '1'
) /*$wgDBTableOptions*/;
