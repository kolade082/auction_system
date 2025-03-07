<?php
session_start();
require 'as1csy2028.php';
?>

<head>
    <title>Auctions Listing</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <?php require "layouts/header.php"; ?>
    <?php
   
    $queryConditions = [];
    $params = [];
    $sql = "SELECT a.auction_id, a.user_id, a.title, a.auction_description, a.startDate, a.endDate, a.image, a.category_id, c.category_id, c.category_name AS catName, u.firstName, u.lastName, u.user_id 
        FROM auction a 
        JOIN category c ON a.category_id = c.category_id 
        JOIN users u ON a.user_id = u.user_id";
    
    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
        // Handle search
        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $s = "%" . trim($_GET['search']) . "%";
            $queryConditions[] = "(a.title LIKE ? OR a.auction_description LIKE ?)";
            $params[] = $s;
            $params[] = $s;
        }
    
        // Handle price filters
        if(isset($_GET['price'])) {
            $priceConditions = [];
            // ... handle as before
        }
    
        // Handle category filters
        if(isset($_GET['category'])) {
            $categoryConditions = [];
            // ... handle as before

        foreach($_GET['category'] as $categoryId) {
            $categoryConditions[] = "c.category_id = ?";
            $params[] = filter_var($categoryId, FILTER_SANITIZE_NUMBER_INT);
        }
        $queryConditions[] = "(" . implode(' OR ', $categoryConditions) . ")";
        }
    
        // Combine all conditions
        if (!empty($queryConditions)) {
            $sql .= " WHERE " . implode(' AND ', $queryConditions);
        }
    
        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $auctions = $stmt->fetchAll();
    } else {
        // Default behavior (e.g., load all auctions or handle differently)
        $stmt = $pdo->prepare("SELECT a.auction_id, a.user_id, a.title, a.auction_description, a.startDate, a.endDate, a.image, a.category_id, c.category_id, c.category_name AS catName, u.firstName, u.lastName, u.user_id FROM auction a JOIN category c ON a.category_id = c.category_id JOIN users u ON a.user_id = u.user_id");
        $stmt->execute();
        $auctions = $stmt->fetchAll();
    }

    ?>

    <div class="content-container">
        <aside class="sidebar-filter">
            <!-- Sidebar content -->
            <h2>Filter By</h2>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get"> 
      

            <!-- Filter for Location -->
            <div class="filter-group">
        <h4 class="filter-title"><i class="fas fa-map-marker-alt"></i>  Location</h4>
        <ul class="filter-options">
                <ul class="nav-options">
                    <!-- Add location filter options here -->
                </ul>
            </div>
            <!-- Filter for Categories -->
            <div class="filter-group">
        <h4 class="filter-title"><i class="fas fa-tags"></i>  Categories</h4>
        <ul class="filter-options">
        <?php
                // Fetch categories from the database
                $stmt = $pdo->prepare("SELECT * FROM category");
                $stmt->execute();
                $categories = $stmt->fetchAll();

                // Display each category as a filter option with checkboxes
                foreach ($categories as $category) {
                    echo '<li><input type="checkbox" id="cat' . $category['category_id'] . '" name="category[]" value="' . $category['category_id'] . '"><label for="cat' . $category['category_id'] . '">' . htmlspecialchars($category['category_name']) . '</label></li>';
                }
                ?>
                </ul>
            </div>
            <div class="filter-button">
            <input type="submit" value="Filter" />
        </div>
            </form>
        </aside>


        <main class="product-listings">
            <?php foreach ($auctions as $row) :
                $stmt = $pdo->prepare("SELECT MAX(amount_bidded) as amount_bidded FROM bids WHERE auction_id = ?");
                $startDate = new DateTime($row['startDate']);
                $endDate = new DateTime($row['endDate']);
                $now = new DateTime();
            
                // Determine auction status
                $isAuctionLive = $startDate <= $now && $endDate >= $now;
                $isAuctionExpired = $endDate < $now;

                
                $formattedStartDate = $startDate->format('F j, Y H:i:s');
                $formattedEndDate = $endDate->format('F j, Y H:i:s');

            ?>
                <div class="product-item">
                    <div class="product-header">
                        <span class="auction-date"> <?php echo htmlspecialchars($formattedStartDate); ?></span>
                        <span class="auction-date">- <?php echo htmlspecialchars($formattedEndDate); ?></span>
                    </div>
                    <div>
                        <img src="images/auctions/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    </div>
                    <div class="product-details">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <h3>Category: <?php echo htmlspecialchars($row['catName']); ?></h3>
                        <p><?php echo htmlspecialchars($row['auction_description']); ?></p>
                        <?php if ($isAuctionLive): ?>
    <a href="lots.php?auction_id=<?php echo htmlspecialchars($row['auction_id']); ?>" class="more-link">View Lots</a>
<?php else: ?>
    <span class="more-link disabled" onclick="showAuctionStatusMessage(<?php echo $isAuctionExpired ? 'true' : 'false'; ?>)">View Lots</span>
<?php endif; ?>




                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        </main>

    </div>
    <!-- Modal Structure -->
<div id="auctionStatusModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <p id="modalMessage"></p>
    </div>
</div>

<style>
    .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4); }
    .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; }
    .close-button { color: #aaa; float: right; font-size: 28px; font-weight: bold; }
    .close-button:hover, .close-button:focus { color: black; text-decoration: none; cursor: pointer; }
</style>

    <?php require "layouts/footer.php"; ?>
  
    <script>
function showAuctionStatusMessage(isExpired) {
    var message = isExpired ? "This auction has expired." : "This auction has not started yet.";
    document.getElementById("modalMessage").innerText = message;
    document.getElementById("auctionStatusModal").style.display = "block";
}

// Close the modal when the user clicks on <span> (x)
document.getElementsByClassName("close-button")[0].onclick = function() {
    document.getElementById("auctionStatusModal").style.display = "none";
}

// Close the modal when the user clicks anywhere outside of the modal
window.onclick = function(event) {
    if (event.target == document.getElementById("auctionStatusModal")) {
        document.getElementById("auctionStatusModal").style.display = "none";
    }
}
</script>


</body>

</html>