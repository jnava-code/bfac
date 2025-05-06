<!-- 360 limit share capital  -->
<?php 
    include "../config/db.php"; 
    include "../auth/session.php";
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/shares.css">
    <title>Share Management</title>
</head>

<body>

    <?php include "admin_components/admin_sidebar.php"; ?>

    <section id="content">
        <?php include "admin_components/admin_navbar.php"; ?>
        <main>
            <div class="head-title">
                <div class="left">
                    <h1 id="page-title">Share Management</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#" id="current-page">Shares</a></li>
                    </ul>
                </div>
            </div>

            <div id="message" class="success" style="display: none;"></div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>List of Shares</h3>

                        <button class="view-btn-add" id="openSharesModal"><i class='bx bx-plus'></i></button>
                        <button class="view-btn" onclick="window.location.href='transaction_share.php';">Transaction History</button>
                        <div class="menu-container">
                            <i class="bx bx-dots-vertical" id="kebabMenu"></i>
                            <div class="dropdown-menu" id="dropdownMenu">
                                <ul>
                                    <li><a href="archive_share.php">Archive</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Paid-up Share Capital</th>
                                <th>Shares</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody id="membersTableBody"></tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    
    <!-- Modal -->
    <div class="modal1" id="addSharesModal">
        <div class="modal-livestock">
            <button class="close" id="closeSharesModal">&times;</button>
            <h2>Add Shares</h2>
            <form id="sharesForm">
                <div class="form-group">
                    <label for="memberSelect">Select Member</label>
                    <?php 
                        $sql_member = "SELECT * FROM user_members WHERE status = 'Approved' AND is_archived = 0 AND is_verified = 1";
                        $result_member = mysqli_query($conn, $sql_member);
                        if ($result_member && mysqli_num_rows($result_member) > 0) {
                            echo '<select id="memberSelect" required>';
                            echo '<option value="" disabled selected>Select a member</option>';
                            while ($row = mysqli_fetch_assoc($result_member)) {
                                echo '<option value="' . $row['member_id'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
                            }
                            echo '</select>';
                        } else {
                            echo '<select id="memberSelect" required>';
                            echo '<option value="" disabled selected>No members available</option>';
                            echo '</select>';
                        }
                    ?>
                </div>
    
                <div class="form-group">
                    <label for="sharesInput">Number of Shares</label>
                    <input type="number" id="sharesInput" name="number_of_shares" placeholder="Enter number of shares" required oninput="updatePurchasePrice()">
                </div>
                <div class="form-group">
                    <label for="purchaseInput">Purchase Amount</label>
                    <input type="text" id="purchasePrice" name="purchase_amount" placeholder="Auto-calculated" readonly>
                </div>
                
                <div class="form-group">
                    <label for="receiptInput">Receipt Control Number</label>
                    <input type="number" id="receiptNumber" name="receipt_control_number" placeholder="Enter control number">
                </div>
                
    
                <div class="form-group">
                    <button type="button" onclick="addTransaction()">Add Shares</button>
                </div>
            </form>
        </div>
    </div>

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
    display: none; /* Ensure modal is hidden initially */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;  /* Centers modal horizontally */
    align-items: center;      /* Centers modal vertically */
    padding: 10px;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    visibility: hidden; /* Initially hidden */
    opacity: 0;
}

.modal-livestock {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    width: 50%;
    max-width: 600px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow-y: auto;
    transition: transform 0.3s ease-in-out;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #333;
}

#sharesForm {
    display: grid;
    grid-template-columns: 1fr;
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 5px;
}

.form-group input, .form-group select, .form-group button {
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-top: 5px;
}

.form-group button {
    background-color: var(--green);
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: fit-content;
}

.form-group button:hover {
    background-color: var(--dark-green);
}

@media screen and (max-width: 768px) {
    .modal-livestock {
        width: 90%;
        padding: 15px;
    }
}

