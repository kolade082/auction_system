<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FAQS - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <?php require "layouts/header.php"; ?>
    <?php require "layouts/nav.php"; ?>

    <main>
        
        <h1>Frequently Asked Questions</h1>
        <section class="faq-section">
            <div class="faq-item">
                <h2>How do I register for an auction?</h2>
                <p>To register for an auction, simply create an account on our website and follow the registration link for the auction you are interested in.</p>
            </div>

            <div class="faq-item">
                <h2>Can I view items before bidding?</h2>
                <p>Yes, item previews are available online, and physical viewings can be scheduled by appointment.</p>
            </div>

            <div class="faq-item">
                <h2>What types of payment do you accept?</h2>
                <p>We accept various payment methods including credit cards, bank transfers, and PayPal.</p>
            </div>

            <div class="faq-item">
                <h2>How can I track my bids?</h2>
                <p>You can track your bids through your user dashboard on our website.</p>
            </div>

            <div class="faq-item">
                <h2>What happens if I win an auction?</h2>
                <p>If you win an auction, you will be notified via email with instructions on how to proceed with payment and collection/delivery of the item.</p>
            </div>

            <div class="faq-item">
                <h2>Is there a buyer's premium?</h2>
                <p>Yes, we charge a buyer's premium, which is a percentage of the final bid price. The exact amount will be specified in the auction terms.</p>
            </div>

            <div class="faq-item">
                <h2>Can I return an item?</h2>
                <p>Returns are generally not accepted for auction items, except in cases of significant misdescription or authenticity issues.</p>
            </div>

            <div class="faq-item">
                <h2>How do I contact customer service?</h2>
                <p>For any inquiries, please contact our customer service team through the contact form on our website or by calling our support hotline.</p>
            </div>
        </section>
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
    </main>

    <?php require "layouts/footer.php"; ?>
</body>

</html>
