# Auction System

A web-based auction system built with PHP, MySQL, and Docker. This application allows users to view live and upcoming auctions, place bids, and manage auction listings.

## Prerequisites

- Docker
- Docker Compose
- Git (optional)

## Installation & Setup

1. Clone or download the repository:
```bash
git clone https://github.com/kolade082/auction_system.git
cd auction-system
```

2. Set up Docker environment:
   - Ensure you have the following files in your root directory:
     - `Dockerfile`
     - `docker-compose.yml`
     - `apache.conf`

3. Start the application:
```bash
docker-compose up --build
```

## Database Setup

The system uses MySQL with the following tables:

### Users Table
```sql
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `usertype` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
);
```

### Auction Table
```sql
CREATE TABLE `auction` (
  `auction_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `auction_description` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`auction_id`)
);
```

### Category Table
```sql
CREATE TABLE `category` (
  `category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
);
```

### Lots Table
```sql
CREATE TABLE `lots` (
  `lot_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lot_name` varchar(255) NOT NULL,
  `lot_description` text,
  `estimated_price` decimal(10,2) NOT NULL,
  `image` varchar(255),
  `auction_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`lot_id`),
  FOREIGN KEY (`auction_id`) REFERENCES `auction`(`auction_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
);
```

### Bids Table
```sql
CREATE TABLE `bids` (
  `bid_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `amount_bidded` int(11) DEFAULT NULL,
  `lot_id` int(11) unsigned NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`bid_id`),
  FOREIGN KEY (`lot_id`) REFERENCES `lots`(`lot_id`)
);
```
### Reviews Table
```sql
CREATE TABLE `reviews` (
  `review_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comments` text NOT NULL,
  `rating` int(1) DEFAULT NULL CHECK (rating >= 1 AND rating <= 5),
  `lot_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `review_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  FOREIGN KEY (`lot_id`) REFERENCES `lots`(`lot_id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) E
```

## Features
- User Authentication (Login/Register)
- Live Auctions Display
- Upcoming Auctions Display
- Lot Management System
- Bidding System
- Category Management

