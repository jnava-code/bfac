<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/services.css">
    <title>Announcement Management</title>
</head>
<body>

    <!-- SIDEBAR -->
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
            <li><a href="members.html"><i class="bx bxs-user-detail"></i><span class="text">Manage Members</span></a></li>
            <li><a href="product.html"><i class="bx bxs-box"></i><span class="text">Product Inventory</span></a></li>
            <li class="active"><a href="services.html"><i class="bx bxs-briefcase"></i><span class="text">Information Management</span></a></li>
            <li><a href="shares.html"><i class="bx bxs-coin-stack"></i><span class="text">Shares</span></a></li>
            <li><a href="div.html"><i class="bx bx-line-chart-down"></i><span class="text">Dividends</span></a></li>
            <li><a href="livestock.html"><i class="bx bxs-book-content"></i><span class="text">Livestock Management</span></a></li>
            <li><a href="bid.html"><i class="bx bxs-file-doc"></i><span class="text">Bid Contract Tracking</span></a></li>
            <li><a href="order.html"><i class="bx bxs-cart-alt"></i><span class="text">Order</span></a></li>
            <li><a href="sales.html"><i class='bx bxs-credit-card-alt'></i><span class="text">Sales </span></a></li>
            <li><a href="expenses.html"><i class='bx bxs-coin-stack' ></i><span class="text">Expenses </span></a></li>
            </ul>    
          <ul class="side-menu">
            <li><a href="settings.html"><i class="bx bxs-cog"></i><span class="text">Settings</span></a></li>
            <li><a href="logout.html" class="logout"><i class="bx bxs-log-out-circle"></i><span class="text">Logout</span></a></li>
          </ul>
    </section>
    <!-- SIDEBAR -->

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
            </div>
          </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1 id="page-title">Announcement Management</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li><a class="active" href="#" id="current-page">Announcement Management</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">

                <!-- Create Announcement Form -->


                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Create New Announcement</h3>
                        </div>
                    <form id="announcementForm">
                        <div class="form-group">
                            <label for="announcementTitle" class="form-label">Title*</label>
                            <input type="text" id="announcementTitle" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="announcementContent" class="form-label">Content*</label>
                            <textarea id="announcementContent" class="form-control" required></textarea>
                        </div>

                        <!-- Image Upload Section -->
                        <div class="form-group image-upload-container">
                            <label class="image-upload-label">Add Image (Optional)</label>
                            <div class="image-upload-box" id="uploadBox">
                                <i class="bx bx-image-add"></i>
                                <p>Drag & drop an image here or click to browse</p>
                                <small>Supports JPG, PNG (Max 5MB)</small>
                                <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                            </div>
                            <img id="imagePreview" alt="Preview">
                            <div class="remove-image" id="removeImage" style="display: none;">
                                <i class="bx bx-trash"></i> Remove Image
                            </div>
                        </div>
                   
                        <div class="form-group">
                            <label class="form-label">Recipients*</label>
                            <div class="recipients-container">
                                <!-- All Users toggle (checked by default) -->
                                <div class="recipient-toggle">
                                    <input type="checkbox" id="allUsersToggle" checked>
                                    <label for="allUsersToggle">All Users (50)</label>
                                </div>

                                <!-- Individual user selection (collapsed by default) -->
                                <div class="recipients-list-container">
                                    <button type="button" class="toggle-recipients-btn">
                                        <i class="bx bx-chevron-down"></i> Select Individual Users
                                    </button>

                                    <div class="recipients-list" style="display:none; max-height:200px; overflow-y:auto;">
                                        <div class="recipient-item">
                                            <input type="checkbox" id="user1" class="user-checkbox" disabled>
                                            <label for="user1">John Doe (Admin)</label>
                                        </div>
                                        <div class="recipient-item">
                                            <input type="checkbox" id="user2" class="user-checkbox" disabled>
                                            <label for="user2">Jane Smith (Member)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="selected-count">50 users selected</div>
                        </div>
                   
                        <button type="submit" class="submit-btn">Post Announcement</button>
                    </form>
                </div>
            </div>
        </div>
                <!-- Tab Navigation -->
                <div class="tabs">
                    <div class="tab active" data-tab="all">All Announcements</div>
                    <div class="tab" data-tab="active">Active</div>
                    <div class="tab" data-tab="archived">Archived</div>
                </div>

                <!-- Announcements List -->
                <div id="announcementsContainer">
                    <!-- All Announcements Tab Content -->
                    <div class="tab-content" id="all-tab">
                        <!-- Announcement Cards -->
                        <div class="announcement-card">
                            <div class="announcement-header">
                                <h3 class="announcement-title">System Maintenance Tonight</h3>
                                <span class="announcement-date">Posted: May 15, 2023 at 2:30 PM</span>
                            </div>
                            <img src="img/logo.png" class="announcement-image" alt="Maintenance Notice">
                            <div class="announcement-content">
                                <p>We will be performing scheduled system maintenance tonight from 11:00 PM to 3:00 AM. During this time, the system will be unavailable. Please plan your work accordingly.</p>
                            </div>
                            <div class="announcement-footer">
                                <div class="recipients">Sent to: All Users</div>
                                <div class="actions">
                                    <button class="action-btn edit"><i class="bx bx-edit"></i> Edit</button>
                                    <button class="action-btn archive"><i class="bx bx-archive"></i> Archive</button>
                                    <button class="action-btn delete"><i class="bx bx-trash"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Announcements Tab Content -->
                    <div class="tab-content" id="active-tab" style="display: none;">
                        <!-- Active announcement content will be displayed here -->
                    </div>

                    <!-- Archived Announcements Tab Content -->
                    <div class="tab-content" id="archived-tab" style="display: none;">
                        <!-- Archived announcements will be displayed here -->
                    </div>
                </div>
            </div>
        </main>

    </section>
    <script src="js/script.js"></script>
    <script src="js/services.js"></script>
    <script src="js/dropdown_profile.js"></script>
</body>
</html>
