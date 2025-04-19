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
                      <tr><td>Gross Income</td><td>₱905,520</td></tr>
                      <tr><td>Total Expenses</td><td>₱700,000</td></tr>
                      <tr><td><strong>Net Income</strong></td><td><strong>₱205,520</strong></td></tr>
                      <tr><td>Statutory Funds (30%)</td><td>₱61,656</td></tr>
                      <tr><td><strong>Net Surplus (Dividends Available)</strong></td><td><strong>₱143,864</strong></td></tr>
                      <tr><td>Total Share Capital</td><td>₱600,000</td></tr>
                      <tr><td>Total Number of Shares</td><td>6,000</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
              
              <div class="table-data">
                <div class="order">
                  <div class="head">
                    <h3>List of Dividends</h3>
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
                    <button class="view-btn" onclick="window.location.href='transaction_div.html';">Transaction History</button>
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
                    <div class="form-group">
                      <label for="shareMemberName">Member:</label>
                      <input type="text" id="shareMemberName" disabled>
                    </div>
                    <div class="form-group">
                      <label for="availableDividend">Available Dividend:</label>
                      <input type="text" id="availableDividend" disabled>
                    </div>
                    <div class="form-group">
                      <label for="allocateAmount">Amount to Allocate (₱):</label>
                      <input type="number" id="allocateAmount" placeholder="Enter amount to allocate" required>
                    </div>
                    <div class="form-group">
                      <label for="receiptNumberShares">Receipt Control Number:</label>
                      <input type="text" id="receiptNumberShares" placeholder="Enter control number" required>
                    </div>
                    <div class="form-group">
                      <button type="submit">Allocate to Share Capital</button>
                    </div>
                  </form>
                </div>
              </div>
              
              <!-- JavaScript -->
              <script>
                const netSurplus = 143864;
                const totalShares = 120;
                const dividendPerShare = netSurplus / totalShares;
              
                const members = [
                  { name: 'Pedro Ramirez', contribution: 50000, memberShares: 12 },
                  { name: 'Juan Dela Cruz', contribution: 100000, memberShares: 10 },
                ];
              
                function updateDividendTable() {
                  const tbody = document.getElementById('dividend-table-body');
                  tbody.innerHTML = '';
              
                  members.forEach(member => {
                    const dividendPerMember = member.memberShares * dividendPerShare;
              
                    const row = document.createElement('tr');
                    row.innerHTML = `
                      <td>${member.name}</td>
                      <td>₱${member.contribution.toLocaleString()}</td>
                      <td>₱${dividendPerMember.toLocaleString()}</td>
                      <td>₱${dividendPerMember.toLocaleString()}</td>
                      <td>

                        <button class="btn small" onclick="openModal('${member.name}', '${dividendPerMember}')">Withdraw</button>
                      </td>
                    `;
                    tbody.appendChild(row);
                  });
                }
              
                function openModal(memberName, amountLeft) {
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
                  const amount = document.getElementById('withdrawAmount').value;
                  const receipt = document.getElementById('receiptNumber').value;
              
                  if (amount && receipt) {
                    alert(`Successfully withdrawn ₱${amount} with receipt number: ${receipt}`);
                    closeModal();
                    window.location.href = "transaction_div.html";
                  } else {
                    alert("Please fill in all the fields.");
                  }
                }
              
                function openSendToSharesModal(name, dividend) {
                  document.getElementById("shareMemberName").value = name;
                  document.getElementById("availableDividend").value = `₱${dividend}`;
                  document.getElementById("sendToSharesModal").style.display = "flex";
                  setTimeout(() => document.getElementById("sendToSharesModal").classList.add("show"), 10);
                }
              
                function closeSendToSharesModal() {
                  document.getElementById("sendToSharesModal").classList.remove("show");
                  setTimeout(() => document.getElementById("sendToSharesModal").style.display = "none", 300);
                }
              
                const intercept = 20;
                const slope = 0.1;
              
                function calculateDividend() {
                  const capital = parseFloat(document.getElementById('capital').value);
                  if (isNaN(capital) || capital < 0) {
                    document.getElementById('result').textContent = "Please enter a valid share capital amount.";
                    return;
                  }
                  const dividend = intercept + (slope * capital);
                  document.getElementById('result').textContent = `Predicted Dividend: ₱${dividend.toFixed(2)}`;
                }
              
                function calculateSampleDividends() {
                  const samples = [500, 1000, 2000];
                  samples.forEach((capital, index) => {
                    const dividend = intercept + (slope * capital);
                    const el = document.getElementById(`sample${index + 1}`);
                    if (el) el.textContent = `₱${dividend.toFixed(2)}`;
                  });
                }
              
                window.onload = function () {
                  updateDividendTable();
                  calculateSampleDividends();
                };
              </script>
              
              <script src="../js/script.js"></script>
              <script src="../js/dropdown_profile.js"></script>
</body>
</html>
