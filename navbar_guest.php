<!-- navbar_guest.php -->
<style>
  nav {
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  nav .logo-container {
    display: flex;
    align-items: center;
  }

  nav .logo-container img {
    height: 50px;
    padding-right: 10px;
  }

  nav .site-info {
    display: flex;
    flex-direction: column;
  }

  nav .site-info .site-name {
    font-size: larger;
    font-weight: bold;
    font-family: Georgia, 'Times New Roman', Times, serif;
  }

  nav .site-info .tagline {
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
    font-size: 16px;
    margin-right: 10px;
  }

  .nav-right a {
    text-decoration: none;
    color: white;
    font-size: 18px;
    padding: 6px 12px;
    border-radius: 4px;
    transition: background-color 0.3s;
  }

  .nav-right a:hover {
    background-color: #cc00ff;
  }

  @media screen and (max-width: 600px) {
    .nav-right {
      flex-direction: column;
      align-items: flex-end;
    }
  }
</style>

<nav>
  <div class="logo-container">
    <img src="/Garments/assets/logo.png" alt="Logo" />
    <div class="site-info">
      <div class="site-name">GarmentGrid</div>
      <div class="tagline">Wear the Grid! Own the Look.💃🕺</div>
    </div>
  </div>
  
</nav>
