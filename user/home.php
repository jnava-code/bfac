<?php 
	include "../config/db.php";
	include "../auth/session.php"; 

	$sales_query = "
		SELECT SUM(asales.amount) AS total_sales
		FROM admin_sales AS asales
	";

	$sales_result = mysqli_query($conn, $sales_query);
	$sales_row = mysqli_fetch_assoc($sales_result);	
	$total_sales = $sales_row['total_sales'] ?? 0;

	$expenses_query = "SELECT SUM(amount) AS total_amount FROM admin_expenses";
	$expenses_result = mysqli_query($conn, $expenses_query);
	$expenses_row = mysqli_fetch_assoc($expenses_result);

	$total_expenses = $expenses_row['total_amount'] ?? 0;

	$sql_share = "
        SELECT 
            SUM(asl.paid_up_share_capital) AS total_paid_up_share_capital,
            SUM(asl.share_capital) AS total_share_capital
        FROM admin_shares AS ashares
        LEFT JOIN admin_shares_list asl ON asl.member_id = ashares.member_id
		WHERE ashares.member_id = '$member_id'
	";
	$result_share = mysqli_query($conn, $sql_share);
	$row_share = mysqli_fetch_assoc($result_share);
	$total_paid_up_share_capital = $row_share['total_paid_up_share_capital'] ? $row_share['total_paid_up_share_capital'] : 0;
	$total_share_capital = $row_share['total_share_capital'] ? $row_share['total_share_capital'] : 0;

	$net_income = $total_sales - $total_expenses;
	$statutory_funds = $net_income * 0.30;
	$net_surplus = $net_income - $statutory_funds;

	$all_shares_query = "
		SELECT SUM(share_capital) AS all_total_shares
		FROM admin_shares_list
	";
	$all_shares_result = mysqli_query($conn, $all_shares_query);
	$all_shares_row = mysqli_fetch_assoc($all_shares_result);
	$total_shares = $all_shares_row['all_total_shares'] ?? 0;

	if ($total_shares > 0) {
		$dividend_per_share = $net_surplus / $total_shares;
		$total_dividend = $dividend_per_share * $total_share_capital;
	} else {
		$dividend_per_share = 0;
		$total_dividend = 0;
	}
	

	$sql_dividend = "
		SELECT SUM(dividend_amount) AS total_dividend
		FROM admin_dividends
		WHERE member_id = '$member_id'
	";
	$result_dividend = mysqli_query($conn, $sql_dividend);
	$row_dividend = mysqli_fetch_assoc($result_dividend);
	$dividend = $row_dividend['total_dividend'] ? $row_dividend['total_dividend'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/sam.css">
	<link rel="stylesheet" href="../css/home.css">
	<title>Users</title>
</head>
<body>

	<?php include "user_components/user_sidebar.php"; ?>

	<section id="content">
		<?php include "user_components/user_navbar.php"; ?>

		<main>
			<div class="head-title">
				<div class="left">
					<h1>Welcome back, <?php echo $firstname . ' ' . $lastname; ?>!</h1>
					<ul class="breadcrumb">
						<li style="font-size: small;">Here's your current share capital and dividend overview</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<a href="user_div.html">
					<div class="calcu">
						<span>Dividend Balance</span>
						<button class="info-btn">
							<i class='bx bxs-info-circle' ></i>
						</button>
						<div class="amount">
							<span>₱</span>
							<h2><?php echo number_format($total_dividend - $dividend)?></h2>
						</div>
					</div>
				</a>
				<a href="user_share.html">
					<div class="balance-details">
						<div class="detail-item">
							<span>Shares Capital</span>
							<div class="share-capital">
								<span style="font-size: 28px;">₱</span>
								<strong><?php echo $total_paid_up_share_capital; ?></strong>
							</div>
						</div>
						<div class="detail-item">
							<span>Share</span>
							<strong><?php echo number_format($total_share_capital); ?></strong>
						</div>
					</div>
				</a>
				</div>
			</div>

			<div class="c-card">
				<div class="c-header">
					<h3>Dividend Projection Calculator</h3>
                    <button class="help-btn" id="helpBtn">
                        <i class='bx bxs-help-circle'></i> 
                    </button>
				</div>
				<div class="c-body">
					<div class="form-group">
						<label for="share-amount">Share Capital (₱)</label>
						<input type="number" id="share-amount" placeholder="Enter your share capital amount">
					</div>
					<button class="btn-primary" onclick="calculateDividend()">
						<i class="fas fa-chart-pie"></i> Calculate Projection
					</button>
					<div class="result">
						<div class="result-label">Projected Dividend:</div>
						<div class="result-value" id="dividend-result">₱0.00</div>
					</div>
				</div>
			</div>
		</main>
	</section>

	<script src="../js/kebab.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/dropdown_profile.js"></script>
</body>
</html>

<style>
	.share-capital {
		display: flex;
		align-items: baseline;
		margin-bottom: 20px;
	}

	@media (max-width: 768px) {
		#content main .head-title .left h1 {
			font-size: 35px;
			text-align: left;
		}
	}

	@media (max-width: 480px) {
		#content main .head-title .left h1 {
			font-size: 35px;
			text-align: left;
		}

		.amount h2 {
			font-size: 1.8rem;
		}
	}
	.calcu,
.balance-details {
  cursor: pointer;
  color: var(--light);
}

</style>
