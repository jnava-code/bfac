<?php
  include "../config/db.php";
  include "../auth/session.php";

  $sql_share = "
    SELECT 
        ashares.id,
        ashares.member_id,
        ashares.update_at,
        ashares.is_archived,
        SUM(asl.paid_up_share_capital) AS total_paid_up_share_capital,
        SUM(asl.share_capital) AS total_share_capital,
        asl.receipt_number,
        um.first_name,
        um.middle_name,
        um.last_name,
        um.role
    FROM admin_shares AS ashares
    LEFT JOIN admin_shares_list asl ON asl.member_id = ashares.member_id
    LEFT JOIN user_members um ON um.member_id = ashares.member_id
    WHERE ashares.is_archived = 0 AND DATE(asl.created_at) < CURDATE()
    GROUP BY 
        ashares.member_id,
        ashares.update_at,
        ashares.is_archived,
        um.first_name,
        um.middle_name,
        um.last_name
	ORDER BY asl.created_at ASC
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
        <h1>Shares Transaction History</h1>
        <ul class="breadcrumb">
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#">User</a></li>
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
                    <option value="" disabled>Select Year</option>
                    <?php
                    $currentYear = date('Y');
                    for ($year = $currentYear; $year >= 2023; $year--) {
                        $selected = ($year == $currentYear) ? 'selected' : '';
                        echo "<option value=\"$year\" $selected>$year</option>";
                    }
                    ?>
                </select>
            </div>
          <button class="view-btn" onclick="window.location.href='shares.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
        </div>
        <table>
          <thead>
            <tr>
              <th>Member Name</th>
              <th>Paid-up Share Capital</th>
              <th>Shares</th>
              <th>Date & Time</th>
            </tr>
          </thead>
          <tbody id="sharesTransactionHistory">
          </tbody>
        </table>
      </div>
    </div>
  </main>
</section>

<script>
    const sharesTransactionHistory = document.getElementById('sharesTransactionHistory');
    const yearFilter = document.getElementById('year-filter');

    const currentYear = new Date().getFullYear();
    yearFilter.value = currentYear;

    const renderShares = (shares, filterYear) => {
        sharesTransactionHistory.innerHTML = "";
        const filteredShares = filterYear
            ? shares.filter(sale => {           
                const saleYear = new Date(sale.created_at).getFullYear();         
                return saleYear == filterYear;
            })
            : shares;
            
        if (filteredShares.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" style="text-align: center;">No shares found.</td>`;
            sharesTransactionHistory.appendChild(row);
            return;
        }

        filteredShares.forEach(sale => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${sale.first_name} ${sale.middle_name} ${sale.last_name}</td>
                <td>${sale.total_paid_up_share_capital}</td>
                <td>${sale.total_share_capital}</td>
                <td>${sale.created_at}</td>
            `;
            sharesTransactionHistory.appendChild(row);
        });
    };

    fetch('../api/get/read_share.php')
        .then(response => response.json())
        .then(data => {
            const shares = data;        
            renderShares(shares, currentYear);

            yearFilter.addEventListener("change", (e) => {
                const selectedYear = e.target.value;
                renderShares(shares, selectedYear);
            });
        });

</script>
<script src="../js/script.js"></script>
<script src="../js/dropdown_profile.js"></script>

</body>
</html>
