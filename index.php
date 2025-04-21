<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <favicon href="img/favicon.ico" type="image/x-icon"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/reg.css">
    <title>Sign In</title>
   
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="img/logo.png" alt="Cooperative Logo">
        </div>

        <h1>BFAC Management System</h1>

        <form id="loginForm" action="/login" method="POST">
            <div class="input-group">
                <label for="username">Email or Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your email or username" required>
                <div class="error-message" id="usernameError">Please enter your username or email</div>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                <div class="error-message" id="passwordError">Please enter your password</div>
            </div>
            <div class="input-group">
                <a href="forgot-password.php" target="_blank" class="forgot-password">Forgot Password?</a>
            </div>
            <button type="submit" class="btn-login" name="login">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

            <div class="footer-links">
              <a href="user/reg.php" class="footer-link">Create New Account</a>
          </div>
        <div class="footer">
            &copy; 2025 BFAC Management System. All rights reserved.
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const togglePassword = document.getElementById('togglePassword');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            
            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
            
            loginForm.addEventListener('submit', function(event) {
                event.preventDefault();
                
                document.querySelectorAll('.error-message').forEach(el => {
                    el.style.display = 'none';
                });
                
                let isValid = true;
                
                if (!document.getElementById('username').value.trim()) {
                    document.getElementById('usernameError').style.display = 'block';
                    isValid = false;
                }
                
                if (!passwordInput.value.trim()) {
                    document.getElementById('passwordError').style.display = 'block';
                    isValid = false;
                }
                
                if (isValid) {
                    const submitBtn = loginForm.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
                    submitBtn.disabled = true;
                    
                    const loginData = new FormData();
                    loginData.append('username', usernameInput.value);
                    loginData.append('password', passwordInput.value);

                    setTimeout(() => {
                        fetch('auth/login.php', {
                            method: 'POST',
                            body: loginData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {      
                            console.log(data);
                                                  
                            if (data.status == "success") {
                                if(data.role == 'Admin' || data.role == 'Treasurer') {
                                    window.location.href = 'admin/admin.php';
                                } else {
                                    window.location.href = 'user/home.php';
                                }
                            } else {
                                submitBtn.innerHTML = originalText;
                                submitBtn.disabled = false;
                                document.getElementById('passwordError').textContent = data.message || 'Invalid credentials';
                                document.getElementById('passwordError').style.display = 'block';
                            }
                        })
                    }, 1500);
                }
            });
            
            // Improve mobile form navigation
            document.getElementById('username').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('password').focus();
                }
            });
            
            document.getElementById('password').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.querySelector('.btn-login').click();
                }
            });
        });
    </script>
</body>
</html>