<!-- 360 limit share capital  -->
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
            <!-- <ul class="box-info">
				<li style="width: fit-content;">
                        <a href="" style="text-decoration: none; color: inherit;">
                        <i class='bx bxs-coin-stack'></i>
                        <span class="text">
                            <h3>₱100</h3>
                            <p>Par value</p>
                        </span>
                        </a>
                    </li>
                </ul> -->
            <div id="message" class="success" style="display: none;"></div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>List of Shares</h3>

                        <button class="view-btn-add" id="openSharesModal"><i class='bx bx-plus'></i></button>
                        <button class="view-btn" onclick="window.location.href='transaction_share.html';">Transaction History</button>
                        <div class="menu-container">
                            <i class="bx bx-dots-vertical" id="kebabMenu"></i>
                            <div class="dropdown-menu" id="dropdownMenu">
                                <ul>
                                    <li><a href="archive_share.html">Archive</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Paid-up Share Capital</th>
                                <th>Share Capital</th>
                                <th>Action</th>  <!--archive button only -->

                            </tr>
                        </thead>
                        <!-- <tbody id="membersTableBody"></tbody> -->
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
                    <select id="memberSelect" required></select>
                </div>
    
                <div class="form-group">
                    <label for="sharesInput">Number of Shares</label>
                    <input type="number" id="sharesInput" placeholder="Enter number of shares" required oninput="updatePurchasePrice()">
                </div>
                <div class="form-group">
                    <label for="purchaseInput">Purchase Amount</label>
                    <input type="text" id="purchasePrice" placeholder="Auto-calculated" readonly>
                </div>
                
                <div class="form-group">
                    <label for="receiptInput">Receipt Control Number</label>
                    <input type="number" id="receiptNumber" placeholder="Enter control number" required>
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

// Initialize with 50 fake members
for (let i = 1; i <= 2; i++) {
    const name = `Member ${i}`;
    members[name] = {
        name,
        totalContribution: 0,
    };

    // Add to dropdown
    const option = document.createElement("option");
    option.value = name;
    option.textContent = name;
    document.getElementById("memberSelect").appendChild(option);
}

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
    const contractAmount = document.getElementById("contractAmount").value;

    // Validate the input fields
    if (isNaN(shares) || shares <= 0) {
        alert("Please enter a valid number of shares.");
        return;
    }

    if (!receiptNumber) {
        alert("Please enter a valid receipt control number.");
        return;
    }
    if (!contractAmount) {
        alert("Please enter a valid contract amount.");
        return;
    }

    const confirmAdd = confirm(`You are about to add ${shares} shares to ${memberName}.\nPurchase Price: ₱${purchasePrice.toFixed(2)}\nReceipt Control Number: ${receiptNumber}\nAre you sure?`);
    if (confirmAdd) {
        // Calculate the contribution based on the purchase price entered
        const contribution = shares * sharePrice;
        members[memberName].totalContribution += contribution;

        alert(`${memberName} added ${shares} shares (₱${contribution.toFixed(2)}). Updated successfully.`);

        // Close the modal after the success message
        modal.style.display = "none";

        // Reset the form fields
        document.getElementById("sharesInput").value = "";
        document.getElementById("purchasePrice").value = "";
        document.getElementById("receiptNumber").value = "";
        document.getElementById("contractAmount").value = "";

        updateTable();
    } else {
        alert("Cancelled. No changes were made.");
    }
}

// Function to update the table
function updateTable() {
    const tbody = document.getElementById("membersTableBody");
    if(tbody) tbody.innerHTML = "";

    Object.values(members).forEach(member => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${member.name}</td>
            <td>₱${member.totalContribution.toFixed(2)}</td>
            <td>${(member.totalContribution / sharePrice).toFixed(2)}</td>
        `;
        if(tbody) tbody.appendChild(tr);
    });
}

// Initial table population
updateTable();

   </script>
    <script src="../js/kebab.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/dropdown_profile.js"></script>
</body>

</html>