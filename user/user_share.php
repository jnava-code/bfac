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


	<!-- SIDEBAR -->
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
						<h3>List of Shares Transaction </h3>
						<i class="bx bx-search"></i>
 
					</div>
					<table>
						<thead>
							<tr>
								<th>Member Name</th>
								<th>Shares Added</th>
								<th>Purchace Amount (₱)</th>
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


	<script src="../js/script.js"></script>
	<script src="../js/dropdown_profile.js"></script>
</body>
</html>