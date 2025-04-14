<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/modal.css">
	<link rel="stylesheet" href="../css/shares.css">
    <title> Transaction History</title>

<body>


	<!-- <section id="sidebar">
		<a href="#" class="brand">
			<img src="../img/logo.png" alt="Logo" class="logo">
			<div class="text">
				<span class="title">BFAC Hub</span>
				<span class="subtitle"> Management System</span>
			</div>
		</a>
		
        <ul class="side-menu top">
            <li ><a href="home.html"><i class='bx bxs-home' ></i><span class="text"> Home</span></a></li>
            <li><a href="profile.html"><i class="bx bxs-user"></i><span class="text">Your Profile</span></a></li>
			<li><a href="user_div.html"><i class='bx bx-history'></i><span class="text">Your Dividend History </span></a></li>
			<li><a href="user_share.html"><i class='bx bx-history'></i><span class="text">Your Shares History </span></a></li>
		</ul>
		<ul class="side-menu">
			<li><a href="logout.php" class="logout"><i class="bx bxs-log-out-circle"></i><span class="text">Logout</span></a></li>
		</ul>
	</section> -->

	<?php include "user_components/user_sidebar.php"; ?>

	<section id="content">
        <nav>
			<i class="bx bx-menu"></i>
			  
			<div class="profile-dropdown">
			  <a href="#" class="profile"><img src="../img/admin.png" alt="Profile" /></a>
			</div>
		  </nav>
		<main>
			<div class="head-title">
			<div class="left">
				<h1 id="page-title">Transaction History</h1>
				
			</div>
				
			</div>

			

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Dividends Transaction </h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Member Name</th>
								<th>Category</th>
								<th>Amount Withdrawn (₱)</th>
								<th>Receipt Control Number</th>
								<th>Date and Time</th>
						</thead>
						<tbody>
                           
						</tbody>
					</table>
				</div>
			</div>
		</main>
	</section>
  
	
    <script src="../js/kebab.js"></script>
	<script src="../js/script.js"></script>
</body>
</html>