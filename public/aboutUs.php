<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ABOUT - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <?php require "layouts/header.php"; ?>
    <?php require "layouts/nav.php"; ?>

    <main class="about-section">
        <div class="container">
            <h1 class="about-title">About Fotheby's Auctions</h1>

            <section class="about-intro">
                <img src="images/image 4.jpeg" alt="Fotheby's Auctions" class="about-image"> <!-- Update this path with your actual image -->
                <p>Welcome to Fotheby's Auctions, the premier destination for exclusive auctions. We specialize in fine art, antiques, rare collectibles, and luxury items.</p>
            </section>

            <div class="about-details">
                <div class="about-mission">
                    <img src="images/image1.jpg" alt="Our Mission" class="about-image"> <!-- Update this path with your actual image -->
                    <h2>Our Mission</h2>
                    <p>Curating exceptional items for auction and providing outstanding experiences for our clientele.</p>
                </div>

                <div class="about-services">
                    <img src="images/image2.jpg" alt="What We Do" class="about-image"> <!-- Update this path with your actual image -->
                    <h2>What We Do</h2>
                    <p>Offering a seamless platform for the auctioning of premium goods, ensuring authenticity, quality, and excellence.</p>
                </div>

                <div class="about-contact">
                    <img src="images/image3.jpeg" alt="Contact Us" class="about-image"> <!-- Update this path with your actual image -->
                    <h2>Contact Us</h2>
                    <p>Have questions? Need assistance? Contact our customer service team or visit our Contact Page.</p>
                </div>
            </div>
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
        </div>
    </main>

    <?php require "layouts/footer.php"; ?>
</body>
</html>