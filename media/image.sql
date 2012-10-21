-- phpMyAdmin SQL Dump
-- version 3.3.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 27, 2011 at 01:30 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2
-- 
-- Database: `posterdb`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `images`
-- 

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `image_id` int(10) unsigned NOT NULL,
  `filename` varchar(25) NOT NULL,
  `caption` varchar(120) NOT NULL,
  PRIMARY KEY  (`image_id`)
) TYPE=MyISAM AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `images`
-- 

INSERT INTO `images` (`image_id`, `filename`, `caption`) VALUES (1, 'Django.jpg', 'Django Reinhardt'),
(2, 'Franklin.jpg', 'Benjamin Franklin'),
(3, 'Washington.jpg', 'George Washington'),
(4, 'tesla.jpg', 'Nikola Tesla'),
(5, 'Gates.jpg', 'Bill Gates'),
(6, 'obama.jpg', 'Barrack Obama'),
(7, 'Rasputin.jpg', 'Grigori Rasputin'),
(8, 'monty-python.jpg', 'Monty Python Graphic'),
(9, 'sharkmarlin.jpg', 'Sharkmarlin Painting'),
(10, 'suit.jpg', 'Me in a Suit');

