CREATE TABLE IF NOT EXISTS `orders` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`product_id` int(10) NOT NULL,
`recipient_first_name` varchar(100) NOT NULL,
`recipient_last_name` varchar(140) NOT NULL,
`recipient_address` varchar(300) NOT NULL,
`quantity` integer NOT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY (`product_id`) REFERENCES products (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;