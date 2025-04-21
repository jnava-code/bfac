<?php
  include "../config/db.php";
  include "../auth/session.php"; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/shares.css">
  <link rel="stylesheet" href="../css/livestock.css">
  <title>Expenses Management</title>
</head>

<body>
  <?php include "admin_components/admin_sidebar.php"; ?>

  <section id="content">
    <?php include "admin_components/admin_navbar.php"; ?>

    <main>
      <div class="head-title">
        <div class="left">
          <h1 id="page-title">Expense Management</h1>
          <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class="bx bx-chevron-right"></i></li>
            <li><a class="active" href="#">Expenses</a></li>
          </ul>
        </div>
      </div>

      <ul class="box-info">
				<li style="width: fit-content;">
          <a href="" style="text-decoration: none; color: inherit;">
            <i class="fa-solid fa-peso-sign"></i>
            <span class="text">
              <h3 id="total_expenses"></h3>
              <p> Total Expenses</p>
            </span>
          </a>
        </li>
      </ul>
      <!-- add expense -->
      <div class="table-data">
        <div class="order">
          <div class="head">
            <h3>Add Expense</h3>
          </div> 

		   <div class="form-group">
          <label for="expenseCategory">Category</label>
          <select id="expenseCategory" required>
            <option value="">Select Category</option>
            <option value="Feeding">Feeding</option>
		        <option value="Payroll">Payroll</option>
            <option value="Others">Others</option>
          </select>
        </div>
        <div class="form-group">
          <label for="selectUser">User</label>
          <select name="user" id="expenseUser" required>
            <option value="">Select User</option>
            <?php
              $sql = "SELECT * FROM user_members WHERE is_archived = 0 AND status = 'Approved'";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['member_id']}'>{$row['first_name']} {$row['last_name']}</option>";
              }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="expenseAmount">Amount (₱)</label>
          <input type="number" id="expenseAmount" placeholder="Enter amount" required>
        </div>
        <div class="form-group">
          <label for="expenseDate">Date</label>
          <input type="date" id="expenseDate" required>
        </div>
        <div class="form-group">
          <label for="expenseDescription">Description</label>
          <textarea id="expenseDescription" placeholder="Enter description" required></textarea>
        </div>
        <div class="form-group">
          <label for="expenseYear">Year</label>
          <input type="number" id="expenseYear" placeholder="e.g. 2025" required>
        </div>
        <div class="form-group">
          <button type="submit" id="expenseSubmit">Submit</button>
        </div>
      </div> 
    </div>

      <div class="table-data">
        <div class="order">
          <div class="head">
            <h3>List of Expenses</h3>
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
          </div>
          <table>
            <thead>
              <tr>
                <th>Category</th>
                <th>Amount (₱)</th>
                <th>Date</th>
                <th>Description</th>
                <th>Year</th>
              </tr>
            </thead>
            <tbody id="expensesTable"></tbody>
          </table>
        </div>
      </div>
    </main>
  </section>

  <script>
    // Handle form submission
    if (document.getElementById("expenseSubmit")) {
  document.getElementById("expenseSubmit").addEventListener("click", function (e) {
    e.preventDefault();

    const categoryEl = document.getElementById("expenseCategory");
    const userEl = document.getElementById("expenseUser");
    const amountEl = document.getElementById("expenseAmount");
    const dateEl = document.getElementById("expenseDate");
    const descriptionEl = document.getElementById("expenseDescription");
    const yearEl = document.getElementById("expenseYear");

    const category = categoryEl.value;
    const user = userEl.value;
    const amount = amountEl.value;
    const date = dateEl.value;
    const description = descriptionEl.value;
    const year = yearEl.value;

    const expenseData = new FormData();
    expenseData.append("category", category);
    expenseData.append("user", user);
    expenseData.append("amount", amount);
    expenseData.append("date", date);
    expenseData.append("description", description);
    expenseData.append("year", year);

    fetch('../api/post/add_expense.php', {
      method: 'POST',
      body: expenseData
    })
      .then(response => response.json())
      .then(data => {
        console.log(data);

        if (data.status === 'success') {
          // Optional: Close modal if you use Bootstrap or similar
          // document.getElementById("expenseModal").classList.remove("show");

          // Clear the form inputs properly
          categoryEl.value = "";
          userEl.value = "";
          amountEl.value = "";
          dateEl.value = "";
          descriptionEl.value = "";
          yearEl.value = "";

          fetchExpensesData();
        } else {
          alert('Error adding expense: ' + data.message);
        }
      });
  });
}
    
    function fetchExpensesData() {
      const expensesTable = document.getElementById('expensesTable');
      fetch('../api/get/read_expenses.php')
        .then(response => response.json())
        .then(data => {
          expensesTable.innerHTML = '';
          document.getElementById('total_expenses').innerText = '₱' + parseFloat(data.total).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });

          if(data.expenses && data.expenses.length > 0) {
            data.expenses.forEach(expense => {
              const expensesHTML = `
              <tr>
                <td>${expense.category}</td>
                <td>₱${parseFloat(expense.amount).toFixed(2)}</td>
                <td>${expense.expense_date}</td>
                <td>${expense.description}</td>
                <td>${expense.year}</td>
              </tr>
              `;
              expensesTable.insertAdjacentHTML('beforeend', expensesHTML);
            });
          } else {
            expensesTable.innerHTML = '<tr><td colspan="5">No expenses found.</td></tr>';
            
          }
        })
    }

    fetchExpensesData();
  </script>

  <script src="../js/script.js"></script>
  <script src="../js/dropdown_profile.js"></script>


  <script>
    // This script runs when the page is loaded
    window.onload = function() {
      // Get the expenses value from the page (find the <h3> tag under the 'Total Expenses' section)
      const expensesElement = document.querySelector('ul.box-info li span h3');
      const expenses = parseFloat(expensesElement.innerText.replace('₱', '').replace(',', ''));
  
      // Store it in localStorage for use in other pages
      localStorage.setItem('expenses', expenses);
    };
  </script>
  
</body>

</html>
