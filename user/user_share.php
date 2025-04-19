<?php 
	include "../config/db.php";
	include "../auth/session.php"; 

	$sales_query = "SELECT * FROM admin_shares_list WHERE member_id = '$member_id'";
	$sales_result = mysqli_query($conn, $sales_query);
?>
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
						<h3>List of Shares Transaction </h3>
						<i class="bx bx-search"></i>
 
					</div>
					<table>
						<thead>
							<tr>
								<th>Shares Added</th>
								<th>Purchace Amount (₱)</th>
								<th>Receipt Control Number</th>
								<th>Date and Time</th>
						</thead>
						<tbody>
							<?php
								if (mysqli_num_rows($sales_result) > 0) {
									while ($sales_row = mysqli_fetch_assoc($sales_result)) {
										$share_capital = number_format($sales_row['share_capital']);
										$paid_up_share_capital = number_format($sales_row['paid_up_share_capital']);
										echo "<tr>
											<td>{$share_capital}</td>
											<td>₱{$paid_up_share_capital}.00</td>
											<td>{$sales_row['receipt_number']}</td>
											<td>{$sales_row['created_at']}</td>
										</tr>";		
									}
								} else {
									echo "<tr><td colspan='4'>No transaction history available.</td></tr>";
								}
							?>
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