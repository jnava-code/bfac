<?php
  include "../config/db.php";
  include "../auth/session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Share History</title>
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
        <h1>Shares Transaction History</h1>
        <ul class="breadcrumb">
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#">User</a></li>
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
          <button class="view-btn" onclick="window.location.href='shares.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
        </div>
        <table>
          <thead>
            <tr>
              <th>Member Name</th>
              <th>Paid-up Share Capital</th>
              <th>Shares</th>
            </tr>
          </thead>
          <tbody id="sharesTransactionHistory">
          </tbody>
        </table>
      </div>
    </div>
  </main>
</section>

<script>
    const sharesTransactionHistory = document.getElementById('sharesTransactionHistory');
    const yearFilter = document.getElementById('year-filter');

    const currentYear = new Date().getFullYear();
    yearFilter.value = currentYear;

    const renderShares = (share, filterYear) => {
        sharesTransactionHistory.innerHTML = "";      
            
        if (share.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" style="text-align: center;">No shares found.</td>`;
            sharesTransactionHistory.appendChild(row);
            return;
        }
        
        share.forEach(shar => {
          const filteredShares = filterYear
          ? shar.shares.filter(sh => {
                const shareDate = new Date(sh.created_at);
                const shareYear = shareDate.getFullYear();
                return shareYear == filterYear;
              })
          : share.shares;

          if (filteredShares.length === 0) return;
          
          let totalPaidUp = 0;
          let totalShareCap = 0;

          totalPaidUp = filteredShares.reduce((sum, s) => sum + parseFloat(s.paid_up_share_capital), 0);
          totalShareCap = filteredShares.reduce((sum, s) => sum + parseFloat(s.share_capital), 0);
          
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${shar.first_name} ${shar.middle_name} ${shar.last_name}</td>
                ${(() => {
                  return `<td>${formatCurrencyPHP(totalPaidUp)}</td>
                        <td>${totalShareCap}</td>`;
                })()}
            `;
            sharesTransactionHistory.appendChild(row);    
        });
    };

    function formatCurrencyPHP(amount) {
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2
        }).format(amount);
    }

    fetch('../api/get/read_share_list.php')
        .then(response => response.json())
        .then(data => {
            const shares = data;    
            renderShares(shares, currentYear);

            yearFilter.addEventListener("change", (e) => {
                const selectedYear = e.target.value;
                renderShares(shares, selectedYear);
            });
        });

</script>
<script src="../js/script.js"></script>
<script src="../js/dropdown_profile.js"></script>

</body>
</html>
