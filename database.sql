--
-- Current Database: `as1csy2028`
--
CREATE DATABASE
/*!32312 IF NOT EXISTS*/
`as1csy2028`
/*!40100 DEFAULT CHARACTER SET utf8mb4 */
;

USE `as1csy2028`;

--
-- Table structure for table `auction`
--
DROP TABLE IF EXISTS `auction`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!40101 SET character_set_client = utf8 */
;

CREATE TABLE `auction` (
  `auction_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `auction_description` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`auction_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 17 DEFAULT CHARSET = utf8mb4;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `auction`
--
LOCK TABLES `auction` WRITE;

/*!40000 ALTER TABLE `auction` DISABLE KEYS */
;

INSERT INTO
  `auction`
VALUES
  (
    1,
    'Vikings Helment',
    ' Helment worn by vikings in the 1900\'s',
    3,
    '2022-11-21 00:00:00',
    '5131569.jpg',
    1
  ),
(
    2,
    'Churchill\'s painting',
    ' Painting by churchill, inspired by his daughter who died by drowning',
    1,
    '2022-12-19 00:00:00',
    'churchill painting.jpg',
    3
  ),
(
    3,
    'Chevrolet  Vintage ',
    ' Vintage Chevrolet Car  ',
    2,
    '2023-01-04 00:00:00',
    'chevrolet vintage.jpg',
    3
  ),
(
    4,
    'Viking Sword',
    ' Sword used by vikings in the 1900\'s',
    3,
    '2022-12-19 00:00:00',
    '2665599.jpg',
    3
  ),
(
    5,
    'Viking Shield',
    ' Shield used by scandevians in the 1900\'s',
    3,
    '2022-12-20 00:00:00',
    'viking shield.webp',
    1
  ),
(
    6,
    'Vintage Bentley',
    ' This is a bentley which was owned by a duke but lost due to gambling',
    2,
    '2022-12-20 00:00:00',
    'vintage bentley.webp',
    9
  ),
(
    7,
    'Benz',
    ' A vintage mercedes used in the early 2000\'s  ',
    2,
    '2022-11-28 00:00:00',
    'vintage benz.jpg',
    9
  ),
(
    8,
    'Last Supper ',
    ' A painting by leonardo Da Vinci on the last supper which was commissioned by the duke of milan',
    1,
    '2022-12-10 00:00:00',
    'painting by da vinci.webp',
    9
  ),
(
    10,
    'Emotions',
    'Painting by Ralph Steadman about the human emotions',
    1,
    '2022-11-20 00:00:00',
    'painting by ralph.jpg',
    2
  ),
(
    16,
    'Dog and Priest',
    ' A painting of a priest with his dog by Alex Colville',
    1,
    '2022-12-14 00:00:00',
    'painting by alex colville.jpg',
    2
  );

/*!40000 ALTER TABLE `auction` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `bids`
--
DROP TABLE IF EXISTS `bids`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!40101 SET character_set_client = utf8 */
;

CREATE TABLE `bids` (
  `bid_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `amount_bidded` int(11) DEFAULT NULL,
  `auction_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`bid_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 24 DEFAULT CHARSET = utf8mb4;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `bids`
--
LOCK TABLES `bids` WRITE;

/*!40000 ALTER TABLE `bids` DISABLE KEYS */
;

INSERT INTO
  `bids`
VALUES
  (1, 100, 1, 1),
(2, 350, 2, 1),
(3, 15000, 3, 1),
(4, 200, 4, 1),
(5, 100, 5, 1),
(6, 20000, 6, 9),
(7, 10000, 7, 9),
(8, 30000, 8, 9),
(9, 25000, 2, 9),
(10, 5000, 9, 2),
(11, 4500, 10, 2),
(12, 50, 1, 2),
(13, 150, 1, 2),
(14, 2500, 13, 2),
(15, 2500, 14, 2),
(16, 2500, 16, 2),
(21, 10001, 7, 1),
(22, 250, 4, 1),
(23, 500, 4, 1);

/*!40000 ALTER TABLE `bids` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `category`
--
DROP TABLE IF EXISTS `category`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!40101 SET character_set_client = utf8 */
;

CREATE TABLE `category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `category`
--
LOCK TABLES `category` WRITE;

/*!40000 ALTER TABLE `category` DISABLE KEYS */
;

INSERT INTO
  `category`
VALUES
  (1, 'Paintings'),
(2, 'Cars'),
(3, 'Vikings Stuffs');

/*!40000 ALTER TABLE `category` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `reviews`
--
DROP TABLE IF EXISTS `reviews`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!40101 SET character_set_client = utf8 */
;

CREATE TABLE `reviews` (
  `review_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comments` varchar(255) DEFAULT NULL,
  `auction_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `review_date` datetime DEFAULT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `reviews`
--
LOCK TABLES `reviews` WRITE;

/*!40000 ALTER TABLE `reviews` DISABLE KEYS */
;

INSERT INTO
  `reviews`
VALUES
  (
    1,
    'It will be nice for my hallowen custome, i\'ll place a bid of £150 or more.',
    1,
    1,
    '2022-11-19 14:35:04'
  ),
(
    2,
    'Wow, I\'m definitely going for this\r\n',
    6,
    2,
    '2022-11-20 02:12:37'
  ),
(4, 'Niceeeeee', 7, 1, '2022-11-20 20:07:18');

/*!40000 ALTER TABLE `reviews` ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!40101 SET character_set_client = utf8 */
;

CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `usertype` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE = InnoDB AUTO_INCREMENT = 12 DEFAULT CHARSET = utf8mb4;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table `users`
--
LOCK TABLES `users` WRITE;

/*!40000 ALTER TABLE `users` DISABLE KEYS */
;

INSERT INTO
  `users`
VALUES
  (
    1,
    'kolade@ibuy.co.uk',
    '$2y$10$K8YOudM1VD6wTDR0UYm4juPdcj/A2/5Ks6bbXzXU4AumRLPw5OlL2',
    'Kolade',
    'ADMIN'
  ),
(
    2,
    'pia@ibuy.co.uk',
    '$2y$10$u/sfFBof6sXTO6iBYV2EhOmr9oPqP.VlQ0I89yG90H2wYzdIq61/O',
    'Pia',
    'ADMIN'
  ),
(
    3,
    'zel@ibuy.co.uk',
    '$2y$10$T9VvbTuRQdoh/O1oGzchoOUwO6ZG/j2n8nBfJe6YoPOsd4JYIwDAe',
    'Zel',
    'USER'
  ),
(
    9,
    'kora@ibuy.co.uk',
    '$2y$10$I1M23Cn6KPyVFRVQQi.ri.hx2E8jRzxegyBH2pc.UV7nE4rhfO1Ue',
    'Kora',
    'USER'
  );

/*!40000 ALTER TABLE `users` ENABLE KEYS */
;

UNLOCK TABLES;