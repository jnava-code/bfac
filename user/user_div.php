<?php 
	include "../config/db.php";
	include "../auth/session.php"; 

	$sql = "SELECT * FROM admin_dividends WHERE member_id = '$member_id'";
	$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    <!-- <link rel="stylesheet" href="../css/modal.css"> -->
	<link rel="stylesheet" href="../css/shares.css">
    <title>Transaction History</title>

<body>
	<?php include "user_components/user_sidebar.php"; ?>

	<section id="content">
		<?php include "user_components/user_navbar.php"; ?>
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
								<th>Amount Withdrawn (₱)</th>
								<th>Receipt Control Number</th>
								<th>Date and Time</th>
						</thead>
						<tbody>
                           <?php
						   		if(mysqli_num_rows($result) > 0) {
									while($row = mysqli_fetch_assoc($result)) {
										$amount = $row['dividend_amount'];
										$receipt = $row['receipt'];
										$date = $row['calculation_date'];
										echo "<tr>
												<td>$amount</td>
												<td>$receipt</td>
												<td>$date</td>
											</tr>";
									}
								} else {
									echo "<tr>
											<td colspan='3'>No transaction history available.</td>
										</tr>";
								}
						   		mysqli_close($conn);
						   ?>
						   <?php
						   if (isset($_SESSION['message'])) {
							   echo "<script>
								   Swal.fire({
									   icon: 'success',
									   title: 'Success',
									   text: '{$_SESSION['message']}',
								   });
							   </script>";
							   unset($_SESSION['message']);
								}
						   ?>
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