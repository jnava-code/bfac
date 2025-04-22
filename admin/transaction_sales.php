<?php
  include "../config/db.php";
  include "../auth/session.php";

  $sql_share = "SELECT 
    *
    FROM admin_sales AS asales
    WHERE DATE(asales.purchase_date) < CURDATE()
    ";

    $result_share = mysqli_query($conn, $sql_share);

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
        <h1>Sales Transaction History</h1>
        <ul class="breadcrumb">
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#">Shares</a></li>
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
          <button class="view-btn" onclick="window.location.href='sales.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
        </div>
        <table>
          <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price (₱)</th>
                    <th>Receipt Control Number</th>
                    <th>Purchase Date</th>
                </tr>
          </thead>
          <tbody id="archiveTableBody">
            <?php
              if ($result_share && mysqli_num_rows($result_share) > 0) {
                while ($row = mysqli_fetch_assoc($result_share)) {
                  $id = $row['id'];
            ?>
              <tr id="share_row_<?php echo $id; ?>">
              <td><?php echo htmlspecialchars($row['sales_no']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td>₱<?php echo htmlspecialchars($row['amount']); ?></td>
                <td><?php echo htmlspecialchars($row['receipt_no']); ?></td>
                <td><?php echo htmlspecialchars($row['purchase_date']); ?></td>
              </tr>
              <?php
                }
              } else {
                echo "<tr><td colspan='8'>No history sales found.</td></tr>";
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
