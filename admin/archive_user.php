<?php
	include "../config/db.php";
	include "../auth/session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/livestock.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
						<li><a href="#">Users</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Archive</a></li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List of Users</h3>
						<button class="view-btn" onclick="window.location.href='users.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
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
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="userArchiveTable">
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


  function restorePost(title, userId) {
  Swal.fire({
    title: 'Restore User?',
    text: `"${title}" will be moved back to active list of users.`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, restore it!',
  }).then((result) => {
    if (result.isConfirmed) {
      const restoreData = new FormData();
      restoreData.append("member_id", userId);

      fetch("../api/update/restore_user.php", {
        method: 'POST',
        body: restoreData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === "success") {
          Swal.fire('Restored!', `"${title}" has been restored.`, 'success');
          displayArchiveUsers();
        } else {
          Swal.fire('Error', data.message || 'Restore failed.', 'error');
        }
      });
    }
  });
}

function deletePost(title, userId) {
  Swal.fire({
    title: 'Are you sure?',
    text: `This will permanently delete "${title}" from archive.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!',
    confirmButtonColor: '#d33'
  }).then((result) => {
    if (result.isConfirmed) {
      const deleteData = new FormData();
      deleteData.append("member_id", userId);
      
      fetch("../api/delete/delete_user.php", {
        method: 'POST',
        body: deleteData
      })
      .then(response => response.json())
      .then(data => { 
        if (data.status === "success") {
          Swal.fire('Deleted!', `"${title}" has been removed.`, 'success');
          displayArchiveUsers();
        } else {
          Swal.fire('Error', data.message || 'Delete failed.', 'error');
        }
      });
    }
  });
}

function displayArchiveUsers() {
  const tableBody = document.getElementById("userArchiveTable");
  tableBody.innerHTML = ""; // Clear existing rows

  fetch("../api/get/read_archive_users.php")
	.then(response => response.json())
	.then(data => {
	  if (data.length === 0) {
		tableBody.innerHTML = "<td colspan='7' style='text-align: center;'>No archived users found.</td>";
		return;
	  }
		
	  data.forEach(user => {
		const row = document.createElement("tr");
		const fullName = `${user.first_name} ${user.middle_name} ${user.last_name}`;
		row.innerHTML = `
		  <td>${user.first_name}</td>
		  <td>${user.middle_name}</td>
		  <td>${user.last_name}</td>
		  <td class="email">${user.email}</td>
		  <td class="phone">${user.phone}</td>
		  <td>${user.address}</td>
		  <td>
			<button class="icon-edit" onclick="restorePost('${fullName}', ${user.member_id})">
			  <i class='bx bx-refresh'></i>
			</button>
			<button class="icon-delete" onclick="deletePost('${fullName}', ${user.member_id})">
			  <i class='bx bxs-trash'></i>
			</button>
		  </td>`;
		tableBody.appendChild(row);
	  });
	})
}

displayArchiveUsers();
</script>  
	<!-- <script src="../js/kebab.js"></script> -->
	<script src="../js/script.js"></script>
    <script src="../js/dropdown_profile.js"></script>
</body>
</html>