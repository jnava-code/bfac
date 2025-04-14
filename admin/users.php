<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/livestock.css">

	<title>Users</title>

</head>
<body>

	<section id="sidebar">
		<a href="#" class="brand">
			<img src="img/logo.png" alt="Logo" class="logo">
			<div class="text">
				<span class="title">BFAC Hub</span>
				<span class="subtitle">Management System</span>
			</div>
		</a>
		<ul class="side-menu top">
			<li><a href="users.html"><i class="bx bxs-user"></i><span class="text">Users</span></a></li>
			<li><a href="shares.html"><i class="bx bxs-coin-stack"></i><span class="text">Shares</span></a></li>
			<li><a href="div.html"><i class="bx bx-line-chart-down"></i><span class="text">Dividends</span></a></li>
			<li><a href="sales.html"><i class='bx bxs-credit-card-alt'></i><span class="text">Sales </span></a></li>
			<li><a href="expenses.html"><i class='bx bxs-coin-stack' ></i><span class="text">Expenses </span></a></li>
			</ul>
    <ul class="side-menu">
        <li><a href="settings.html"><i class="bx bxs-cog"></i><span class="text">Settings</span></a></li>
        <li><a href="logout.html" class="logout"><i class="bx bxs-log-out-circle"></i><span class="text">Logout</span></a></li>
      </ul>
	</section>

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
			  <i class="bx bxs-bell"></i>
			  <span class="num">8</span>
			</a>
			<div class="profile-dropdown">
			  <a href="#" class="profile"><img src="img/admin.png" alt="Profile" /></a>
			</div>
		  </nav>

		<main>
			<div class="head-title">
				<div class="left">
					<h1>Users</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Users</a></li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>User's Registration Approval</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Username</th>
								<th>User Profile</th>
								<th>First Name</th>
								<th>Middle Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Address</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							 <tr>
								<td>johndoe123</td>
								<td><img src="img/people.png" width="40"></td>
								<td>John</td>
								<td>A.</td>
								<td>Doe</td>
								<td>john@example.com</td>
								<td>09171234567</td>
								<td>Makati City</td>
								<td>2024-06-12</td>
								<td>
									<i class="bx bx-check icon-accept"></i>
									<i class="bx bx-x icon-reject"></i>
								</td>
							</tr>
							<!--<tr> 
								 <td>janedoe456</td>
								<td><img src="img/people.png" width="40"></td>
								<td>Jane</td>
								<td>B.</td>
								<td>Doe</td>
								<td>jane@example.com</td>
								<td>09179876543</td>
								<td>Quezon City</td>
								<td>2024-07-01</td>
								<td>
									<i class="bx bx-check icon-accept"></i>
									<i class="bx bx-x icon-reject"></i>
								</td> 
							</tr>-->
						</tbody>
					</table>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List of Users</h3>
						<div class="menu-container">
                            <i class="bx bx-dots-vertical" id="kebabMenu"></i>
                            <div class="dropdown-menu" id="dropdownMenu">
                                <ul>
                                    <li><a href="archive_user.html">Archive</a></li>
                                </ul>
                            </div>
                        </div>
					</div>
					<table>
						<thead>
							<tr>
								<th>Username</th>
								<th>User Profile</th>
								<th>First Name</th>
								<th>Middle Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Address</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>

								<td></td>

								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>
									<i class="bx bxs-edit icon-edit"></i>
									<i class="bx bxs-archive icon-archive"></i>
								</td>
							</tr>
							<tr>
								
								
							</tr> 
						</tbody>
					</table>
				</div>
			</div>

		</main>
	</section>



	<!-- Edit User Status Modal -->
<div id="editStatusModal" class="modal1">
	<div class="modal-livestock">
	  <button class="close" id="closeStatusModal">&times;</button>
	  <h2>Edit User Status</h2>
	  <form id="editUserStatusForm">
		<div class="form-group">
		  <label>Name</label>
		  <input type="text" id="modalUserName" readonly>
		</div>
		<div class="form-group">
		  <label>Position on Board</label>
		  <input type="text" id="modalUserPosition" readonly>
		</div>
		<div class="form-group">
		  <label for="userStatus">Status</label>
		  <select id="userStatus" required>
			<option value="active">Active</option>
			<option value="inactive">Inactive</option>
		  </select>
		</div>
		<div class="form-group" style="grid-column: span 2;">
		  <button type="submit">Save</button>
		</div>
	  </form>
	</div>
  </div>
<script>
	document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("editStatusModal");
  const closeModal = document.getElementById("closeStatusModal");
  const form = document.getElementById("editUserStatusForm");

  // Open modal on edit icon click
  document.querySelectorAll(".icon-edit").forEach(icon => {
    icon.addEventListener("click", function () {
      const row = this.closest("tr");
      const name = row.children[0].textContent;
      const position = row.children[1].textContent;
      const status = row.children[2].textContent.trim().toLowerCase();

      document.getElementById("modalUserName").value = name;
      document.getElementById("modalUserPosition").value = position;
      document.getElementById("userStatus").value = status;

      modal.classList.add("show");
    });
  });

  // Close modal
  closeModal.addEventListener("click", () => modal.classList.remove("show"));
  window.addEventListener("click", e => {
    if (e.target === modal) modal.classList.remove("show");
  });

  // Handle form submission
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    
    // Optional: update status live in the table
    const name = document.getElementById("modalUserName").value;
    const newStatus = document.getElementById("userStatus").value;

    document.querySelectorAll("table tbody tr").forEach(row => {
      if (row.children[0].textContent === name) {
        row.children[2].innerHTML = `<span class='status ${newStatus}'>${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}</span>`;
      }
    });

    modal.classList.remove("show");
  });
});

</script>  
	<script src="js/kebab.js"></script>
	<script src="js/script.js"></script>
    <script src="sj/script/dropdown_profile.js"></script>
</body>
</html>