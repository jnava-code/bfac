<?php
  include "../config/db.php";
  include "../auth/session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Expenses History</title>
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../css/style.css"/>
  <link rel="stylesheet" href="../css/shares.css">
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
        <h1>Expenses Transaction History</h1>
        <ul class="breadcrumb">
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#">Expenses</a></li>
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
          <button class="view-btn" onclick="window.location.href='expenses.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
        </div>
        <table>
          <thead>
                <th>Category</th>
                <th>Amount (₱)</th>
                <th>Date</th>
                <th>Description</th>
                <th>Year</th>
          </thead>
          <tbody id="expensesTransactionHistory">
          </tbody>
        </table>
      </div>
    </div>
  </main>
</section>

<script>
    const expensesTransactionHistory = document.getElementById('expensesTransactionHistory');
    const yearFilter = document.getElementById('year-filter');

    const currentYear = new Date().getFullYear();
    yearFilter.value = currentYear;

    const renderExpenses = (expenses, filterYear) => {
        expensesTransactionHistory.innerHTML = "";

        const filteredExpenses = filterYear
            ? expenses.filter(expense => {
                const saleYear = new Date(expense.expense_date).getFullYear();
                return saleYear == filterYear;
            })
            : expenses;
        if (filteredExpenses.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" style="text-align: center;">No expenses found.</td>`;
            expensesTransactionHistory.appendChild(row);
            return;
        }

        filteredExpenses.forEach(expense => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${expense.category}</td>
                <td>${expense.amount}</td>
                <td>${expense.expense_date}</td>
                <td>${expense.description}</td>
                <td>${expense.year}</td>
            `;
            expensesTransactionHistory.appendChild(row);
        });
    };

    fetch('../api/get/read_expenses.php')
        .then(response => response.json())
        .then(data => {
            const expenses = data.expenses;
            renderExpenses(expenses, currentYear);

            yearFilter.addEventListener("change", (e) => {
                const selectedYear = e.target.value;
                renderExpenses(expenses, selectedYear);
            });
        });

</script>

<script src="../js/script.js"></script>
<script src="../js/dropdown_profile.js"></script>

</body>
</html>