.modal1.show {
    visibility: visible;
    opacity: 1;
}

.modal-livestock.show {
    transform: scale(1);
}

.modal1 {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  align-items: center;
  justify-content: center;
}
.modal-expenses {
  background: white;
  padding: 20px;
  border-radius: 10px;
  width: 400px;
}
.form-group {
  margin-bottom: 10px;
}
#newCategoryGroup {
  margin-top: 10px;
}
#newCategoryInput,
#categoryInput {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-top: 5px;
}

.menu-container {
  position: relative;
  display: inline-block;
}
.dropdown-menu {
  display: none;
  position: absolute;
  right: 0; top: 100%;
  background: white;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  width: 200px;
}
.dropdown-menu ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
.dropdown-menu li {
  padding: 10px;
}
.dropdown-menu a {
  text-decoration: none;
  color: #333;
  display: block;
}
.dropdown-menu a:hover {
  background-color: #f0f0f0;
}
.filter-year {
    position: relative;
    /* top: 30px; */
    /* right: 20px; */
    /* background-color: #fff; */
    padding: 10px;
    /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
    border-radius: 5px;
    /* z-index: 1000; */
    display: flex
;
    align-items: flex-end;
    flex-direction: column;
}

.filter-year label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.filter-year .form-control {
    width: 150px;
    padding: 8px; 
    border: 1px solid #ddd; 
    border-radius: 4px; 
}


    </style>
  
   <script>
        // Fix the modal references
        const modal = document.getElementById("addSharesModal");
        const openModalButton = document.getElementById("openSharesModal");
        const closeModalButton = document.getElementById("closeSharesModal");

        // Initially, hide the modal
        modal.style.display = "none";

        // Show the modal with a smooth transition when the "Add Shares" button is clicked
        openModalButton.onclick = function () {
            modal.classList.add("show");
            setTimeout(() => { modal.style.display = "flex"; }, 300);
        };

        // Hide the modal with a smooth transition when the close button is clicked
        closeModalButton.onclick = function () {
            modal.classList.remove("show");
            setTimeout(() => { modal.style.display = "none"; }, 300);
        };

        // Close the modal if the user clicks outside of it
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.classList.remove("show");
                setTimeout(() => { modal.style.display = "none"; }, 300);
            }
        };

        const sharePrice = 100;  // Par value for each share
        const members = {};

        // Update the purchase price field based on the shares input
        function updatePurchasePrice() {
            const shares = parseFloat(document.getElementById("sharesInput").value);
            if (!isNaN(shares) && shares > 0) {
                const purchasePrice = shares * sharePrice;
                document.getElementById("purchasePrice").value = `₱${purchasePrice.toFixed(2)}`;
            } else {
                document.getElementById("purchasePrice").value = '';
            }
        }

        // Add the transaction when the button is clicked
        function addTransaction() {
            const memberName = document.getElementById("memberSelect").value;
            const shares = parseFloat(document.getElementById("sharesInput").value);
            const purchasePrice = shares * sharePrice;
            const receiptNumber = document.getElementById("receiptNumber").value;
            // const contractAmount = document.getElementById("contractAmount").value;

            // Validate the input fields
            if (isNaN(shares) || shares <= 0) {
                alert("Please enter a valid number of shares.");
                return;
            }

            if (!receiptNumber) {
                alert("Please enter a valid receipt control number.");
                return;
            }
            // if (!contractAmount) {
            //     alert("Please enter a valid contract amount.");
            //     return;
            // }

            const confirmAdd = confirm(`You are about to add ${shares} shares to ${memberName}.\nPurchase Price: ₱${purchasePrice.toFixed(2)}\nReceipt Control Number: ${receiptNumber}\nAre you sure?`);
            if (confirmAdd) {
                const memberSelect = document.getElementById("memberSelect");
                const sharesInput = document.getElementById("sharesInput");
                const purchasePrice = document.getElementById("purchasePrice");
                const receiptNumber = document.getElementById("receiptNumber");
                let rawValue = purchasePrice.value;
                let numeric = parseFloat(rawValue.replace(/[^\d.]/g, ''));
                let wholeNumber = Math.floor(numeric);
                
                const sharesData = new FormData();
                sharesData.append("memberSelect", memberSelect.value);
                sharesData.append("sharesInput", sharesInput.value);
                sharesData.append("purchasePrice", wholeNumber);
                sharesData.append("receiptNumber", receiptNumber.value);

                fetch("../api/post/add_share.php", {
                    method: 'POST',
                    body: sharesData
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                }).then(data => {
                    if(data.status == "success") {
                        // Close the modal after the success message
                        modal.style.display = "none";

                        // Reset the form fields
                        document.getElementById("sharesInput").value = "";
                        document.getElementById("purchasePrice").value = "";
                        document.getElementById("receiptNumber").value = "";
                        // document.getElementById("contractAmount").value = "";

                        updateTable();
                    } else {
                        alert(data.message);
                    }
                })                
            } else {
                alert("Cancelled. No changes were made.");
            }
        }

        function updateTable() {
            const tbody = document.getElementById("membersTableBody");
            if (tbody) tbody.innerHTML = "";

            fetch("../api/get/read_share_list.php")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {        
                    if (data && data.length > 0) {
                        let shareHTML = '';

                        data.forEach(share => {
                            const fullName = share.middle_name === ""
                                ? `${share.first_name} ${share.last_name}`
                                : `${share.first_name} ${share.middle_name} ${share.last_name}`;

                            let totalPaidUp = 0;
                            let totalShareCap = 0;

                            if (share.shares && share.shares.length > 0) {
                                const currentDate = new Date();
                                const currentYear = currentDate.getFullYear();
                                
                                const filteredData = share.shares.filter(item => {
                                    const shareDate = new Date(item.created_at);
                                    const shareYear = shareDate.getFullYear();
                                    
                                    return shareYear === currentYear;
                                });
                                
                                if(filteredData.length === 0) return;
                                
                                totalPaidUp = filteredData.reduce((sum, s) => sum + parseFloat(s.paid_up_share_capital), 0);
                                totalShareCap = filteredData.reduce((sum, s) => sum + parseFloat(s.share_capital), 0);
                            }
                            
                            shareHTML += `
                                <tr>
                                    <td>${fullName}</td>
                                    <td>${formatCurrencyPHP(totalPaidUp)}</td>
                                    <td>${totalShareCap}</td>
                                    <td><button class="bx bxs-archive icon-archive" id="archive_share_${share.member_id}"></button></td>
                                </tr>`;
                        });

                        if (tbody) tbody.innerHTML = shareHTML;

                        archiveShares();
                    } else {
                        const noDataHTML = `<tr><td colspan="4" style="text-align: center;">No Shares Available</td></tr>`;
                        if (tbody) tbody.innerHTML = noDataHTML;
                    }
                });
        }

        function formatCurrencyPHP(amount) {
            return new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2
            }).format(amount);
        }

        function archiveShares() {
            const archiveButtons = document.querySelectorAll("[id^='archive_share_']");
            
            if(archiveButtons) {
                archiveButtons.forEach(button => {
                    button.addEventListener("click", function(e) {
                        e.preventDefault();
                        const shareId = this.id.split("_")[2];
                        
                        const confirmArchive = confirm("Are you sure you want to archive this share?");
                        if(confirmArchive) {
                            const archiveData = new FormData();
                            archiveData.append("id", shareId);
                            fetch("../api/post/archive_share.php", {
                                method: 'POST',
                                body: archiveData
                            }).then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            }).then(data => {
                                if(data.status == "success") {
                                    updateTable();
                                    return;
                                }
                            })
                        }
                    });
                });
            }
        }
        
        updateTable();

   </script>
    <script src="../js/kebab.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/dropdown_profile.js"></script>
</body>

</html>