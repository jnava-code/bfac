<?php
	include "../config/db.php";
	include "../auth/session.php";

	$sql_user = "SELECT * FROM admin_accounts WHERE is_archived = 1";
  $result_user = mysqli_query($conn, $sql_user);
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
	<title>Admins</title>

</head>
<body>

	<?php include "admin_components/admin_sidebar.php"; ?>

	<section id="content">
		<?php include "admin_components/admin_navbar.php"; ?>

		<main>
			<div class="head-title">
				<div class="left">
					<h1>Admins</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a href="#">Admin</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Archive</a></li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List of Admins</h3>
						<button class="view-btn" onclick="window.location.href='admin.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
					</div>
					<table>
						<thead>
							<tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php 						
								if($result_user && mysqli_num_rows($result_user) > 0) {
									while($row = mysqli_fetch_assoc($result_user)) {
										echo "<tr id='admin_row_" . $row['user_id'] . "'>";
										echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
										echo "<td>" . htmlspecialchars($row['username']) . "</td>";
										echo "<td class='email'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>
                    <button class='icon-edit' onclick=\"restorePost('" . addslashes($full_name) . "', " . $row['user_id'] . ")\">
                        <i class='bx bx-refresh'></i>
                    </button>
                    <button class='icon-delete' onclick=\"deletePost('" . addslashes($full_name) . "', " . $row['user_id'] . ")\">
                        <i class='bx bxs-trash'></i>
                    </button>
                </td>";
                
										echo "</tr>";
									}
								} else {
									echo "<tr><td colspan='9'>No archived users found.</td></tr>";
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
  function restorePost(title, adminId) {
  Swal.fire({
    title: 'Restore Admin?',
    text: `"${title}" will be moved back to active list of admins.`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, restore it!',
  }).then((result) => {
    if (result.isConfirmed) {
      const restoreData = new FormData();
      restoreData.append("id", adminId);

      fetch("../api/update/restore_admin.php", {
        method: 'POST',
        body: restoreData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === "success") {
          Swal.fire('Restored!', `"${title}" has been restored.`, 'success');
          const row = document.getElementById(`admin_row_${adminId}`);
          if (row) row.remove();
        } else {
          Swal.fire('Error', data.message || 'Restore failed.', 'error');
        }
      });
    }
  });
}

function deletePost(title, adminId) {
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
      deleteData.append("id", adminId);
      
      fetch("../api/delete/delete_admin.php", {
        method: 'POST',
        body: deleteData
      })
      .then(response => response.json())
      .then(data => { 
        if (data.status === "success") {
          Swal.fire('Deleted!', `"${title}" has been removed.`, 'success');
          const row = document.getElementById(`admin_row_${adminId}`);
          if (row) row.remove();
        } else {
          Swal.fire('Error', data.message || 'Delete failed.', 'error');
        }
      });
    }
  });
}

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

</script>  
	<!-- // <script src="../js/kebab.js"></script> -->
	<script src="../js/script.js"></script>
    <!-- // <script src="../js/dropdown_profile.js"></script> -->
</body>
</html>