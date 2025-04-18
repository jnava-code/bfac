<?php include "../auth/session.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/sam.css">
    <link rel="stylesheet" href="../css/home.css">
    <title>Profile</title>
    <style>
        :root {
            --green: #3b6934;
            --dark-green: #31572b;
            --yellow: #FD7238;
            --light-yellow: #ffe6c6;
            --poppins: 'Poppins', sans-serif;
            --lato: 'Lato', sans-serif;
        }

        .profile-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            width: 100%;
            max-width: 800px;
            padding: 30px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
            color: var(--dark-green);
            position: relative;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #fff;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
            border: 3px solid green;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

       

        .profile-container h1 {
            font-family: var(--poppins);
            color: var(--dark-green);
            margin-bottom: 5px;
            font-size: 22px;
        }

    


        .profile-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .action-btn {
            color: #31572b;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            font-family: var(--poppins);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .action-btn.secondary {
            background-color: #6c757d;
        }

        .action-btn.secondary:hover {
            background-color: #5a6268;
        }

        .profile-details {
            text-align: left;
            margin-bottom: 25px;
        }

        .detail-group {
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--dark-green);
            font-size: 13px;
            margin-bottom: 5px;
        }

        .detail-value {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            border-left: 3px solid var(--green);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .input-group {
            margin-bottom: 12px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 6px;
            color: var(--dark-green);
            font-weight: 600;
            font-size: 13px;
        }

        .input-group input, 
        .input-group select, 
        .input-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: var(--lato);
        }

        .input-group input:focus, 
        .input-group select:focus, 
        .input-group textarea:focus {
            border-color: var(--green);
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 105, 52, 0.2);
        }

        .input-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            background-color: var(--dark-green);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            font-family: var(--poppins);
            transition: all 0.3s;
            flex: 1;
        }

        .btn:hover {
            background-color: var(--green);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .footer {
            margin-top: 25px;
            color: var(--dark-green);
            font-size: 11px;
            line-height: 1.4;
        }

        /* View/Edit toggle */
        .view-mode, .edit-mode {
            display: none;
        }

        .view-mode.active, .edit-mode.active {
            display: block;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .profile-container {
                padding: 40px;
            }
            
            .profile-header {
                margin-bottom: 30px;
            }
            
            .profile-avatar {
                width: 140px;
                height: 140px;
            }
            
            .profile-container h1 {
                font-size: 24px;
            }
            
  
            
            .action-btn {
                padding: 10px 20px;
                font-size: 14px;
            }
            
            .detail-label {
                font-size: 14px;
            }
            
            .detail-value {
                font-size: 15px;
            }
            
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .input-group {
                margin-bottom: 15px;
            }
            
            .input-group label {
                font-size: 14px;
            }
            
            .input-group input, 
            .input-group select, 
            .input-group textarea {
                font-size: 15px;
            }
            
            .btn {
                font-size: 16px;
            }
            
            .footer {
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .profile-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- <section id="sidebar">
        <a href="#" class="brand">
            <img src="../img/logo.png" alt="Logo" class="logo">
            <div class="text">
                <span class="title">BFAC Hub</span>
                <span class="subtitle">Management System</span>
            </div>
        </a>
        <ul class="side-menu top">
            <li><a href="home.html"><i class='bx bxs-home'></i><span class="text"> Home</span></a></li>
            <li class="active"><a href="profile.html"><i class="bx bxs-user"></i><span class="text">Your Profile</span></a></li>
        </ul>
        <ul class="side-menu">
            <li><a href="logout.php" class="logout"><i class="bx bxs-log-out-circle"></i><span class="text">Logout</span></a></li>
        </ul>
    </section> -->

    <?php include "user_components/user_sidebar.php"; ?>
    <section id="content">
        <?php include "user_components/user_navbar.php"; ?>
        <main>
            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="../<?php echo $profile_image ?>" alt="Profile Picture">  
                    </div>
                    
                    <h1><?php echo $firstname . ' ' . $lastname; ?></h1>
                    
                    <div class="profile-actions">
                        <button class="action-btn" onclick="toggleEditMode()">
                            <i class="fas fa-pencil-alt"></i> Edit Profile
                        </button>
                     
                </div>

                <div class="view-mode active" id="viewMode">
                    <div class="profile-details">
                        <div class="form-grid">
                            <div class="detail-group">
                                <div class="detail-label">First Name</div>
                                <input type="text" class="detail-value" value="<?php echo $firstname; ?>" readonly>
                            </div>
                            
                            <div class="detail-group">
                                <div class="detail-label">Middle Name</div>
                                <input type="text" class="detail-value" value="<?php echo $middlename; ?>" readonly>
                            </div>
                            
                            <div class="detail-group">
                                <div class="detail-label">Last Name</div>
                                <input type="text" class="detail-value" value="<?php echo $lastname; ?>" readonly>
                            </div>
                            
                            <div class="detail-group">
                                <div class="detail-label">Email</div>
                                <input type="text" class="detail-value" value="<?php echo $email; ?>" readonly>
                            </div>
                            
                            <div class="detail-group">
                                <div class="detail-label">Phone</div>
                                <input type="text" class="detail-value" value="<?php echo $phone; ?>" readonly>
                            </div>
                            
                            <div class="detail-group">
                                <div class="detail-label">RSBSA Number</div>
                                <input type="text" class="detail-value" value="<?php echo $rsbsa_number; ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="detail-group">
                            <div class="detail-label">Home Address</div>
                            <input type="text" class="detail-value" value="<?php echo $address; ?>" readonly>
                        </div>
                        
                        <div class="detail-group">
                            <div class="detail-label">Farm Location</div>
                            <input type="text" class="detail-value" value="<?php echo $farm_location; ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div class="edit-mode" id="editMode">
                    <form id="profileForm" method="POST">
                        <div class="form-grid">
                            <input type="hidden" id="memberId" name="firstName" value="<?php echo $member_id; ?>" >
                            <div class="input-group">
                                <label for="editFirstName">First Name</label>
                                <input type="text" id="editFirstName" name="firstName" value="<?php echo $firstname; ?>" required>
                            </div>

                            <div class="input-group">
                                <label for="editMiddleName">Middle Name</label>
                                <input type="text" id="editMiddleName" name="middleName" value="<?php echo $middlename; ?>">
                            </div>

                            <div class="input-group">
                                <label for="editLastName">Last Name</label>
                                <input type="text" id="editLastName" name="lastName" value="<?php echo $lastname; ?>" required>
                            </div>

                            <div class="input-group">
                                <label for="editEmail">Email</label>
                                <input type="email" id="editEmail" name="email" value="<?php echo $email; ?>" required>
                            </div>

                            <div class="input-group">
                                <label for="editPhone">Phone</label>
                                <input type="tel" id="editPhone" name="phone" value="<?php echo $phone; ?>" required>
                            </div>

                            <div class="input-group">
                                <label for="editRsbsaNumber">RSBSA Number</label>
                                <input type="text" id="editRsbsaNumber" name="rsbsaNumber" value="<?php echo $rsbsa_number; ?>">
                            </div>
                        </div>

                        <div class="input-group">
                            <label for="editAddress">Home Address</label>
                            <textarea id="editAddress" name="address" required><?php echo $address; ?></textarea>
                        </div>

                        <div class="input-group">
                            <label for="editFarmLocation">Farm Location</label>
                            <textarea id="editFarmLocation" name="farmLocation" required><?php echo $farm_location; ?></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">
                                Cancel
                            </button>
                            <button type="submit" class="btn">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <div class="footer">
                    &copy; 2025 BFAC Management System. All rights reserved.
                </div>
            </div>
        </main>
    </section>

    <script>
        // Toggle between view and edit modes
        function toggleEditMode() {
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            
            viewMode.classList.toggle('active');
            editMode.classList.toggle('active');
            
            // Scroll to top when editing
            if (editMode.classList.contains('active')) {
                window.scrollTo(0, 0);
            }
        }
        
        const memberId = document.getElementById('memberId');
        const editFirstName = document.getElementById("editFirstName");
        const editMiddleName = document.getElementById("editMiddleName");
        const editLastName = document.getElementById("editLastName");
        const editEmail = document.getElementById("editEmail");
        const editPhone = document.getElementById("editPhone");
        const editRsbsaNumber = document.getElementById("editRsbsaNumber");
        const editAddress = document.getElementById("editAddress");
        const editFarmLocation = document.getElementById("editFarmLocation");
        
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            submitBtn.disabled = true;

            const profileData = new FormData();
            profileData.append('memberId', memberId.value);
            profileData.append('firstName', editFirstName.value);
            profileData.append('middleName', editMiddleName.value);
            profileData.append('lastName', editLastName.value);
            profileData.append('email', editEmail.value);
            profileData.append('phone', editPhone.value);
            profileData.append('rsbsaNumber', editRsbsaNumber.value);
            profileData.append('address', editAddress.value);
            profileData.append('farmLocation', editFarmLocation.value);

            fetch('../api/post/update-profile.php', {
                method: 'POST',
                body: profileData
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => { 
                if (data.status === "success") {
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        toggleEditMode();
                        window.location.href = '../user/profile.php';
                    }, 1500);
                } else {
                    alert(data.message || 'Update failed.');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            })
        });

        
        // Improve mobile form navigation
        const formInputs = document.querySelectorAll('#editMode input, #editMode textarea');
        formInputs.forEach((input, index) => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (index < formInputs.length - 1) {
                        formInputs[index + 1].focus();
                    } else {
                        document.querySelector('#editMode button[type="submit"]').focus();
                    }
                }
            });
        });

        // Sidebar toggle functionality
        document.querySelector('.bx-menu').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    	<script src="../js/script.js"></script>

</body>
</html>