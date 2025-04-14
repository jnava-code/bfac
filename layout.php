<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="modal.css">
<!-- Notyf CSS -->
<link rel="stylesheet" href="path/to/notyf.min.css">
	<link rel="stylesheet" href="shares.css">
    <title> Management</title>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<img src="img/logo.png" alt="Logo" class="logo">
			<div class="text">
				<span class="title">BFAC Hub</span>
				<span class="subtitle"> Management System</span>
			</div>
		</a>
		
		<ul class="side-menu top">
				<li class=" "><a href="dashboard.php"><i class="bx bxs-dashboard"></i><span class="text">Dashboard</span></a></li>
				<li><a href="users.php"><i class="bx bxs-user"></i><span class="text">Users</span></a></li>
                <li><a href="members.php"><i class="bx bxs-user-detail"></i><span class="text">Manage Members</span></a></li>
                <li><a href="product.php"><i class="bx bxs-box"></i><span class="text">Product Inventory</span></a></li>
                <li><a href="services.php"><i class="bx bxs-briefcase"></i><span class="text">Services Information</span></a></li>
                <li><a href="shares.php"><i class="bx bxs-coin-stack"></i><span class="text">Shares</span></a></li>
                <li><a href="div.php"><i class='bx bx-line-chart-down'></i><span class="text">Dividends</span></a></li>
                <li><a href="livestock.php"><i class='bx bxs-book-content'></i></i><span class="text">Livestock Management</span></a></li>
                <li><a href="bid.php"><i class="bx bxs-file-doc"></i><span class="text">Bid Contract Tracking</span></a></li>
                <li><a href="order.php"><i class='bx bxs-cart-alt' ></i></i><span class="text">Order</span></a></li>

		</ul>
		<ul class="side-menu">
			<li>
				<a href="settings.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
			<a href="notif.php" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <div class="profile-dropdown">
                <a href="#" class="profile"><img src="img/admin.png"></a>
                <ul class="dropdown-menu">
                    <li><a href="AccountSettings.php">Edit Profile</a></li>
                    <li><a href="add_account.php">Add Account</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
		<!-- MAIN -->
		<main>
			<div class="head-title">
			<div class="left">
				<h1 id="page-title">Orders</h1>
				<ul class="breadcrumb">
					<li><a href="#">Dashboard</a></li>
					<li><i class='bx bx-chevron-right'></i></li>
					<li><a class="active" href="#" id="current-page">Orders</a></li>
				</ul>
			</div>
				
			</div>

			

			<!-- insert here -->
		
		</main>
	</section>

	

	<script src="js/script.js"></script>
	<script src="js/dropdown_profile.js">    </script>
</body>
</html>