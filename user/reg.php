<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/reg.css">
    <title>Registration</title>
    <style>
        /* Add these styles to your reg.css or in the head */
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 35px;
            cursor: pointer;
            color: #666;
        }
        .password-strength {
            height: 4px;
            background: #eee;
            margin-top: 5px;
            border-radius: 2px;
            overflow: hidden;
        }
        .password-strength-bar {
            height: 100%;
            width: 0%;
            background: red;
            transition: width 0.3s ease;
        }
        .password-requirements {
            font-size: 0.8rem;
            color: #666;
            margin-top: 5px;
        }
        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 3px;
        }
        .requirement i {
            margin-right: 5px;
            font-size: 0.7rem;
        }
        .requirement.valid {
            color: green;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="logo">
            <img src="../img/logo.png" alt="Cooperative Logo">
        </div>

        <h1>BFAC Management System<br>Member Registration</h1>

        <form id="registrationForm" action="/register" method="POST">
            <div class="form-grid">
                <div class="input-group">
                    <label for="firstName" class="required-field">First Name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="First name" required>
                    <div class="error-message" id="firstNameError">Please enter your first name</div>
                </div>

                <div class="input-group">
                    <label for="middleName" class="required-field">Middle Name</label>
                    <input type="text" id="middleName" name="middleName" placeholder="Middle name" required>
                    <div class="error-message" id="middleName">Please enter your middle name</div>
                </div>

                <div class="input-group">
                    <label for="lastName" class="required-field">Last Name</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Last name" required>
                    <div class="error-message" id="lastNameError">Please enter your last name</div>
                </div>

                <div class="input-group">
                    <label for="email" class="required-field">Email</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required>
                    <div class="error-message" id="emailError">Please enter a valid email</div>
                </div>

                <div class="input-group">
                    <label for="phone" class="required-field">Phone</label>
                    <input type="tel" id="phone" name="phone" placeholder="0912 345 6789" required>
                    <div class="error-message" id="phoneError">Please enter a valid phone</div>
                </div>

                <div class="input-group">
                    <label for="rsbsaNumber">RSBSA Number</label>
                    <input type="text" id="rsbsaNumber" name="rsbsaNumber" placeholder="RSBSA number (if available)">
                </div>
            </div>

            <div class="input-group">
                <label for="address" class="required-field">Home Address</label>
                <input type="text" id="address" name="address" placeholder="Complete home address" required>
                <div class="error-message" id="addressError">Please enter your address</div>
            </div>

            <div class="input-group">
                <label for="farmLocation" class="required-field">Farm Location</label>
                <input type="text" id="farmLocation" name="farmLocation" placeholder="Location of your farm" required>
                <div class="error-message" id="farmLocationError">Please enter farm location</div>
            </div>

            <!-- Password Fields -->
            <div class="form-grid">
                <div class="input-group password-container">
                    <label for="password" class="required-field">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create password" required>
                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrength"></div>
                    </div>
                    <div class="password-requirements" id="passwordRequirements">
                        <div class="requirement" id="reqLength"><i class="fas fa-circle"></i> At least 8 characters</div>
                        <div class="requirement" id="reqUpper"><i class="fas fa-circle"></i> At least 1 uppercase letter</div>
                        <div class="requirement" id="reqLower"><i class="fas fa-circle"></i> At least 1 lowercase letter</div>
                        <div class="requirement" id="reqNumber"><i class="fas fa-circle"></i> At least 1 number</div>
                        <div class="requirement" id="reqSpecial"><i class="fas fa-circle"></i> At least 1 special character</div>
                    </div>
                    <div class="error-message" id="passwordError">Please enter a valid password</div>
                </div>

                <div class="input-group password-container">
                    <label for="confirmPassword" class="required-field">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required>
                    <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                    <div class="error-message" id="confirmPasswordError">Passwords do not match</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.location.href='../index.php'">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </button>
                <button type="submit">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </div>
        </form>

        <div class="footer">
            &copy; 2025 BFAC Management System. All rights reserved.
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registrationForm');
            const inputs = document.querySelectorAll('input, select');
            
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
            
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
            
            // Password strength checker
            passwordInput.addEventListener('input', function() {
                validatePasswordStrength(this.value);
                validateField(this);
            });
            
            confirmPasswordInput.addEventListener('input', function() {
                validateField(this);
            });
            
            function validatePasswordStrength(password) {
                // Strength calculation
                let strength = 0;
                const requirements = {
                    length: password.length >= 8,
                    upper: /[A-Z]/.test(password),
                    lower: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    special: /[^A-Za-z0-9]/.test(password)
                };
                
                // Update requirement indicators
                document.getElementById('reqLength').classList.toggle('valid', requirements.length);
                document.getElementById('reqUpper').classList.toggle('valid', requirements.upper);
                document.getElementById('reqLower').classList.toggle('valid', requirements.lower);
                document.getElementById('reqNumber').classList.toggle('valid', requirements.number);
                document.getElementById('reqSpecial').classList.toggle('valid', requirements.special);
                
                // Calculate strength (0-100)
                if (requirements.length) strength += 20;
                if (requirements.upper) strength += 20;
                if (requirements.lower) strength += 20;
                if (requirements.number) strength += 20;
                if (requirements.special) strength += 20;
                
                // Update strength bar
                const strengthBar = document.getElementById('passwordStrength');
                strengthBar.style.width = strength + '%';
                
                // Change color based on strength
                if (strength < 40) {
                    strengthBar.style.backgroundColor = 'red';
                } else if (strength < 80) {
                    strengthBar.style.backgroundColor = 'orange';
                } else {
                    strengthBar.style.backgroundColor = 'green';
                }
                
                return strength >= 80; // Consider strong if >= 80%
            }
            
            // Add input event listeners for real-time validation
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    validateField(this);
                });
                
                // Improve mobile experience by changing input type when focused
                if (input.type === 'tel') {
                    input.addEventListener('focus', function() {
                        this.type = 'number';
                        this.setAttribute('inputmode', 'numeric');
                    });
                }
            });
            
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                // Reset error messages
                document.querySelectorAll('.error-message').forEach(el => {
                    el.style.display = 'none';
                });
                
                let isValid = true;
                
                // Validate all fields
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });
                
                // Additional password validation
                if (passwordInput.value !== confirmPasswordInput.value) {
                    document.getElementById('confirmPasswordError').style.display = 'block';
                    isValid = false;
                }
                
                if (!validatePasswordStrength(passwordInput.value)) {
                    document.getElementById('passwordError').textContent = 'Password does not meet requirements';
                    document.getElementById('passwordError').style.display = 'block';
                    isValid = false;
                }
                
                if (isValid) {
                    // Show loading state
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    submitBtn.disabled = true;
                    
                    // Simulate form submission (replace with actual AJAX call)
                    setTimeout(() => {
                        alert('Registration submitted successfully!');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                        form.reset();
                    }, 1500);
                }
            });
            
            function validateField(field) {
                const errorElement = document.getElementById(`${field.id}Error`);
                if (!errorElement) return true;
                
                errorElement.style.display = 'none';
                
                if (field.hasAttribute('required') && !field.value.trim()) {
                    errorElement.style.display = 'block';
                    return false;
                }
                
                if (field.id === 'email' && !validateEmail(field.value)) {
                    errorElement.textContent = 'Please enter a valid email address';
                    errorElement.style.display = 'block';
                    return false;
                }
                
                if (field.id === 'phone' && !validatePhone(field.value)) {
                    errorElement.textContent = 'Please enter a valid phone number (at least 10 digits)';
                    errorElement.style.display = 'block';
                    return false;
                }
                
                return true;
            }
            
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
            
            function validatePhone(phone) {
                // Remove all non-digit characters
                const digits = phone.replace(/\D/g, '');
                return digits.length >= 10;
            }
            
            // Improve mobile form navigation
            const formGroups = document.querySelectorAll('.input-group');
            formGroups.forEach((group, index) => {
                const input = group.querySelector('input, select');
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const nextGroup = formGroups[index + 1];
                        if (nextGroup) {
                            const nextInput = nextGroup.querySelector('input, select');
                            if (nextInput) {
                                nextInput.focus();
                            } else {
                                document.querySelector('button[type="submit"]').focus();
                            }
                        } else {
                            document.querySelector('button[type="submit"]').focus();
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>