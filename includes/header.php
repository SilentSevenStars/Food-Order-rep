<nav class="navbar navbar-expand-lg navbar-light bg-warning sticky-top">
  <div class="container">
    <a href="../index.php" class="navbar-brand">Foodies</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="menu.php">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="order.php">Order</a>
                </li>
      </ul>
      <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="search.php"><i class="bi bi-search" style="font-size: 18px;"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="bi bi-cart" style="font-size: 18px;"></i></a>
                </li>
                
                <?php
                    if(!isset($_SESSION['customer_id'])){
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <?php
                    } else {
                ?>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="navbar-brand pe-md-0">
                                <i class="bi bi-person"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Setting</a>
                                <a href="logout.php" class="dropdown-item">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php } ?>
            </ul>
    </div>
  </div>
</nav>