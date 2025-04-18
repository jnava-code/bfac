<?php include "../auth/session.php"; ?>
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
						<span>Dividend Balancee</span>
						<button class="info-btn">
							<i class='bx bxs-info-circle' ></i>
						</button>
						<div class="amount">
							<span>₱</span>
							<h2>245,750.00</h2>
						</div>
					</div>
				</a>
				<a href="user_share.html">
					<div class="balance-details">
						<div class="detail-item">
							<span>Shares Capital</span>
							<div class="share-capital">
								<span style="font-size: 28px;">₱</span>
								<strong>12000.00</strong>
							</div>
						</div>
						<div class="detail-item">
							<span>Share</span>
							<strong>120</strong>
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

	<!-- <script src="../js/kebab.js"></script> -->
	<script src="../js/script.js"></script>
	<!-- <script src="../js/dropdown_profile.js"></script> -->
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
