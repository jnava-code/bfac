<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Archive Module</title>
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/style.css"/>
  <link rel="stylesheet" href="css/modal.css"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<section id="sidebar">
  <a href="#" class="brand">
    <img src="img/logo.png" alt="Logo" class="logo" />
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
    <li><a href="logout.html" class="logout"><i class="bx bxs-log-out-circle"></i><span class="text">Logout</span></a></li>
  </ul>
</section>
<!-- END SIDEBAR -->

<!-- CONTENT -->
<section id="content">
  <!-- NAVBAR -->
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
      <ul class="dropdown-menu">
        <li><a href="AccountSettings.php">Edit Profile</a></li>
        <li><a href="add_account.php">Add Account</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>


  <!-- MAIN -->
  <main>
    <div class="head-title">
      <div class="left">
        <h1>Archive Module</h1>
        <ul class="breadcrumb">
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#">User</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#" class="active">Archive</a></li>
        </ul>
      </div>
    </div>

    <div class="table-data">
      <div class="db">
        <div class="head">
          <h3>Archived Shares</h3>
          <button  class="view-btn "  onclick="window.location.href='shares.html';"> 
            <i class='bx bx-left-arrow-alt'>
            </i> Back  
        </button> 
        </div>
        <table>
          <thead>
            <tr>
                <th>Name</th>
                <th>Position on Board</th>
                <th>Status</th>
                <th>Receipt Control Number</th>
                <th>Action</th>
            </tr>
          </thead>
          <tbody id="archiveTableBody">
            <!-- JS will populate rows here -->
          </tbody>
          <td>
            <button class='icon-edit' onclick="restorePost('${user.name}')"><i class='bx bx-refresh'></i></button>
            <button class='icon-delete' onclick="deletePost('${user.name}')"><i class='bx bxs-trash'></i></button>
          </td>
        </table>
      </div>
    </div>
  </main>
</section>

<!-- JS -->

<script>
  function restorePost(title) {
    Swal.fire({
      title: 'Restore Post?',
      text: `"${title}" will be moved back to active items.`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, restore it!',
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire('Restored!', `"${title}" has been restored.`, 'success');
      }
    });
  }

  function deletePost(title) {
    Swal.fire({
      title: 'Are you sure?',
      text: `This will permanently delete "${title}" from archive.`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      confirmButtonColor: '#d33'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire('Deleted!', `"${title}" has been removed.`, 'success');
      }
    });
  }
</script>

<script src="js/script.js"></script>
<script src="js/dropdown_profile.js"></script>

</body>
</html>
