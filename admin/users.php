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
	// $result_approved = selectUsers($conn, 'Approved');

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
                                    <li><a href="archive_user.php">Archive</a></li>
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
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="approvedTable">
						</tbody>
					</table>
				</div>
			</div>

		</main>
	</section>

<script>

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

	function archiveUser(member_id) {
      const archiveUser = new FormData();
      archiveUser.append("member_id", member_id);

      fetch("../api/post/archive_user.php", {
        method: "POST",
        body: archiveUser
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            displayUser();
          } else {
            alert("Error archiving user: " + data.message);
          }
        });
    }

	function displayUser() {
		approvedTable.innerHTML = "";
		fetch("../api/get/read_users.php")
			.then(response => response.json())
			.then(data => {
				if(data.length === 0) {
					approvedTable.innerHTML = "<tr><td colspan='8'>No approved users found.</td></tr>";
					return;
				}

				data.forEach(user => {
					const row = document.createElement("tr");
					row.innerHTML = `
						<td>${user.first_name}</td>
						<td>${user.middle_name}</td>
						<td>${user.last_name}</td>
						<td class="email">${user.email}</td>
						<td class="phone">${user.phone}</td>
						<td>${user.address}</td>
						<td>${user.date_registered}</td>
						<td>
							<button class="bx bxs-archive icon-archive" 
								onclick="archiveUser(${user.member_id})">
							</button>
						</td>`;
					approvedTable.appendChild(row);
				});
			});
	}

	displayUser();
  // Close modal
//   closeModal.addEventListener("click", () => modal.classList.remove("show"));
//   window.addEventListener("click", e => {
//     if (e.target === modal) modal.classList.remove("show");
//   });

</script>  
	<script src="../js/kebab.js"></script>
	<script src="../js/script.js"></script>
    <script src="../js/dropdown_profile.js"></script>
</body>
</html>