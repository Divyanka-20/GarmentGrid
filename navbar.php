<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$name = $_SESSION['user_name'] ?? null;

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}
?>
<!-- THEN your HTML starts -->


<style>
nav {
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  padding: 10px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo-container img {
  height: 50px;
  padding-right: 10px;
}

.site-info .site-name {
  font-size: larger;
  font-weight: bold;
  font-family: Georgia, 'Times New Roman', Times, serif;
}

.site-info .tagline {
  font-size: 12px;
  color: #ddd;
  font-weight: bold;
  font-family: Georgia, 'Times New Roman', Times, serif;
  margin-top: 3px;
}

.nav-right {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user {
  font-family: 'Times New Roman', Times, serif;
  font-size: 18px;
}

.nav-right a {
  text-decoration: none;
  color: white;
  font-size: 18px;
  padding: 6px 12px;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.search-container {
  display: flex;
  align-items: center;
  position: relative;
}

.search-toggle {
  font-size: 20px;
  background: none;
  border: none;
  color: white;
  cursor: pointer;
}

.search-box {
  width: 0;
  opacity: 0;
  overflow: hidden;
  transition: width 0.4s ease, opacity 0.4s ease;
}

.search-box input {
  padding: 5px 10px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 200px;
  background-color: #fff;
  color: black;
}

.search-box.active {
  width: 200px;
  opacity: 1;
}

.hamburger {
  display: none;
  font-size: 26px;
  background: none;
  border: none;
  color: white;
  cursor: pointer;
}
.hamburger:hover {
  background-color: rgba(255, 255, 255, 0.1);
}
.nav-right a[title="View Cart"] {
  font-size: 22px;
  padding: 4px 10px;
}


@media screen and (max-width: 768px) {
  .nav-right {
    display: none;
    flex-direction: column;
    background-color: rgba(0, 0, 0, 0.85);
    position: absolute;
    top: 70px;
    right: 20px;
    padding: 15px;
    border-radius: 8px;
    z-index: 999;
  }

  .nav-right.show {
    display: flex;
  }

  .hamburger {
    display: block;
  }
}

.orders {
  font-family: 'Times New Roman', Times, serif;
  font-size: 20px; /* You can adjust this to 16px, 20px, etc. */
  color: white; /* Optional: to match navbar color scheme */
  text-decoration: none; /* Optional: remove underline */
  padding: 6px 12px; /* Optional: for better click area */
  border-radius: 4px;
  transition: background-color 0.3s;
}

.user-logout {
  display: flex;
  align-items: center;
  font-family: 'Times New Roman', Times, serif;
  gap: 10px;
}

</style>

<nav>
  <div class="logo-container">
    <a href="dashboard.php">
    <img src="/Garments/assets/logo.png" alt="Logo" />
    </a>
    <div class="site-info">
      <div class="site-name">GarmentGrid</div>
      <div class="tagline">Wear the Grid! Own the Look.💃🕺</div>
    </div>
  </div>

  <button class="hamburger" onclick="toggleMenu()">☰</button>

  <div class="nav-right" id="navRight">
    <form class="search-container" action="search.php" method="GET">
  <div class="search-box" id="searchBox">
    <input type="text" name="query" placeholder="Search products..." required />
  </div>
  <button type="submit" class="search-toggle" onclick="toggleSearch()">🔍</button>
</form>

<a href="cart.php" title="View Cart">🛒</a>
  <a href="orders.php" title="My Orders" class="orders">My Orders</a>
  <a href="user.php" title="My Profile" class="orders">👋🏻 Hello, <?php echo htmlspecialchars($name); ?></a>
  <a href="logout.php" title="Logout">⏻</a>

  </div>
</nav>

<script>
function toggleSearch() {
  const box = document.getElementById("searchBox");
  box.classList.toggle("active");
}

function toggleMenu() {
  const menu = document.getElementById("navRight");
  menu.classList.toggle("show");
}
</script>
