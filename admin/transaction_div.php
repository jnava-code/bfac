<?php
  include "../config/db.php";
  include "../auth/session.php";

  $sql_dividends = "
    SELECT 
        um.member_id,
        um.first_name,
        um.middle_name,
        um.last_name,
        ad.dividend_amount,
        ad.receipt,
        ad.calculation_date
    FROM user_members um
    LEFT JOIN admin_dividends ad ON ad.member_id = um.member_id
    WHERE um.is_archived = 0 AND um.is_verified = 1

";

	$result_dividends = mysqli_query($conn, $sql_dividends);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Share History</title>
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../css/style.css"/>
  <link rel="stylesheet" href="../css/modal.css"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php include "admin_components/admin_sidebar.php"; ?>

<section id="content">
  <?php include "admin_components/admin_navbar.php"; ?>

  <main>
    <div class="head-title">
      <div class="left">
        <h1>Dividend Transaction History</h1>
        <ul class="breadcrumb">
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#">Dividend</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#" class="active">Transaction History</a></li>
        </ul>
      </div>
    </div>

    <div class="table-data">
      <div class="db">
        <div class="head">
          <h3></h3>
          <div class="filter-year">
              <label for="year-filter">Filter by Year:</label>
              <select id="year-filter" class="form-control">
                <option value="">Select Year</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2020">2020</option>
              </select>
            </div>
          <button class="view-btn" onclick="window.location.href='div.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
        </div>
        <table>
          <thead>
                <tr>
				<th>Member Name</th>
					<th>Total Contribution (₱)</th>
					<th>Receipt</th>
					<th>Date & Time</th>
                </tr>
          </thead>
          <tbody id="archiveTableBody">
            <?php
              if ($result_dividends && mysqli_num_rows($result_dividends) > 0) {
                while ($row = mysqli_fetch_assoc($result_dividends)) {
                  $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
            ?>
              <tr id="share_row_<?php echo $id; ?>">
                <td><?php echo $full_name; ?></td>
                <td>₱<?php echo htmlspecialchars($row['dividend_amount']); ?></td>
                <td><?php echo htmlspecialchars($row['receipt']); ?></td>
                <td><?php echo htmlspecialchars($row['calculation_date']); ?></td>
              </tr>
              <?php
                }
              } else {
                echo "<tr><td colspan='8'>No history dividend found.</td></tr>";
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
