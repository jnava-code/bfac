<?php
  include "../config/db.php";
  include "../auth/session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dividend History</title>
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
          <button class="view-btn" onclick="window.location.href='div.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
        </div>
        <table>
          <thead>
                <tr>
                  <th>Member Name</th>
                  <th>Dividend Amount (₱)</th>
                  <th>Receipt Number</th>
                  <th>Date & Time</th>
                </tr>
          </thead>
          <tbody id="dividendsTransactionHistory">
          </tbody>
        </table>
      </div>
    </div>
  </main>
</section>
<script>
    const dividendsTransactionHistory = document.getElementById('dividendsTransactionHistory');
    const yearFilter = document.getElementById('year-filter');

    const currentYear = new Date().getFullYear();
    yearFilter.value = currentYear;

    const renderDividends = (dividends, filterYear) => {
        dividendsTransactionHistory.innerHTML = "";

        const filteredDividends = filterYear
            ? dividends.filter(dividend => {
                const saleYear = new Date(dividend.calculation_date).getFullYear();
                return saleYear == filterYear;
            })
            : dividends;
        if (filteredDividends.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" style="text-align: center;">No dividends found.</td>`;
            dividendsTransactionHistory.appendChild(row);
            return;
        }

        filteredDividends.forEach(dividend => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${dividend.first_name} ${dividend.middle_name} ${dividend.last_name}</td>
                <td>${dividend.dividend_amount}</td>
                <td>${dividend.receipt}</td>
                <td>${dividend.calculation_date}</td>
            `;
            dividendsTransactionHistory.appendChild(row);
        });
    };

    fetch('../api/get/read_dividend_only.php')
        .then(response => response.json())
        .then(data => {
            renderDividends(data, currentYear);

            yearFilter.addEventListener("change", (e) => {
                const selectedYear = e.target.value;
                renderDividends(data, selectedYear);
            });
        });

</script>
<script src="../js/script.js"></script>
<script src="../js/dropdown_profile.js"></script>

</body>
</html>
