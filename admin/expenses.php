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
              <h3>₱905,520</h3>
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
          <button type="submit">Submit</button>
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
            <tbody>
              <tr>
                <td>Groceries</td>
                <td>₱1,200</td>
                <td>2025-04-01</td>
                <td>Weekly grocery shopping</td>
                <td>2025</td>
              </tr>
              <tr>
                <td>Utilities</td>
                <td>₱3,500</td>
                <td>2025-04-05</td>
                <td>Electricity and water bills</td>
                <td>2025</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </section>

 

  <script>
    // Open modal
    if(document.getElementById("openExpenseModal")) {
      document.getElementById("openExpenseModal").addEventListener("click", function () {
        document.getElementById("expenseModal").classList.add("show");
      });
    }

    // Close modal
    if(document.getElementById("closeExpenseModal")) {
      document.getElementById("closeExpenseModal").addEventListener("click", function () {
        document.getElementById("expenseModal").classList.remove("show");
      });
    }

    // Handle form submission
    if(document.getElementById("expenseForm")) {
      document.getElementById("expenseForm").addEventListener("submit", function (e) {
        e.preventDefault();
  
        const category = document.getElementById("expenseCategory").value;
        const amount = document.getElementById("expenseAmount").value;
        const date = document.getElementById("expenseDate").value;
        const description = document.getElementById("expenseDescription").value;
        const year = document.getElementById("expenseYear").value;
  
        // Add to table (you can replace this logic with AJAX/fetch)
        const tableBody = document.querySelector(".table-data tbody");
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
          <td>${category}</td>
          <td>₱${parseFloat(amount).toFixed(2)}</td>
          <td>${date}</td>
          <td>${description}</td>
          <td>${year}</td>
        `;
        tableBody.appendChild(newRow);
  
        // Close modal
        document.getElementById("expenseModal").classList.remove("show");
  
        // Optional: Clear form
        this.reset();
      });
    }
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
