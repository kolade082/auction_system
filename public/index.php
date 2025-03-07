<?php session_start(); 
require_once 'as1csy2028.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>HOME - Fotheby's</title>
	<link rel="stylesheet" href="ibuy.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
	<?php

	require "layouts/header.php";
	require "layouts/nav.php";

// Fetch Live Auctions with formatted dates
$stmt = $pdo->prepare("SELECT auction_id, title, auction_description, image, startDate, endDate, c.category_name FROM auction a JOIN category c ON a.category_id = c.category_id WHERE a.startDate <= NOW() AND a.endDate >= NOW() ORDER BY a.startDate");
$stmt->execute();
$liveAuctions = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($liveAuctions as $key => $auction) {
    $startDate = new DateTime($auction['startDate']);
    $endDate = new DateTime($auction['endDate']);
    $liveAuctions[$key]['formattedStartDate'] = $startDate->format('jS M, Y');
    $liveAuctions[$key]['formattedEndDate'] = $endDate->format('jS M, Y');
}
// Fetch Upcoming Auctions with formatted dates
$stmt = $pdo->prepare("SELECT a.auction_id, a.title, a.auction_description, a.image, a.startDate, a.endDate, c.category_name FROM auction a JOIN category c ON a.category_id = c.category_id WHERE a.startDate > NOW() ORDER BY a.startDate");
$stmt->execute();
$upcomingAuctions = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($upcomingAuctions as $key => $auction) {
    $startDate = new DateTime($auction['startDate']);
    $endDate = new DateTime($auction['endDate']);
    $upcomingAuctions[$key]['formattedStartDate'] = $startDate->format('jS M, Y');
    $upcomingAuctions[$key]['formattedEndDate'] = $endDate->format('jS M, Y');
}


?>
	
	<main>
	<h2 class="section-heading">Fotheby's Live</h2>
	<section id="fothebys-live" class="auction-list">
        
        <?php foreach ($liveAuctions as $auction): ?>
            <div class="auction-item">
                <img src="images/auctions/<?php echo htmlspecialchars($auction['image']); ?>" alt="<?php echo htmlspecialchars($auction['title']); ?>">
                <h3><?php echo htmlspecialchars($auction['title']); ?></h3>
				<p class="category">Category: <?php echo htmlspecialchars($auction['category_name']); ?></p>
				<p class="date">Start: <?php echo $auction['formattedStartDate']; ?></p>
            <p class="date">End: <?php echo $auction['formattedEndDate']; ?></p>
			<p><?php echo htmlspecialchars($auction['auction_description']); ?></p>
            <a href="lots.php?auction_id=<?php echo htmlspecialchars($auction['auction_id']); ?>" class="view-lot-link">View Lot</a>
            </div>
        <?php endforeach; ?>
    </section>

    <!-- Upcoming Auctions Section -->
	<h2 class="section-heading">Upcoming Auctions</h2>
    <section id="upcoming-auctions" class="auction-list">
        
        <?php foreach ($upcomingAuctions as $auction): ?>
            <div class="auction-item">
                <img src="images/auctions/<?php echo htmlspecialchars($auction['image']); ?>" alt="<?php echo htmlspecialchars($auction['title']); ?>">
                <h3><?php echo htmlspecialchars($auction['title']); ?></h3>
				<p class="category">Category: <?php echo htmlspecialchars($auction['category_name']); ?></p>
				<p class="date">Start: <?php echo $auction['formattedStartDate']; ?></p>
            <p class="date">End: <?php echo $auction['formattedEndDate']; ?></p>
			<p><?php echo htmlspecialchars($auction['auction_description']); ?></p>
            <!-- <a href="lots.php?auction_id=<?php echo htmlspecialchars($auction['auction_id']); ?>" class="view-lot-link">View Lot</a> -->
            </div>
        <?php endforeach; ?>
    </section>
		<!-- Latest News Section -->
		<section id="latest-news">
			<div class="latest-news-container">
				<h2 class="section-heading">Fotheby’s Selects</h2>
				<div class="news-items">
					<div class="news-item large">
						<img src="banners/2.jpg" alt="American Art from Warhol to Ligon">
						<h3>Fotheby's Magazine</h3>
						<p>Blake Gopnik Charts American Art from Warhol to Ligon</p>
					</div>
					<div class="news-item-stack">
						<div class="news-item small">
							<img src="banners/1.jpg" alt="Elmgreen & Dragset's Visual History of Literature">
							<h3>Auctions and Exhibitions</h3>
							<p>Elmgreen & Dragset’s Visual History of Literature</p>
						</div>
						<div class="news-item small">
							<img src="banners/3.jpg" alt="Young Barbican Welcomes a New Generation of Creatives">
							<h3>Philanthropy</h3>
							<p>Young Barbican Welcomes a New Generation of Creatives</p>
						</div>
					</div>
				</div>
				<a href="link-to-view-all-news" class="view-all-news">View All</a>
			</div>
		</section>





		<!-- Contact Section -->
		<section id="contact">
			<div class="container">
				<h2>Stay informed with Fotheby’s</h2>
				<p>Receive the best from Fotheby’s delivered to your inbox.</p>
				<form action="#" method="post" class="subscription-form">
					<div class="form-row top-row">

						<input type="text" name="first_name" placeholder="First Name">
						<input type="text" name="last_name" placeholder="Last Name">
					</div>
					<div class="form-row bottom-row">

						<input type="email" name="email" placeholder="Email Address" required>
					</div>
					<p class="privacy-policy">By subscribing you are agreeing to Fotheby’s <a href="privacy-policy-url">Privacy Policy</a>. You can unsubscribe from Fotheby’s emails at any time by clicking the “Manage your Subscriptions” link in any of your emails.</p>
					<button type="submit" class="submit-btn">Submit</button>
				</form>
			</div>
		</section>






		<?php require "layouts/footer.php"; ?>
	</main>
	<script>
		const images = ["banners/1.jpg", "banners/2.jpg", "banners/1.jpg"]; // Add your image paths
		let currentImage = 0;

		function showImage(index) {
			currentImage += index;
			if (currentImage >= images.length) currentImage = 0;
			if (currentImage < 0) currentImage = images.length - 1;
			document.querySelector('.banner-slide').src = images[currentImage];
		}

		function changeImage(index) {
			showImage(index);
			resetInterval();
		}

		let imageInterval = setInterval(function() {
			showImage(1);
		}, 1000);

		function resetInterval() {
			clearInterval(imageInterval);
			imageInterval = setInterval(function() {
				showImage(1);
			}, 1000);
		}
	</script>
	<script>
		function moveCarousel(step) {
			var container = document.querySelector('.productList');
			var scrollAmount = container.clientWidth * step / 3; 
			container.scrollBy({
				left: scrollAmount,
				top: 0,
				behavior: 'smooth'
			});
		}
	</script>

</body>

</html>
