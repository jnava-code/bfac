<?php
	include "../config/db.php";
	include "../auth/session.php";

	if (isset($_POST['approve']) || isset($_POST['reject'])) {
		$action = isset($_POST['approve']) ? 'Approved' : 'Rejected';
		$member_id = $_POST['member_id'];

		$action = "'" . mysqli_real_escape_string($conn, $action) . "'";

		$sql = "UPDATE user_members SET status = $action WHERE member_id = '$member_id'";

		if (mysqli_query($conn, $sql)) {
			header("Location: users.php");
			exit();
		} else {
			echo "Error updating record: " . mysqli_error($conn);
		}
	}

	function selectUsers($conn, $status) {
		$sql = "SELECT * FROM user_members WHERE is_archived = 0 AND status = '$status' AND is_verified = 1";
		$result = mysqli_query($conn, $sql);
		return $result;
	}

	$result_pending = selectUsers($conn, 'Pending');
	$result_approved = selectUsers($conn, 'Approved');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/livestock.css">
	<style>
		.buttons_column {
			padding: 5px;
		}

		.buttons {
			display: flex;
			gap: 5px;
			justify-content: center;
			align-items: center;
		}

		button {
			background-color: transparent;
			border: none;
			cursor: pointer;
		}
	</style>
	<title>Users</title>

</head>
<body>

	<?php include "admin_components/admin_sidebar.php"; ?>

	<section id="content">
		<?php include "admin_components/admin_navbar.php"; ?>

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
							<?php 						
								if($result_pending && mysqli_num_rows($result_pending) > 0) {
									while($row = mysqli_fetch_assoc($result_pending)) {
										echo "<tr>";
										echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
										echo "<td>" . htmlspecialchars($row['middle_name']) . "</td>";
										echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
										echo "<td class='email'>" . htmlspecialchars($row['email']) . "</td>";
										echo "<td class='phone'>" . htmlspecialchars($row['phone']) . "</td>";
										echo "<td>" . htmlspecialchars($row['address']) . "</td>";
										echo "<td>" . htmlspecialchars($row['date_registered']) . "</td>";
										echo "<td class='buttons_column'>
											<div class='buttons'>
												<form method='POST'>
													<input type='hidden' name='member_id' value='" . $row['member_id'] . "'>
													<button type='submit' name='approve' class='btn btn-success'><i class='bx bx-check icon-accept'></i></button>
												</form>
												<form method='POST'>
													<input type='hidden' name='member_id' value='" . $row['member_id'] . "'>
													<button type='submit' name='reject' class='btn btn-success'><i class='bx bx-x icon-reject'></i></button>
												</form>
											</div>
										</td>";
										echo "</tr>";
									}
								} else {
									echo "<tr><td colspan='10'>No pending users found.</td></tr>";
								}							
							?>
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
								<th>First Name</th>
								<th>Middle Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Address</th>
								<th>Date Registered</th>
							</tr>
						</thead>
						<tbody>
							<?php 						
								if($result_approved && mysqli_num_rows($result_approved) > 0) {
									while($row = mysqli_fetch_assoc($result_approved)) {
										echo "<tr>";
										echo "<td>" . $row['first_name'] . "</td>";
										echo "<td>" . $row['middle_name'] . "</td>";
										echo "<td>" . $row['last_name'] . "</td>";
										echo "<td class='email'>" . $row['email'] . "</td>";
										echo "<td class='phone'>" . $row['phone'] . "</td>";
										echo "<td>" . $row['address'] . "</td>";
										echo "<td>" . $row['date_registered'] . "</td>";
										echo "</tr>";
									}
								} else {
									echo "<tr><td colspan='9'>No approved users found.</td></tr>";
								}
							?>
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
	const emails = document.querySelectorAll(".email");
	const phones = document.querySelectorAll(".phone");
	
	function maskEmail(email) {
		const [user, domain] = email.split('@');
		if (user.length <= 2) return email; 

		const first = user[0];
		const last = user[user.length - 1];
		const masked = first + '*'.repeat(user.length - 2) + last;
		return masked + '@' + domain;
	}

	function maskPhone(phone) {
		const digits = phone.replace(/\D/g, '');
		if (digits.length < 7) return phone;

		const start = digits.slice(0, 3);
		const end = digits.slice(-2);
		return start + '*****' + end;
	}

	emails.forEach(el => {
		el.textContent = maskEmail(el.textContent.trim());
	});

	phones.forEach(el => {
		el.textContent = maskPhone(el.textContent.trim());
	});

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
	<script src="../js/kebab.js"></script>
	<script src="../js/script.js"></script>
    <script src="../js/dropdown_profile.js"></script>
</body>
</html>