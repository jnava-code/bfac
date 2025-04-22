<?php 
  include "../config/db.php";
  include "../auth/session.php"; 

  if(isset($_POST['add_admin'])) {
      $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $role = mysqli_real_escape_string($conn, $_POST['role']);
      $password = '1234';
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
      $sql_add_user = "INSERT INTO admin_accounts (full_name, username, password, email, role) VALUES ('$full_name', '$username', '$hashedPassword', '$email', '$role')";
      
      if (mysqli_query($conn, $sql_add_user)) {
          echo "<script>alert('User added successfully!');</script>";
          header("Location: admin.php");
          exit();
      } else {
          echo "<script>alert('Error adding user: " . mysqli_error($conn) . "');</script>";
      }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/livestock.css">
  <title>Admin Dashboard</title>
</head>

<body>
  <!-- SIDEBAR -->
  <?php include "admin_components/admin_sidebar.php"; ?>

  <!-- CONTENT -->
  <section id="content">
    <?php include "admin_components/admin_navbar.php"; ?>

    <main>
      <div class="head-title">
        <div class="left">
          <h1 id="page-title">Admin Dashboard</h1>
          <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class="bx bx-chevron-right"></i></li>
            <li><a class="active" href="#">Admin</a></li>
          </ul>
        </div>
      </div>

      <div class="table-data">
        <div class="order">
          <div class="head">
            <h3>User Management</h3>
            <button class="view-btn-add" id="openUserModal"><i class="bx bx-plus"></i></button>
            <div class="menu-container">
                <i class="bx bx-dots-vertical" id="kebabMenu"></i>
                <div class="dropdown-menu" id="dropdownMenu">
                    <ul>
                        <li><a href="archive_admin.php">Archive</a></li>
                    </ul>
                </div>
            </div>
          </div>
          <table>
            <thead>
              <tr>
                <!-- <th>ID</th>
                <th>Profile</th> -->
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="adminTable">          
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </section>

 <!-- Add User Modal -->
<div id="userModal" class="modal1">
  <div class="modal-livestock">
    <button class="close" onclick="closeModal('userModal')">&times;</button>
    <form id="userForm" method="POST">
      <h2>Add User</h2>
      <div class="form-group">
        <label for="userFullName">Full Name</label>
        <input type="text" id="userFullName" name="full_name" required>
      </div>
      <div class="form-group">
        <label for="userName">Username</label>
        <input type="text" id="userName" name="username" required>
      </div>
      <div class="form-group">
        <label for="userEmail">Email</label>
        <input type="email" id="userEmail" name="email" required>
      </div>
      <div class="form-group">
        <label for="userRole">Role</label>
        <input type="text" id="userRole" name="role" value="Admin" required readonly>
        <!-- <select id="userRole" name="role" required>
          <option value="">Select Role</option>
          <option value="Admin">Admin</option>
          <option value="User">User</option>
        </select> -->
      </div>
      <div class="form-group">
        <button type="submit" name="add_admin">Add</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal1">
  <div class="modal-livestock">
    <button class="close" onclick="closeModal('editUserModal')">&times;</button>
    <form id="editUserForm">
      <h2>Edit User</h2>
      <input type="hidden" id="editUserId">
      <div class="form-group">
        <label for="editUserFullName">Full Name</label>
        <input type="text" id="editUserFullName">
      </div>
      <div class="form-group">
        <label for="editUserName">Username</label>
        <input type="text" id="editUserName">
      </div>
      <div class="form-group">
        <label for="editUserEmail">Email</label>
        <input type="email" id="editUserEmail">
      </div>
      <div class="form-group">
        <label for="editUserRole">Role</label>
        <select id="editUserRole">
          <option value="" selected disabled>Select Role</option>
          <option value="Admin">Admin</option>
          <option value="User">User</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit">Save</button>
      </div>
    </form>
  </div>
</div>


  <script>
    const emails = document.querySelectorAll(".email");
    function maskEmail(email) {
      const [user, domain] = email.split('@');
      if (user.length <= 2) return email; 

      const first = user[0];
      const last = user[user.length - 1];
      const masked = first + '*'.repeat(user.length - 2) + last;
      return masked + '@' + domain;
    }

    emails.forEach(el => {
      el.textContent = maskEmail(el.textContent.trim());
    });

    let userCount = 1;

    document.getElementById("openUserModal").addEventListener("click", () => {
      document.getElementById("userModal").classList.add("show");
    });

    function closeModal(id) {
      document.getElementById(id).classList.remove("show");
    }

    function displayAdmin() {
  const adminTable = document.getElementById("adminTable");
  adminTable.innerHTML = "";

  fetch("../api/get/read_admins.php")
    .then(response => response.json())
    .then(data => {
      if (data.length === 0) {
        adminTable.innerHTML = "<tr><td colspan='5'>No users found.</td></tr>";
        return;
      }

      data.forEach((admin) => {
        const row = document.createElement("tr");
        row.setAttribute("data-id", admin.user_id); // Use actual ID if available

        // Escape strings to prevent HTML/JS injection issues
        const fullName = encodeURIComponent(admin.full_name);
        const username = encodeURIComponent(admin.username);
        const email = encodeURIComponent(admin.email);
        const role = encodeURIComponent(admin.role);
        
        row.innerHTML = `
          <td>${admin.full_name}</td>
          <td>${admin.username}</td>
          <td class="email">${admin.email}</td>
          <td>${admin.role}</td>
          <td>
            <button class="bx bxs-edit icon-edit" 
              onclick="openEditModal(${admin.user_id}, decodeURIComponent('${fullName}'), decodeURIComponent('${username}'), decodeURIComponent('${email}'), decodeURIComponent('${role}'))"></button>
            <button class="bx bxs-archive icon-archive" 
              onclick="archiveUser(${admin.user_id})"></button>
          </td>
        `;
        adminTable.appendChild(row);
      });
    })
}


    function openEditModal(id, fullName, username, email, role) {
      document.getElementById("editUserId").value = id;
      document.getElementById("editUserFullName").value = fullName;
      document.getElementById("editUserName").value = username;
      document.getElementById("editUserEmail").value = email;
      document.getElementById("editUserRole").value = role;
      document.getElementById("editUserModal").classList.add("show");
    }

    document.getElementById("editUserForm").addEventListener("submit", function (e) {
      e.preventDefault();

      const user_id = document.getElementById("editUserId").value;
      const full_name = document.getElementById("editUserFullName").value;
      const username = document.getElementById("editUserName").value;
      const email = document.getElementById("editUserEmail").value;
      const role = document.getElementById("editUserRole").value;

      const adminForm = new FormData();
      adminForm.append("user_id", user_id);
      adminForm.append("full_name", full_name);
      adminForm.append("username", username);
      adminForm.append("email", email);
      adminForm.append("role", role);

      fetch("../api/post/update_admin.php", {
        method: "POST",
        body: adminForm
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            closeModal("editUserModal");
            displayAdmin();
          } else {
            alert("Error updating user: " + data.message);
          }
        });
    });

    displayAdmin();

    function archiveUser(id) {
      console.log(id);
      
      const archiveAdmin = new FormData();
      archiveAdmin.append("user_id", id);

      fetch("../api/post/archive_admin.php", {
        method: "POST",
        body: archiveAdmin
      })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          
          if (data.status === "success") {
            displayAdmin();
          } else {
            alert("Error archiving user: " + data.message);
          }
        });
    }
  </script>
  <script src="../js/kebab.js"></script>
  <script src="../js/script.js"></script>
  <script src="../js/dropdown_profile.js"></script>
</body>

</html>
