<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['user_name'];
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>GarmentGrid - Dashboard</title>
  <style>
    body {
        background-image: url('https://images.pond5.com/abstract-light-multi-color-backgrounds-070554390_prevstill.jpeg');
        background-size: cover;
        margin: 0;
        font-family: Arial, sans-serif;
        color: #222;
    }

    /* Carousel Styles */
    .carousel-container {
      width: 100%;
      max-width: 800px;
      margin: 80px auto 40px;
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      background-color: transparent;
    }

    .carousel-track {
      display: flex;
      flex-wrap: nowrap;
      transition: transform 0.6s ease-in-out;
      width: 100%;
    }

    .carousel-card {
      flex: 0 0 100%;
      box-sizing: border-box;
      position: relative;
    }

    .carousel-card img {
      width: 100%;
      aspect-ratio: 16/9;
      object-fit: cover;
      display: block;
      border-radius: 10px 10px 0 0;
    }

    .carousel-caption {
      position: absolute;
      bottom: 0;
      background:rgba(179, 255, 0, 0.6);
      width: 100%;
      padding: 15px;
      font-size: 25px;
      text-align: center;
      font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
      color:rgba(255, 0, 0, 0.84);
      border-radius: 0 0 10px 10px;
    }

    .nav-dots {
      display: flex;
      justify-content: center;
      margin-top: 15px;
      gap: 10px;
      user-select: none;
    }

    .nav-dots span {
      display: inline-block;
      width: 12px;
      height: 12px;
      border: 2px solid black;
      background-color: transparent;
      border-radius: 50%;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .nav-dots span.active {
      background-color: #ffffff ;
    }

    /* Offers Section */
    .offers-section {
      max-width: 1200px;
      margin: 40px auto 80px;
      padding: 0 20px;
    }

    .offers-heading {
      text-align: center;
      font-size: 30px;
      color: rgb(255, 0, 123);
      font-family: 'Times New Roman', Times, serif;
      margin-bottom: 30px;
      position: relative;
      box-shadow: 0 0 15px rgba(0,0,0,0.15);
      border-radius: 16px;
      background-color: rgba(0, 0, 0, 0.7);
      padding: 10px 0;
    }

    /* Category Cards */
    .category-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 25px;
    }

    .category-card {
      background-color: #E6E6FA;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.81);
      transition: transform 0.3s;
      display: flex;
      flex-direction: column;
      aspect-ratio: 16/9;
      height: 260px;
      width: 100%;
      max-width: 100%;
      aspect-ratio: 16/9;
      margin: 0 auto;
      cursor: pointer;
    }

    .category-card img {
      height: 160px;
      width: 100%;
      object-fit: cover;
      display: block;
    }

    .category-content {
      background-color: rgba(136, 255, 0, 0.43);
      padding: 15px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      font-family: 'Times New Roman', Times, serif;
      font-weight: bolder;
      border-radius: 0 0 12px 12px;
      text-align: center;
    }

    .category-content h3 {
      font-size: 18px;
      margin-bottom: 12px;
      color: #333;
      text-decoration: none;
      font-weight: bolder;
      margin-top: 0px;
    }

    .coupon-row {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      gap: 5px;
    }

    /* Use the offer-btn styles for category buttons */
    .offer-btn {
      text-decoration: none;
      background-color: crimson;
      color: white;
      padding: 10px 20px;
      width: 100px;
      text-align: center;
      font-weight: bold;
      border-radius: 5px;
      font-size: 13px;
      transition: background-color 0.3s;
      cursor: pointer;
      display: inline-block;
      user-select: none;
      justify-content: center;
    }

    .offer-btn:hover {
      background-color: #A11A35;
    }

    @media (max-width: 600px) {
      .category-cards {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    .offers-section {
      max-width: 1200px;
      margin: 60px auto;
      padding: 30px 20px;
      /*background-color: rgba(255, 255, 255, 0.9);
      border-radius: 16px;
      box-shadow: 0 0 15px rgba(0,0,0,0.15);*/
    }

    .h3{
      font-family: 'Times New Roman', Times, serif;
      font-size: larger;
      font-weight: bold;
      color: black;
      text-align: center;
    }

    .offers-heading {
      text-align: center;
      font-size: 30px;
      color:rgb(255, 0, 123);
      font-family: 'Times New Roman', Times, serif;
      margin-bottom: 30px;
      position: relative;
      box-shadow: 0 0 15px rgba(0,0,0,0.15);
      border-radius: 16px;
      background-color:rgba(0, 0, 0, 0.7);
    }

    .offer-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }

    @media (max-width: 600px) {
      .offer-cards {
        grid-template-columns: repeat(2, 1fr); /* 2 columns in mobile */
      }
    }


    .offer-card {
      background-color: #E6E6FA;  /* light lavender */
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.81);
      transition: transform 0.3s;
      display: flex;
      flex-direction: column;
      aspect-ratio: 16/9;
      height: 250px;
      width: 100%;
      max-width: 100%;
      margin: 0 auto;
    }

    .offer-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 5px; /* space below header */
    }

    .offer-header h3 {
      margin: 0;
      margin-top: 0;
      font-size: 18px;
      font-weight: bolder;
      font-family: 'Times New Roman', Times, serif;
      color: #333;
    }

    .offer-btn:hover {
      background-color: #A11A35;
    }

    .offer-card img {
      height: 140px;          
    }

    .offer-content {
      background-color:rgba(136, 255, 0, 0.43); 
      padding: 15px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      font-family: 'Times New Roman', Times, serif;
      font-weight: bolder;
      border-radius: 0 0 12px 12px;
    }

    .offer-content h3 {
      font-size: 18px;
      margin-bottom: 3px;
      color: #333;
      font-weight: bolder;
    }

    .offer-content p {
      padding: 2px;
      font-size: 13px;
      color: #666;
      margin-bottom: 4px;
    }

    .coupon-row {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      gap: 5px;
    }

    @media (max-width: 600px) {
      .coupon-row {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .coupon-row .offer-btn {
        margin-top: 6px;
        align-self: center; /* center button */
      }
    }

    .offer-btn {
      align-self: flex-start;
      text-decoration: none;
      background-color:crimson;
      color: white;
      padding: 10px;
      width: 100px;
      text-align: center;    
      font-weight: bold;
      border-radius: 5px;
      font-size: 13px;
      transition: background-color 0.3s;
    }

    .offer-title {
      text-align: center;
      margin: 0 0 10px 0;
      font-size: 18px;
      color: #333;
    }

    .coupon-row {
      display: flex;
      align-items: center;
    }

    .coupon-row p {
      margin: 0;
      font-size: 10px;
      font-weight: bolder;
      color: #333;
      font-family: 'Times New Roman', Times, serif;
    }

    .carousel-container {
      width: 100%;
      max-width: 800px;
      margin: 80px auto;
      position: relative;
      overflow: hidden;
      border-radius: 10px;
    }

    .carousel-track {
      display: flex;
      flex-wrap: nowrap;
      transition: transform 0.6s ease-in-out;
      width: 100%;
    }

    .carousel-card {
      flex: 0 0 100%;
      box-sizing: border-box;
      position: relative;
    }

    .carousel-card img {
      width: 100%;
      aspect-ratio: 16/9; /* responsive ratio */
      object-fit: cover;
      display: block;
    }

    .carousel-caption {
      position: absolute;
      bottom: 0;
      background:rgba(179, 255, 0, 0.6) ;
      width: 100%;
      padding: 15px;
      font-size: 25px;
      text-align: center;
      font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
      color:rgba(255, 0, 0, 0.84);
    }

    .nav-dots {
      display: flex;
      justify-content: center;
      margin-top: 15px;
      gap: 10px;
    }

    .nav-dots span {
      display: inline-block;
      width: 12px;
      height: 12px;
      border: 2px solid black;
      background-color: transparent;
      border-radius: 50%;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .nav-dots span.active {
      background-color: #ffffff ;
    }

    @media (max-width: 600px) {
      .category-cards {
        grid-template-columns: repeat(2, 1fr); /* 2 cards per row */
        gap: 15px;
      }

      .category-card {
        width: 100%;  /* take full width of grid cell */
        height: 270px;     /* allow height to adjust */
      }

      .category-card img{
        height: 155px;
        width: 100%;
        object-fit: cover;
        display: block;
      }

      .h3{
        font-family: 'Times New Roman', Times, serif;
        font-size: 14px;
        font-weight: bold;
        color: black;
        text-align: center;
      }

      .offer-card{
        height: 300px;
      }
    }

    .category-title {
      text-decoration: none !important;
    }

    .offer-details {
      opacity: 0;
      max-height: 0;
      overflow: hidden;
      transition: opacity 0.4s ease, max-height 0.4s ease;
      font-size: 10px;
      background-color: #E6E6FA;
      width: 100%;
      color: #222;
      margin-top: 6px;
      text-align: center;
    }

    .offer-card:hover .offer-details {
      opacity: 1;
      max-height: 100px; /* adjust based on content */
    }

  </style>
</head>
<body>
  <div class="wrapper">

    <!-- Carousel Section -->
    <div class="carousel-container">
    <h2 class="offers-heading">DRESS THE WAY YOU FEEL !!</h2>
    <div class="carousel-track" id="carouselTrack">
      <div class="carousel-card">
        <a href="page.php?category=Ethnic Saree&table=womens">
          <img src="https://images.hindustantimes.com/img/2022/12/15/1600x900/photo_2022-12-15_05-14-59_1671110153460_1671110158706_1671110158706.jpg" alt="Sarees">
          <div class="carousel-caption">ETHNIC SAREES</div>
        </a>
      </div>
      <div class="carousel-card">
        <a href="page.php?category=Festive Wear&table=mens">
          <img src="https://images.hindustantimes.com/img/2023/01/28/1600x900/photo_2023-01-27_20-32-30_1674880458065_1674880462396_1674880462396.jpg" alt="Traditionals for Men">
          <div class="carousel-caption">MENS FESTIVE WEAR</div>
        </a>
      </div>
      <div class="carousel-card">
        <a href="page.php?category=Traditional Suit&table=womens">
          <img src="https://www.hatkay.com/cdn/shop/articles/How-to-Look-Stylish-in-Traditional-Indian-Clothing-Where-to-Buy-the-Best-Fashionable-Ethnic-Wear-for-Women-Online.jpg?v=1671543652" alt="Suits for Women">
          <div class="carousel-caption">WOMENS TRADITIONAL SUITS</div>
        </a>
      </div>
      <div class="carousel-card">
        <a href="page.php?category=Indo-western Dress&table=womens">
        <img src="https://www.fashna.com/wp-content/uploads/2022/10/Indo-Western-Diwali-Outfits-1024x536.jpg" alt="Indo-western Wear for Women">
        <div class="carousel-caption">WOMENS INDO-WESTERN</div>
  </a>
      </div>
      <div class="carousel-card">
        <a href="page.php?category=Office Wear&table=mens">
        <img src="https://www.suitsexpert.com/wp-content/uploads/smart-casual-attire-for-office.jpg" alt="Formals for Men">
        <div class="carousel-caption">MENS OFFICE WEAR</div>
  </a>
      </div>
      <div class="carousel-card">
        <a href="page.php?category=Office Wear&table=womens">
        <img src="https://img.freepik.com/premium-photo/standing-against-grey-background-young-adult-woman-formal-clothes-is-indoors-office_146671-56349.jpg" alt="Formals for Women">
        <div class="carousel-caption">WOMENS OFFICE WEAR</div>
  </a>
      </div>
      <div class="carousel-card">
        <a href="page.php?category=Western Wear&table=womens">
        <img src="https://i.ytimg.com/vi/gIQLCxJnNk4/maxresdefault.jpg" alt="Western Wear for Women">
        <div class="carousel-caption">WOMENS WESTERN WEAR</div>
  </a>
      </div>
      <div class="carousel-card">
        <a href="page.php?category=Special Occasions&table=couplewears">
        <img src="https://img.weddingbazaar.com/shaadisaga_production/photos/pictures/006/393/894/new_large/south_indian_couples.jpg?1680074287" alt="Couple Coordinates">
        <div class="carousel-caption">COUPLE COORDINATES</div>
  </a>
      </div>  
      <div class="carousel-card">
        <a href="page.php?category=Casual Wear&table=mens">
        <img src="http://perkclothing.com/cdn/shop/articles/ls_outside_1016.jpg?v=1655826119" alt="Formals for Men">
        <div class="carousel-caption">MENS CASUAL WEAR</div>
  </a>
      </div>
      <div class="carousel-card">
        <a href="page.php?category=Western Wear&table=boyswear">
        <img src="https://i.pinimg.com/originals/85/1c/12/851c12ed616856b8b8830c2c1c61ad4b.jpg" alt="Boys Wear">
        <div class="carousel-caption">BOYS WESTERN WEAR</div>
  </a>
      </div>         
      <div class="carousel-card">
        <a href="page.php?category=Summer Wear&table=girlswear">
        <img src="https://assets.vogue.com/photos/6514a2ec1efa9d6b1de4f850/master/w_2560%2Cc_limit/00-story%2520(66).jpg" alt="Girls Wear">
        <div class="carousel-caption">GIRLS SUMMER WEAR</div>
  </a>
      </div>
    </div>
    <div class="nav-dots" id="navDots">
      <span onclick="moveToSlide(0)"></span>
      <span onclick="moveToSlide(1)"></span>
      <span onclick="moveToSlide(2)"></span>
      <span onclick="moveToSlide(3)"></span>
      <span onclick="moveToSlide(4)"></span>
      <span onclick="moveToSlide(5)"></span>
      <span onclick="moveToSlide(6)"></span>
      <span onclick="moveToSlide(7)"></span>
      <span onclick="moveToSlide(8)"></span>
      <span onclick="moveToSlide(9)"></span>
      <span onclick="moveToSlide(10)"></span>
</div>
  </div>

    <!-- Category Cards Section -->
    <div class="offers-section" aria-label="Shop by category">
      <h2 class="offers-heading">SHOP BY CATEGORY</h2>
      <div class="category-cards">

        <div class="category-card" tabindex="0" role="group" aria-labelledby="category-women">
           <a href="category.php?category=Women&table=womens">
          <img src="http://www.ladleedirect.co.uk/cdn/shop/collections/800x800x1.jpg?v=1711493112" alt="Women's Wear"/>
          <div class="category-content">
            <a href="category.php?category=Women&table=womens" style="text-decoration: none;">
              <h3 class="category-title">Womens</h3>
            </a>
            <div class="coupon-row"  style="justify-content: center;">
              <a href="category.php?category=Women&table=womens" class="offer-btn" role="button">Explore</a>
            </div>
          </div>
            </a>
        </div>

        <div class="category-card" tabindex="0" role="group" aria-labelledby="category-men">
          <a href="category.php?category=Men&table=mens">
          <img src="https://cms.qz.com/wp-content/uploads/2017/08/andamen-3.jpg?quality=75&strip=all&w=1400" alt="Men's Wear" />
          <div class="category-content">
            <a href="category.php?category=Men&table=mens" style="text-decoration: none;">
              <h3 class="category-title">Mens</h3>
            </a>
            <div class="coupon-row" style="justify-content: center;">
              <a href="category.php?category=Men&table=mens" class="offer-btn" role="button">Explore</a>
            </div>
          </div>
          </a>
        </div>

        <div class="category-card" tabindex="0" role="group" aria-labelledby="category-boys">
          <a href="category.php?category=Boys&table=boyswear">
          <img src="https://thumbs.dreamstime.com/b/kid-boy-child-studio-hat-cute-fashion-white-background-232745290.jpg" alt="Boy's Wear" />
          <div class="category-content">
            <a href="category.php?category=&table=boyswear" style="text-decoration: none;">
              <h3 class="category-title">Boys</h3>
            </a>
            <div class="coupon-row" style="justify-content: center;">
              <a href="category.php?category=Boys&table=boyswear" class="offer-btn" role="button">Explore</a>
            </div>
          </div>
          </a>
        </div>

        <div class="category-card" tabindex="0" role="group" aria-labelledby="category-girls">
          <a href="category.php?category=Girls&table=girlswear">
          <img src="http://www.myfairbabyboutique.com/cdn/shop/collections/dolce_petit7_1200x1200.jpg?v=1590925544" alt="Girl's Wear" />
          <div class="category-content">
            <a href="category.php?category=Girls&table=girlswear" style="text-decoration: none;">
              <h3 id="category-girls" class="category-title">Girls</h3>
            </a>
            <div class="coupon-row" style="justify-content: center;">
              <a href="category.php?category=Girls&table=girlswear" class="offer-btn" role="button">Explore</a>
            </div>
          </div>
          </a>
        </div>

        <div class="category-card" tabindex="0" role="group" aria-labelledby="category-couples">
          <a href="category.php?category=Couples&table=couplewears">
          <img src="https://www.lovelyweddingmall.com/cache/medium/product/8119/7N8dsJPFntZ0FD5lfhxH7k083NZnocG9fpnXNesU.jpeg" alt="Couple Wear" />
          <div class="category-content">
            <a href="category.php?category=Couples&table=couplewears" style="text-decoration: none;">
              <h3 id="category-couples" class="category-title">Couple Coordinates</h3>
            </a>
            <div class="coupon-row" style="justify-content: center;">
              <a href="category.php?category=Couples&table=couplewears" class="offer-btn" role="button">Explore</a>
            </div>
          </div>
          </a>
        </div>

      </div>
    </div>

    <!-- Offers Section Placeholder -->
    <div class="offers-section" aria-label="Exclusive offers">
      <h2 class="offers-heading">EXCLUSIVE OFFERS</h2>
      <h3 class="h3">!! Use below Coupon Codes to avail the offers !!</h3>
      <div class="offer-cards">

        <div class="offer-card">
  <img src="assets/offers/newuser.jpg" alt="New User" />
  <div class="offer-content">
    <h3 class="offer-title">New User</h3>
    <div class="coupon-row">
      <p><b>Use Coupon Code</b></p>
      <a class="offer-btn">NEWUSER</a>
    </div>
    <div class="offer-details">
      Flat ₹399 off on first order only.<br>Minimum order value is ₹1199.
    </div>
  </div>
</div>


      <div class="offer-card">
  <img src="assets/offers/freedel.jpg" alt="Free Shipping" />
  <div class="offer-content">
    <h3 class="offer-title">Free Shipping</h3>
    <div class="coupon-row">
      <p><b>Use Coupon Code</b></p>
      <a class="offer-btn">FREEDEL</a>
    </div>
    <div class="offer-details">
      Free shipping on an order.<br>Minimum order value is ₹999.
    </div>
  </div>
</div>

      <div class="offer-card">
  <img src="assets/offers/flat50.jpg" alt="Flat 50% Off" />
  <div class="offer-content">
    <h3 class="offer-title">Flat 50% Off</h3>
    <div class="coupon-row">
      <p><b>Use Coupon Code</b></p>
      <a class="offer-btn">FLAT50</a>
    </div>
    <div class="offer-details">
      Flat 50% off on an order.<br>Minimum order value is ₹3999.
    </div>
  </div>
</div>

    <div class="offer-card">
    <img src="assets/offers/b1g1.jpg" alt="Buy 1 Get 1 Free" />
    <div class="offer-content">
      <h3 class="offer-title">Buy 1 Get 1 Free</h3>
      <div class="coupon-row">
        <p><b>Use Coupon Code</b></p>
        <a class="offer-btn">B1G1</a>
      </div>
      <div class="offer-details">
        Buy 1 Get 1 Free on Womenswear.<br>Minimum order value is ₹3499.
      </div>
    </div>
  </div>

    <div class="offer-card">
    <img src="assets/offers/combo.jpg" alt="Combo Offer" />
    <div class="offer-content">
      <h3 class="offer-title">Combo Offer</h3>
      <div class="coupon-row">
        <p><b>Use Coupon Code</b></p>
        <a class="offer-btn">2BUY1599</a>
      </div>
      <div class="offer-details">
        Buy 2 quantities for ₹1599.<br>Order value range is ₹1899 - ₹2099.
      </div>
    </div>
      </div>

    </div>
    <br><p align="center" style="font-weight: bolder; font-family: 'Times New Roman', Times, serif; font-size: 14px">* Terms & conditions applied</p>
  </div>

<?php include 'footer.php'; ?>

<script>
  function toggleSearch() {
    const box = document.getElementById("searchBox");
    box.classList.toggle("active");
  }

  function toggleMenu() {
    const menu = document.getElementById("navRight");
    menu.classList.toggle("show");
  }

  const track = document.getElementById('carouselTrack');
  const dots = document.querySelectorAll('.nav-dots span');
  let index = 0;
  let slideInterval = setInterval(nextSlide, 5000);

  function nextSlide() {
    index = (index + 1) % dots.length;
    moveToSlide(index);
  }

  function moveToSlide(i) {
    index = i;
    track.style.transform = `translateX(-${i * 100}%)`;

    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === i);
      dot.setAttribute('aria-selected', idx === i ? 'true' : 'false');
      dot.tabIndex = idx === i ? 0 : -1;
    });

    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 5000);
  }

  dots.forEach((dot, idx) => {
    dot.addEventListener('click', () => moveToSlide(idx));
    dot.addEventListener('keydown', e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        moveToSlide(idx);
      }
    });
  });

  // Initialize first dot active
  moveToSlide(0);
</script>
</body>
</html>
