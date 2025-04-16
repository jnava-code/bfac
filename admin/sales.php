<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/livestock.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/shares.css" />
  <title>Sales Management</title>
</head>

<body>
<?php include "admin_components/admin_sidebar.php"; ?>

  <section id="content">
    <nav>
      <i class="bx bx-menu"></i>
      <form action="#">
        <div class="form-input">
          <input type="search" placeholder="Search..." />
          <button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
        </div>
      </form>
      <input type="checkbox" id="switch-mode" hidden />
      <label for="switch-mode" class="switch-mode"></label>
      <a href="notif.html" class="notification">
        <i class="bx bxs-bell"></i><span class="num">8</span>
      </a>
      <div class="profile-dropdown">
        <a href="#" class="profile"><img src="img/admin.png" alt="Profile" /></a>
        <ul class="dropdown-menu">
          <li><a href="profile.html">Edit Profile</a></li>
        </ul>
      </div>
    </nav>

    <main>
      <div class="head-title">
        <div class="left">
          <h1 id="page-title">Sales Management</h1>
          <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class="bx bx-chevron-right"></i></li>
            <li><a class="active" href="#">Sales Management</a></li>
          </ul>
        </div>
      </div>
      <ul class="box-info">
				<li style="width: fit-content;">
          <a href="" style="text-decoration: none; color: inherit;">
            <i class="fa-solid fa-peso-sign"></i>
            <span class="text">
              <h3>₱905,520</h3>
              <p>Gross Income</p>
            </span>
          </a>
        </li>
      </ul>


    
      <div class="table-data">
        <div class="order">
          <div class="head">
            <h3>List of Sales</h3>

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
            <button class="view-btn-add" id="openSalesModal"><i class="bx bx-plus"></i></button>

          </div>
          <table>
            <thead>
              <tr>
                <th>Order No.</th>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Address</th>
                <th>Price (₱)</th>
                <th>Receipt Control Number</th>
                <th>Purchase Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <!-- <tbody id="incomeTableBody"></tbody> -->
          </table>
        </div>
      </div>
    </main>
  </section>
 <!-- Sales Modal -->
<div class="modal1" id="salesModal">
  <div class="modal-livestock">
    <button class="close" id="closeSalesModal">&times;</button>
    <h2>Add Sale</h2>
    <form id="salesForm">
      <div class="form-group">
        <label for="orderNo">Order No.</label>
        <input type="text" id="orderNo" placeholder="e.g. 10001" required />
      </div>
      <div class="form-group">
        <label for="customerName">Customer Name</label>
        <input type="text" id="customerName" placeholder="Enter customer name" required />
      </div>
      <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" id="productName" placeholder="Enter product name" required />
      </div>
      <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" placeholder="Enter quantity" required />
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" placeholder="Enter address" required />
      </div>
      <div class="form-group">
        <label for="price">Price (₱)</label>
        <input type="number" id="price" placeholder="Enter price" required />
      </div>
    
      <div class="form-group">
        <label for="receiptNo">Receipt Control Number</label>
        <input type="text" id="receiptNo" placeholder="Enter receipt number" required />
      </div>
      <div class="form-group">
        <label for="purchaseDate">Purchase Date</label>
        <input type="date" id="purchaseDate" required />
      </div>
      <div class="form-group">
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>

  <script src="js/script.js"></script>
  <script src="js/dropdown_profile.js"></script>
  <script>
    // This script runs when the page is loaded
    window.onload = function() {
      // Get the gross income value from the page (find the <h3> tag under the 'Gross Income' section)
      const grossIncomeElement = document.querySelector('ul.box-info li span h3');
      const grossIncome = parseFloat(grossIncomeElement.innerText.replace('₱', '').replace(',', ''));
  
      // Store it in localStorage for use in other pages
      localStorage.setItem('grossIncome', grossIncome);
    };
  </script>
  
</body>
</html>
<script>
  // Open modal
  document.getElementById("openSalesModal").addEventListener("click", function () {
    document.getElementById("salesModal").classList.add("show");
  });

  // Close modal
  document.getElementById("closeSalesModal").addEventListener("click", function () {
    document.getElementById("salesModal").classList.remove("show");
  });

  // Handle form submission
  document.getElementById("salesForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const orderNo = document.getElementById("orderNo").value;
    const customerName = document.getElementById("customerName").value;
    const productName = document.getElementById("productName").value;
    const quantity = document.getElementById("quantity").value;
    const address = document.getElementById("address").value;
    const price = document.getElementById("price").value;
    const receiptNo = document.getElementById("receiptNo").value;
    const purchaseDate = document.getElementById("purchaseDate").value;

    const tableBody = document.querySelector(".table-data table tbody") || document.createElement("tbody");
    const newRow = document.createElement("tr");
    newRow.innerHTML = `
      <td>${orderNo}</td>
      <td>${customerName}</td>
      <td>${productName}</td>
      <td>${quantity}</td>
      <td>${address}</td>
      <td>₱${parseFloat(price).toFixed(2)}</td>
      <td>${receiptNo}</td>
      <td>${purchaseDate}</td>
      <td><button class="action-btn">Edit</button></td>
    `;
    tableBody.appendChild(newRow);

    // If <tbody> was missing, append it to the table
    if (!document.querySelector(".table-data table tbody")) {
      document.querySelector(".table-data table").appendChild(tableBody);
    }

    document.getElementById("salesModal").classList.remove("show");
    this.reset();
  });
</script>
