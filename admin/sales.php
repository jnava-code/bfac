<?php 
    include "../config/db.php"; 
    include "../auth/session.php";
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
            <div class="menu-container">
              <i class="bx bx-dots-vertical" id="kebabMenu"></i>
              <div class="dropdown-menu" id="dropdownMenu">
                  <ul>
                      <li><a href="archive_sale.php">Archive</a></li>
                  </ul>
              </div>
          </div>
          </div>
          <table>
            <thead>
              <tr>
                <th>Order No.</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price (₱)</th>
                <th>Receipt Control Number</th>
                <th>Action</th>
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
        <label for="productName">Product Name</label>
        <input type="text" id="productName" placeholder="Enter product name" required />
      </div>
      <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" placeholder="Enter quantity" required />
      </div>
      <div class="form-group">
        <label for="Price">Unit Price</label>
        <input type="number" id="unitprice" placeholder="Enter Unit Price" required />
      </div>
      <!-- <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" placeholder="Enter address" required />
      </div> -->
      <div class="form-group">
        <label for="price">Price (₱)</label>
        <input type="number" id="price" placeholder="Enter price" readonly required />
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

  const quantity = document.getElementById("quantity");
  const unitprice = document.getElementById("unitprice");
  const price = document.getElementById("price");

  function calculatePrice() {
    const qty = parseFloat(quantity.value);
    const unit = parseFloat(unitprice.value);

    if (!isNaN(qty) && !isNaN(unit)) {
      price.value = (qty * unit).toFixed(2); // 2 decimal places
    } else {
      price.value = ''; // Clear if inputs are invalid
    }
  }

  quantity.addEventListener("input", calculatePrice);
  unitprice.addEventListener("input", calculatePrice);

  // Handle form submission
  document.getElementById("salesForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const productName = document.getElementById("productName").value;
    const quantity = document.getElementById("quantity").value;
    const unitprice = document.getElementById("unitprice").value;
    const price = document.getElementById("price").value;
    const receiptNo = document.getElementById("receiptNo").value;
    const purchaseDate = document.getElementById("purchaseDate").value;

    const salesData = new FormData();
    salesData.append("productName", productName);
    salesData.append("quantity", quantity);
    salesData.append("unitprice", unitprice);
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
          document.getElementById("salesModal").classList.remove("show");
        } else {
          alert(data.message);
        }
      })
  });

  const incomeTableBody = document.getElementById("incomeTableBody");

  function fetchSalesData() {
    fetch(`../api/get/read_sales.php`)
      .then((response) => response.json())
      .then((data) => {
        incomeTableBody.innerHTML = "";
        document.getElementById('total_sales').innerText = '₱' + parseFloat(data.total_sales).toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });

        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        
        const filteredData = data.sales.filter(sale => {
          const salesDate = new Date(sale.purchase_date);
          const salesYear = salesDate.getFullYear();

          return salesYear === currentYear;
        });

        if(filteredData && filteredData.length > 0) {
          filteredData.forEach((sale) => {
            
            const salesHTML = `<tr>
                <td>${sale.sales_no}</td>
                <td>${sale.description}</td>
                <td>${sale.quantity}</td>
                <td>${formatCurrencyPHP(sale.amount)}</td>
                <td>${sale.receipt_no}</td>
                <td><button class="bx bxs-archive icon-archive" id="archive_sale_${sale.id}"></button></td>
              </tr>
            `;
            incomeTableBody.insertAdjacentHTML("beforeend", salesHTML);

            archiveSales();
          });
        } else {
          incomeTableBody.innerHTML = "<tr><td colspan='9'>No sales data available</td></tr>";
        }
      })
  }

  function formatCurrencyPHP(amount) {
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2
        }).format(amount);
    }

  function archiveSales() {
    const archiveButtons = document.querySelectorAll("[id^='archive_sale_']");

    archiveButtons.forEach(button => {
        if (!button.classList.contains("listener-added")) {
            button.classList.add("listener-added");

            button.addEventListener("click", function (e) {
                e.preventDefault();
                const saleId = this.id.split("_")[2];

                const confirmArchive = confirm("Are you sure you want to archive this sale?");
                if (confirmArchive) {
                    const archiveData = new FormData();
                    archiveData.append("id", saleId);
                    fetch("../api/post/archive_sale.php", {
                        method: 'POST',
                        body: archiveData
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    }).then(data => {
                        if (data.status == "success") {
                            fetchSalesData();
                            return;
                        }
                    })
                }
            });
        }
    });
}


  fetchSalesData();
</script>

<script src="../js/kebab.js"></script>
    <!-- <script src="../js/script.js"></script> -->
    <script src="../js/dropdown_profile.js"></script>
