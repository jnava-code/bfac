<?php 
  include "../config/db.php";
  include "../auth/session.php"; 

  $sql_user = "SELECT * FROM user_members WHERE is_archived = 0 AND status = 'Approved' AND is_verified = 1";
  $result_user = mysqli_query($conn, $sql_user);
  
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
    <nav>
      <i class="bx bx-menu"></i>
      <form action="#">
        <div class="form-input">
          <input type="search" placeholder="Search...">
          <button type="submit" class="search-btn"><i class="bx bx-search"></i></button>
        </div>
      </form>
      <input type="checkbox" id="switch-mode" hidden>
      <label for="switch-mode" class="switch-mode"></label>
      <a href="notif.html" class="notification">
        <i class="bx bxs-bell"></i><span class="num">8</span>
      </a>
      <div class="profile-dropdown">
        <a href="#" class="profile"><img src="img/admin.png" alt="Profile"></a>
        <ul class="dropdown-menu">
          <li><a href="admin.html">Admin Accounts</a></li>

        </ul>
      </div>
    </nav>

    <main>
      <div class="head-title">
        <div class="left">
          <h1 id="page-title">Admin Dashboard</h1>
          <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class="bx bx-chevron-right"></i></li>
            <li><a class="active" href="#">User Management</a></li>
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
                        <li><a href="archive_admin.html">Archive</a></li>
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
            <tbody>
                <!-- <tr data-id="1">
                    <td>1</td>
                <td><img src="img/profile1.jpg" alt="Profile" class="profile-img"></td> -->
                <?php 
                  if(mysqli_num_rows($result_user) > 0) {
                    while($row = mysqli_fetch_assoc($result_user)) {
                      echo "<td>{$row['first_name']} {$row['middle_name']} {$row['last_name']}</td>";
                      echo "<td>{$row['username']}</td>";
                      echo "<td>{$row['email']}</td>";
                      echo "<td>{$row['role']}</td>";
                      echo "<td>
                              <button class='bx bxs-edit icon-edit' onclick=\"openEditModal({$row['member_id']}, '{$row['first_name']} {$row['middle_name']} {$row['last_name']}', '{$row['username']}', '{$row['email']}', '{$row['role']}')\"></button>
                              <button class='bx bxs-archive icon-archive' onclick=\"archiveUser({$row['member_id']})\"></button>
                            </td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='6'>No users found.</td></tr>";
                  }
                ?>
              </tr>
              
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
    <form id="userForm">
      <h2>Add User</h2>
      <div class="form-group">
        <label for="userFullName">Full Name</label>
        <input type="text" id="userFullName" required>
      </div>
      <div class="form-group">
        <label for="userName">Username</label>
        <input type="text" id="userName" required>
      </div>
      <div class="form-group">
        <label for="userEmail">Email</label>
        <input type="email" id="userEmail" required>
      </div>
      <div class="form-group">
        <label for="userRole">Role</label>
        <select id="userRole" required>
          <option value="">Select Role</option>
          <option value="Admin">Admin</option>
          <option value="User">User</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit">Add</button>
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
        <input type="text" id="editUserFullName" required>
      </div>
      <div class="form-group">
        <label for="editUserName">Username</label>
        <input type="text" id="editUserName" required>
      </div>
      <div class="form-group">
        <label for="editUserEmail">Email</label>
        <input type="email" id="editUserEmail" required>
      </div>
      <div class="form-group">
        <label for="editUserRole">Role</label>
        <select id="editUserRole" required>
          <option value="">Select Role</option>
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
    let userCount = 1;

    document.getElementById("openUserModal").addEventListener("click", () => {
      document.getElementById("userModal").classList.add("show");
    });

    function closeModal(id) {
      document.getElementById(id).classList.remove("show");
    }

    document.getElementById("userForm").addEventListener("submit", function (e) {
      e.preventDefault();

      const name = document.getElementById("userFullName").value;
      const username = document.getElementById("userName").value;
      const email = document.getElementById("userEmail").value;
      const role = document.getElementById("userRole").value;

      if (!role) return alert("Please select a role.");

      userCount++;
      const row = document.createElement("tr");
      row.setAttribute("data-id", userCount);
      row.innerHTML = `
        <td>${userCount}</td>
        <td><img src="img/default-profile.jpg" class="profile-img" alt="Profile"/></td>
        <td>${name}</td>
        <td>${username}</td>
        <td>${email}</td>
        <td>${role}</td>
        <td>
          <button class="bx bxs-edit icon-edit" onclick="openEditModal(${userCount}, '${name}', '${username}', '${email}', '${role}')"></button>
          <button class="bx bxs-archive icon-archive" onclick="archiveUser(${userCount})"></button>
        </td>
      `;
      document.getElementById("userTableBody").appendChild(row);

      closeModal("userModal");
      this.reset();
    });

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

      const id = document.getElementById("editUserId").value;
      const name = document.getElementById("editUserFullName").value;
      const username = document.getElementById("editUserName").value;
      const email = document.getElementById("editUserEmail").value;
      const role = document.getElementById("editUserRole").value;

      const row = document.querySelector(`tr[data-id='${id}']`);
      if (row) {
        row.children[2].textContent = name;
        row.children[3].textContent = username;
        row.children[4].textContent = email;
        row.children[5].textContent = role;
      }

      closeModal("editUserModal");
    });

    function archiveUser(id) {
      const row = document.querySelector(`tr[data-id='${id}']`);
      if (row) {
        row.remove();
        alert(`User #${id} has been archived.`);
      }
    }
  </script>
    <script src="js/kebab.js"></script>

  <script src="js/script.js"></script>
  <script src="js/dropdown_profile.js"></script>
</body>

</html>
