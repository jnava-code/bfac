<?php 
    include "../config/db.php"; 
    include "../auth/session.php";

    $sql = "SELECT SUM(amount) AS total_gross FROM admin_sales";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_gross = $row['total_gross'] ? $row['total_gross'] : 0;
    $total_gross = number_format($total_gross, 2, '.', ',');
    $total_gross = "₱" . $total_gross;
?>

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
    <?php include "admin_components/admin_navbar.php"; ?>

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
              <h3 id="total_sales"></h3>
              <p>Gross Income</p>
            </span>
          </a>
        </li>
      </ul>

      <div class="table-data">
        <div class="order">
          <div class="head">
            <h3>List of Sales</h3>
            <button class="view-btn-add" id="openSalesModal"><i class="bx bx-plus"></i></button>
            <button class="view-btn" onclick="window.location.href='transaction_sales.php';">Transaction History</button>
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
              </tr>
            </thead>
            <tbody id="incomeTableBody"></tbody>
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
        <!-- <input type="text" id="customerName" placeholder="Enter customer name" required /> -->
        <select id="customerName" required>
          <option value="" selected disabled>Select Customer</option>
          <?php
            // Fetch customer names from the database
            $query = "SELECT * FROM user_members WHERE is_archived = 0 AND is_verified = 1";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $fullname = $row['middle_name'] == "" ? $row['first_name'] . " " . $row['last_name'] : $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];
                echo "<option value='" . $row['member_id'] . "'>" . $fullname . "</option>";
              }
            } else {
              echo "<option value=''>No customers found</option>";
            }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" id="productName" placeholder="Enter product name" required />
      </div>
      <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" placeholder="Enter quantity" required />
      </div>
      <!-- <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" placeholder="Enter address" required />
      </div> -->
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
        <!-- <label for="address">Address</label> -->
        <input type="hidden"/>
      </div>
      <div class="form-group">
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>

  <script src="../js/script.js"></script>
  <script src="../js/dropdown_profile.js"></script>
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
    // const address = document.getElementById("address").value;
    const price = document.getElementById("price").value;
    const receiptNo = document.getElementById("receiptNo").value;
    const purchaseDate = document.getElementById("purchaseDate").value;

    const salesData = new FormData();
    salesData.append("orderNo", orderNo);
    salesData.append("customerId", customerName);
    salesData.append("productName", productName);
    salesData.append("quantity", quantity);
    salesData.append("price", price);
    salesData.append("receiptNo", receiptNo);
    salesData.append("purchaseDate", purchaseDate);

    fetch("../api/post/add_sales.php", {
      method: "POST",
      body: salesData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status == "success") {
          fetchSalesData();
          document.getElementById("salesForm").reset();
        }
      })
  });

  const incomeTableBody = document.getElementById("incomeTableBody");

  function fetchSalesData() {
    fetch(`../api/get/read_sales.php`)
      .then((response) => response.json())
      .then((data) => {
        incomeTableBody.innerHTML = ""; // Clear existing rows
        document.getElementById('total_sales').innerText = '₱' + parseFloat(data.total_sales).toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });

        if(data.sales && data.sales.length > 0) {
          data.sales.forEach((item) => {
            const salesHTML = `<tr>
                <td>${item.sales_no}</td>
                <td>${item.first_name} ${item.last_name}</td>
                <td>${item.description}</td>
                <td>${item.quantity}</td>
                <td>${item.address}</td>
                <td>₱${item.amount}</td>
                <td>${item.receipt_no}</td>
              </tr>
            `;
            incomeTableBody.insertAdjacentHTML("beforeend", salesHTML);
          });
        } else {
          incomeTableBody.innerHTML = "<tr><td colspan='9'>No sales data available</td></tr>";
        }
      })
  }

  fetchSalesData();
</script>
