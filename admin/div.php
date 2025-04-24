<?php
  include "../config/db.php";
  include "../auth/session.php";
  // Calculate total sales amount
  $total_query = "
  SELECT SUM(asales.amount) AS total_sales
  FROM admin_sales AS asales
  WHERE YEAR(asales.purchase_date) = YEAR(CURDATE())
  ";

  $total_result = mysqli_query($conn, $total_query);
  $total_row = mysqli_fetch_assoc($total_result);
  $total_sales = $total_row['total_sales'] ?? 0;

  $totalQuery = "SELECT SUM(amount) AS total_amount FROM admin_expenses WHERE YEAR(expense_date) = YEAR(CURDATE())";
  $totalResult = mysqli_query($conn, $totalQuery);
  $totalRow = mysqli_fetch_assoc($totalResult);

  $total_expenses = $totalRow['total_amount'] ?? 0;

  $total_share = "SELECT SUM(share_capital) AS share_capital_count FROM admin_shares_list WHERE YEAR(created_at) = YEAR(CURDATE())";
  $total_share_result = mysqli_query($conn, $total_share);
  $total_share_row = mysqli_fetch_assoc($total_share_result);
  $total_share_capital = $total_share_row['share_capital_count'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dividend Management</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">

  <style>
    :root {
      --poppins: 'Poppins', sans-serif;
      --lato: 'Lato', sans-serif;
      --light: #F9F9F9;
      --blue: #3C91E6;
      --light-blue: #CFE8FF;
      --grey: #eee;
      --dark-grey: #AAAAAA;
      --dark: #342E37;
      --yellow: #FD7238;
      --light-yellow: #ffe6c6;
      --orange: #FD7238;
      --light-red: #ffd3d3;
      --light-green: #3b693459;
      --green: #3b6934;
      --dark-green: #31572b;
      --red: #bd0000;
      --dark-red: #9a0101;
    }

    .modal1 {
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      visibility: hidden;
      opacity: 0;
    }

    .modal1.show {
      visibility: visible;
      opacity: 1;
    }

    .modal-livestock {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      width: 50%;
      max-width: 600px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      max-height: 90vh;
      overflow-y: auto;
      position: relative;
    }

    .modal-livestock .close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 16px;
      background: none;
      border: none;
      cursor: pointer;
      color: #333;
    }

    #withdrawForm, #sendToSharesForm {
      display: grid;
      gap: 20px;
      width: 100%;
      box-sizing: border-box;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    .form-group label {
      font-size: 16px;
      margin-bottom: 5px;
    }

    .form-group input,
    .form-group button {
      padding: 10px;
      font-size: 1rem;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    .form-group button {
      background-color: var(--green);
      color: white;
      border: none;
      cursor: pointer;
    }

    .form-group button:hover {
      background-color: var(--dark-green);
    }

    .btn-danger {
      background-color: var(--red);
    }

    .btn-danger:hover {
      background-color: var(--dark-red);
    }

    @media screen and (max-width: 768px) {
      .modal-livestock {
        width: 90%;
        padding: 15px;
      }
    }

    .table-data .order table th,
    .table-data .order table td {
      padding: 12px 15px;
      border: 1px solid #ddd;
    }

    .result {
      margin-top: 20px;
      font-weight: bold;
      text-align: center;
      font-size: 18px;
    }
  </style>
</head>
<body>

    <!-- SIDEBAR -->
    <?php include "admin_components/admin_sidebar.php"; ?>

    <section id="content">
      <?php include "admin_components/admin_navbar.php"; ?>
        <main>
            <div class="head-title">
                <div class="left">
                    <h1 id="page-title">Dividend Management</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#" id="current-page">Dividend</a></li>
                    </ul>
                </div>
            </div>

              
              <div class="table-data">
                <div class="div">
                  <div class="head">
                    <h3>Dividend Computation</h3>
                  </div>
                  <table>
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th>Amount (₱)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr><td>Gross Income</td><td>₱<?php echo number_format($total_sales); ?></td></tr>
                      <tr><td>Total Expenses</td><td>₱<?php echo number_format($total_expenses); ?></td></tr>
                      <tr><td><strong>Net Income</strong></td><td><strong>₱<?php echo number_format($total_sales - $total_expenses)?></strong></td></tr>
                      <tr><td>Statutory Funds (30%)</td><td>₱<?php echo number_format(($total_sales - $total_expenses) * 0.30); ?>                      </td></tr>
                      <tr><td><strong>Net Surplus (Dividends Available)</strong></td><td><strong>₱<?php echo number_format(($total_sales - $total_expenses) - (($total_sales - $total_expenses) * 0.30))?></strong></td></tr>
                      <tr><td>Total Share Capital</td><td>₱<?php echo number_format($total_share_capital * 100); ?></td></tr>
                      <tr><td>Total Number of Shares</td><td><?php echo number_format($total_share_capital); ?></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
              
              <div class="table-data">
                <div class="order">
                  <div class="head">
                    <h3>List of Dividends</h3>

                    <button class="view-btn" onclick="window.location.href='transaction_div.php';">Transaction History</button>
                  </div>
                  <table>
                    <thead>
                      <tr>
                        <th>Member Name</th>
                        <th>Total Contribution (₱)</th>
                        <th>Dividend Amount (₱)</th>
                        <th>Dividend Amount Left</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="dividend-table-body">
                      <!-- Populated by JavaScript -->
                    </tbody>
                  </table>
                </div>
              </div>
              
              <!-- Withdraw Modal -->
              <div class="modal1" id="withdrawModal">
                <div class="modal-livestock">
                  <button class="close" onclick="closeModal()">&times;</button>
                  <h2>Withdraw Funds</h2>
                  <form id="withdrawForm">
                    <input type="hidden" id="modalMemberId" disabled>
                    <div class="form-group">
                      <label for="modalMemberName">Member:</label>
                      <input type="text" id="modalMemberName" disabled>
                    </div>
                    <div class="form-group">
                      <label for="totalContribution">Total Contribution (₱):</label>
                      <input type="text" id="totalContribution" disabled>
                    </div>
                    <div class="form-group">
                      <label for="withdrawAmount">Amount to Withdraw (₱):</label>
                      <input type="number" id="withdrawAmount" placeholder="Enter amount to withdraw" required>
                    </div>
                    <div class="form-group">
                      <label for="receiptNumber">Receipt Control Number:</label>
                      <input type="text" id="receiptNumber" placeholder="Enter control number" required>
                    </div>
                    <div class="form-group">
                      <button type="button" onclick="confirmWithdrawal()">Confirm Withdrawal</button>
                    </div>
                  </form>
                </div>
              </div>
              
              <!-- Send to Shares Modal -->
              <div class="modal1" id="sendToSharesModal">
                <div class="modal-livestock">
                  <button class="close" onclick="closeSendToSharesModal()">&times;</button>
                  <h2>Allocate to Share Capital</h2>
                  <form id="sendToSharesForm">
                  <input type="hidden" id="shareMemberId" disabled>
                    <div class="form-group">
                      <label for="shareMemberName">Member:</label>
                      <input type="text" id="shareMemberName" disabled>
                    </div>
                    <div class="form-group">
                      <label for="availableDividend">Available Dividend:</label>
                      <input type="text" id="availableDividend" disabled>
                    </div>
                    <div class="form-group">
                      <label for="shareCapitalShares">Share Capital:</label>
                      <input type="number" id="shareCapitalShares" placeholder="Enter share capital" required>
                    </div>
                    <div class="form-group">
                      <label for="allocateAmountShares">Amount to Allocate (₱):</label>
                      <input type="number" id="allocateAmountShares" placeholder="Enter amount to allocate" readonly>
                    </div>
                    <div class="form-group">
                      <label for="receiptNumberShares">Receipt Control Number:</label>
                      <input type="text" id="receiptNumberShares" placeholder="Enter control number" required>
                    </div>
                    <div class="form-group">
                      <button type="submit" onclick="confirmShareCapital()">Allocate to Share Capital</button>
                    </div>
                  </form>
                </div>
              </div>
              
              <!-- JavaScript -->
              <script>
                document.getElementById("shareCapitalShares").addEventListener('input', (e) => {
                  const value = e.target.value;
                  const amount = value * 100;
                  document.getElementById("allocateAmountShares").value = amount;
                  
                })
                function updateDividendTable() {
                  const tbody = document.getElementById('dividend-table-body');
                  tbody.innerHTML = '';
                  
                  fetch('../api/get/read_dividend.php')
                    .then(response => response.json())
                    .then(data => {
                      if(data && data.length === 0) {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td colspan="5" style="text-align: center;">No data available</td>`;
                        tbody.appendChild(row);
                        return;
                      } else {
                        data.forEach(member => {
                          const totalSales = member.total_sales
                          const totalExpenses = member.total_expenses;
                          
                          const netIncome = totalSales - totalExpenses;
                          const statutoryFunds = netIncome * 0.30;
                          
                          const netSurplus = netIncome - statutoryFunds;
                          const perDividend = netSurplus / member.all_total_share_capital;
                          const total_dividend = perDividend * member.total_share_capital;

                          if(member.total_paid_up_share_capital != 0) {
                            const fullName = `${member.first_name} ${member.middle_name} ${member.last_name}`.replace(/'/g, "\\'");
                            const withdrawBtnHTML = `
                              <button class="btn small" onclick="openModal(
                                '${fullName}',
                                '${Math.round(total_dividend)}',
                                '${member.member_id}'
                              )">Withdraw</button>
                            `;  
                            const sendShareHTML = `
                              <button class="btn small" onclick="openSendToSharesModal(
                                '${fullName}',
                                '${Math.round(total_dividend) - Math.round(member.total_dividend)}',
                                '${member.member_id}'
                              )">Send Share Capital</button>
                            `;  
                            const row = document.createElement('tr');
                            row.innerHTML = `
                              <td>${member.first_name} ${member.middle_name} ${member.last_name}</td>
                              <td>${formatCurrencyPHP(member.total_paid_up_share_capital)}</td>
                              <td>${formatCurrencyPHP(Math.round(total_dividend))}</td>
                              <td>${formatCurrencyPHP(Math.round(total_dividend) - Math.round(member.total_dividend))}</td>
                              <td>
                                ${withdrawBtnHTML}   
                                ${sendShareHTML}    
                              </td>
                            `;
                            tbody.appendChild(row);
                          } else {
                            const row = document.createElement('tr');
                            row.innerHTML = '';
                            tbody.appendChild(row);
                          }
                        });
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

                function openModal(memberName, amountLeft, member_id) {
                  document.getElementById('modalMemberId').value = member_id;
                  document.getElementById('modalMemberName').value = memberName;
                  document.getElementById('totalContribution').value = `₱${amountLeft}`;
                  document.getElementById('withdrawModal').style.display = "flex";
                  setTimeout(() => document.getElementById('withdrawModal').classList.add('show'), 10);
                }
              
                function closeModal() {
                  document.getElementById('withdrawModal').classList.remove('show');
                  setTimeout(() => document.getElementById('withdrawModal').style.display = "none", 300);
                }
              
                function confirmWithdrawal() {
                  const memberId = document.getElementById('modalMemberId').value;
                  const amount = document.getElementById('withdrawAmount').value;
                  const receipt = document.getElementById('receiptNumber').value;
              
                  if (amount && receipt) {
                    const dividendData = new FormData();
                    dividendData.append('member_id', memberId);
                    dividendData.append('dividend_amount', amount);
                    dividendData.append('receipt', receipt);

                    fetch('../api/post/add_dividend.php', {
                      method: 'POST',
                      body: dividendData
                    }).then(response => {
                        return response.json();
                    }).then(data => {
                      if (data.status === 'success') {
                        closeModal();
                        updateDividendTable()
                        document.getElementById('withdrawAmount').value = "";
                        document.getElementById('receiptNumber').value = "";
                      } else {
                        alert(data.message);
                      }
                    })
                  } else {
                    alert("Please fill in all the fields.");
                  }
                }
              
                function openSendToSharesModal(name, dividend, member_id) {
                  document.getElementById('shareMemberId').value = member_id;
                  document.getElementById("shareMemberName").value = name;
                  document.getElementById("availableDividend").value = `₱${dividend}`;
                  document.getElementById("sendToSharesModal").style.display = "flex";
                  setTimeout(() => document.getElementById("sendToSharesModal").classList.add("show"), 10);
                }
              
                function closeSendToSharesModal() {
                  document.getElementById("sendToSharesModal").classList.remove("show");
                  setTimeout(() => document.getElementById("sendToSharesModal").style.display = "none", 300);
                } 

                function confirmShareCapital() {
                  const memberId = document.getElementById('shareMemberId').value;
                  const shareCapitalShares = document.getElementById("shareCapitalShares").value;
                  const allocateAmount = document.getElementById('allocateAmountShares').value;
                  const receipt = document.getElementById('receiptNumberShares').value;
                  
                  if (allocateAmount && receipt) {
                    const dividendData = new FormData();
                    dividendData.append('member_id', memberId);
                    dividendData.append('shares', shareCapitalShares);
                    dividendData.append('dividend_amount', allocateAmount);
                    dividendData.append('receipt', receipt);

                    fetch('../api/post/allocate_share.php', {
                      method: 'POST',
                      body: dividendData
                    }).then(response => {
                        return response.json();
                    }).then(data => {
                      if (data.status === 'success') {
                        closeSendToSharesModal();
                        updateDividendTable();
                        document.getElementById('allocateAmountShares').value = "";
                        document.getElementById('receiptNumberShares').value = "";
                      } else {
                        alert(data.message);
                      }
                    })
                  } else {
                    alert("Please fill in all the fields.");
                  }
                  
                }
                updateDividendTable();
                
              </script>
              
              <script src="../js/script.js"></script>
              <script src="../js/dropdown_profile.js"></script>
</body>
</html>
