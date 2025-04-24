<?php
  include "../config/db.php";
  include "../auth/session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sales History</title>
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
                </tr>
          </thead>
          <tbody id="salesTransactionHistory">
          </tbody>
        </table>
      </div>
    </div>
  </main>
</section>

<script>
    const salesTransactionHistory = document.getElementById('salesTransactionHistory');
    const yearFilter = document.getElementById('year-filter');

    const currentYear = new Date().getFullYear();
    yearFilter.value = currentYear;

    const renderSales = (sales, filterYear) => {
        salesTransactionHistory.innerHTML = "";
        const filteredSales = filterYear
            ? sales.filter(sale => {
                const saleYear = new Date(sale.purchase_date).getFullYear();
                return saleYear == filterYear;
            })
            : sales;
        
        if (filteredSales.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" style="text-align: center;">No sales found.</td>`;
            salesTransactionHistory.appendChild(row);
            return;
        }

        filteredSales.forEach(sale => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${sale.sales_no}</td>
                <td>${sale.description}</td>
                <td>${sale.quantity}</td>
                <td>${formatCurrencyPHP(sale.amount)}</td>
                <td>${sale.receipt_no}</td>
            `;
            salesTransactionHistory.appendChild(row);
        });
    };

    function formatCurrencyPHP(amount) {
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2
        }).format(amount);
    }

    fetch('../api/get/read_sales.php')
        .then(response => response.json())
        .then(data => {
          console.log(data);
          
            const sales = data.sales;
            renderSales(sales, currentYear);

            yearFilter.addEventListener("change", (e) => {
                const selectedYear = e.target.value;
                console.log("selectedYear", selectedYear);
                
                renderSales(sales, selectedYear);
            });
        });

</script>
<script src="../js/script.js"></script>
<script src="../js/dropdown_profile.js"></script>

</body>
</html>
