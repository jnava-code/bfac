<?php
  include "../config/db.php";
  include "../auth/session.php";

  $sql_sale = "
    SELECT * FROM admin_sales WHERE is_archived = 1
  ";

  $result_sale = mysqli_query($conn, $sql_sale);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Archive Module</title>
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../css/style.css"/>
  <link rel="stylesheet" href="../css/modal.css"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php include "admin_components/admin_sidebar.php"; ?>

<section id="content">
  <?php include "admin_components/admin_navbar.php"; ?>

  <main>
    <div class="head-title">
      <div class="left">
        <h1>Archive Module</h1>
        <ul class="breadcrumb">
          <li><a href="dashboard.html">Dashboard</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#">Sales</a></li>
          <li><i class="bx bx-chevron-right"></i></li>
          <li><a href="#" class="active">Archive</a></li>
        </ul>
      </div>
    </div>

    <div class="table-data">
      <div class="db">
        <div class="head">
          <h3>Archived Shares</h3>
          <button class="view-btn" onclick="window.location.href='sales.php';">
            <i class='bx bx-left-arrow-alt'></i> Back  
          </button>
        </div>
        <table>
          <thead>
            <tr>
                <th>Order No.</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price (₱)</th>
                <th>Receipt Control Number</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="archiveTableBody">
            <?php
              if ($result_sale && mysqli_num_rows($result_sale) > 0) {
                while ($row = mysqli_fetch_assoc($result_sale)) {
                    $id = $row['id'];
            ?>
              <tr id="sale_row_<?php echo $id; ?>">
                <td><?php echo htmlspecialchars($row['sales_no']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td>₱<?php echo number_format(htmlspecialchars($row['amount'])); ?></td>
                <td><?php echo htmlspecialchars($row['receipt_no']); ?></td>
                <td>
                  <button class='icon-edit' onclick="restorePost('<?php echo addslashes($row['description']); ?>', <?php echo $id; ?>)">
                    <i class='bx bx-refresh'></i>
                  </button>
                  <button class='icon-delete' onclick="deletePost('<?php echo addslashes($row['description']); ?>', <?php echo $id; ?>)">
                    <i class='bx bxs-trash'></i>
                  </button>
                </td>
              </tr>
              <?php
                }
              } else {
                echo "<tr><td colspan='6'>No archived shares found.</td></tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</section>

<script>
function restorePost(title, shareId) {
  Swal.fire({
    title: 'Restore Post?',
    text: `"${title}" will be moved back to active items.`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, restore it!',
  }).then((result) => {
    if (result.isConfirmed) {
      const restoreData = new FormData();
      restoreData.append("id", shareId);

      fetch("../api/update/restore_sale.php", {
        method: 'POST',
        body: restoreData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === "success") {
          Swal.fire('Restored!', `"${title}" has been restored.`, 'success');
          const row = document.getElementById(`sale_row_${shareId}`);
          if (row) row.remove();
        } else {
          Swal.fire('Error', data.message || 'Restore failed.', 'error');
        }
      });
    }
  });
}

function deletePost(title, shareId) {
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
      deleteData.append("id", shareId);
      
      fetch("../api/delete/delete_sale.php", {
        method: 'POST',
        body: deleteData
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === "success") {
          Swal.fire('Deleted!', `"${title}" has been removed.`, 'success');
          const row = document.getElementById(`sale_row_${shareId}`);
          if (row) row.remove();
        } else {
          Swal.fire('Error', data.message || 'Delete failed.', 'error');
        }
      });
    }
  });
}
</script>

<script src="../js/script.js"></script>
<script src="../js/dropdown_profile.js"></script>

</body>
</html>
