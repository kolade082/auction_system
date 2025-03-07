<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php if (isset($_SESSION['loggedin'])): ?>
    <div class='user-info'>
    Hey, <?php echo $_SESSION['userDetails']["firstName"]; ?>
    <i class="fas fa-user-circle user-icon"></i> <!-- User Icon -->
    
    <div class="user-menu">
        <?php if ($_SESSION['userDetails']['usertype'] == 'ADMIN' || $_SESSION['userDetails']['usertype'] == 'SELLER'): ?>
            <a class='dashboard' href='dashboard.php'><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <?php endif; ?>
        <a class='logout' href='logout.php'><i class="fas fa-sign-out-alt"></i> Logout</a>
        <!-- Add more links as needed -->
    </div>
</div>

<?php else: ?>
    <div class="auth-links">
        <a href="login.php">LOG IN</a>
        <span class="separator">|</span>
        <a href="register.php">SIGN UP</a>  
    </div>
<?php endif; ?>
<header>
    <a href="index.php">
        <h1 class='ibuy'>Fotheby's</h1>
    </a>
    <nav>
        <ul>
            <!-- <li class="nav-item dropdown">
                <a href="#">SET PREFERENCES</a>
                <ul class="dropdown-content">
                    <?php
                    require 'as1csy2028.php';
                    $stmt = $pdo->prepare("SELECT * FROM category");
                    $stmt->execute();
                    $categories = $stmt->fetchAll();
                    foreach ($categories as $category) {
                        echo '<li><a href="index.php?category_id=' . $category['category_id'] . '">' . htmlspecialchars($category['category_name']) . '</a></li>';
                    }
                    ?>
                </ul>
            </li> -->
            <li class="dash-nav-item"> <a href="buyNow.php">BUY NOW</a></li>
            
            <li class="dash-nav-item"> <a href="aboutUs.php">ABOUT US</a></li>
            <li class="dash-nav-item"> <a href="faqs.php">FAQs</a></li>
        </ul>
    </nav>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
        <input type="text" name="search" placeholder="Search for anything" />
        <input type="submit" name="submit" value="Search" />
    </form>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var userIcon = document.querySelector('.user-icon');
        var userMenu = document.querySelector('.user-menu');
        
        userIcon.addEventListener('click', function() {
            userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
        });

        // Close the dropdown if clicked outside
        window.addEventListener('click', function(event) {
            if (!event.target.matches('.user-icon')) {
                if (userMenu.style.display === 'block') {
                    userMenu.style.display = 'none';
                }
            }
        });
    });
</script>
