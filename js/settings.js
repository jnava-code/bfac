    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Get modal elements
        const modal = document.getElementById("addAdminModal");
        const addBtn = document.getElementById("add-admin-btn");
        const closeBtn = document.querySelector(".close-btn");
        const cancelBtn = document.getElementById("cancel-btn");
  
        // Function to show modal
        function showModal() {
          modal.classList.add('show');
          document.body.style.overflow = 'hidden'; // Prevent scrolling
        }
  
        // Function to hide modal
        function hideModal() {
          modal.classList.remove('show');
          document.body.style.overflow = 'auto'; // Re-enable scrolling
        }
  
        // Event listeners
        addBtn.addEventListener('click', showModal);
        closeBtn.addEventListener('click', hideModal);
        cancelBtn.addEventListener('click', hideModal);
  
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
          if (event.target === modal) {
            hideModal();
          }
        });
  
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
          if (event.key === 'Escape' && modal.classList.contains('show')) {
            hideModal();
          }
        });
  
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthMeter = document.getElementById('strengthMeter');
  
        passwordInput.addEventListener('input', function() {
          const password = passwordInput.value;
          let strength = 0;
          
          // Length check
          if (password.length > 7) strength += 25;
          if (password.length > 11) strength += 25;
          
          // Complexity checks
          if (/[A-Z]/.test(password)) strength += 15;
          if (/[0-9]/.test(password)) strength += 15;
          if (/[^A-Za-z0-9]/.test(password)) strength += 20;
          
          // Update meter
          strengthMeter.style.width = Math.min(strength, 100) + '%';
          
          // Update color based on strength
          if (strength < 40) {
            strengthMeter.style.backgroundColor = '#e74c3c'; // Red
          } else if (strength < 70) {
            strengthMeter.style.backgroundColor = '#f39c12'; // Orange
          } else {
            strengthMeter.style.backgroundColor = '#2ecc71'; // Green
          }
        });
  
        // Form validation
        const form = document.querySelector('#addAdminModal form');
        form.addEventListener('submit', function(e) {
          // Basic validation - you can enhance this further
          const password = document.getElementById('password').value;
          if (password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long');
            return false;
          }
          
          // Add more validation as needed
          return true;
        });
  
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const searchBtn = document.querySelector('.search-btn');
        
        searchBtn.addEventListener('click', function() {
          performSearch();
        });
        
        searchInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            performSearch();
          }
        });
        
        function performSearch() {
          const searchTerm = searchInput.value.trim().toLowerCase();
          if (searchTerm) {
            // In a real application, this would make an AJAX call to the server
            // For demo purposes, we'll just show an alert
            alert('Searching for: ' + searchTerm);
          }
        }
  
        // Profile picture upload functionality
        const profileUpload = document.getElementById('profileUpload');
        const profilePreview = document.getElementById('profilePreview');
        const profileImage = document.getElementById('profileImage');
        const defaultIcon = profilePreview.querySelector('.default-icon');
  
        profileUpload.addEventListener('change', function(e) {
          const file = e.target.files[0];
          if (file) {
            const reader = new FileReader();
            
            reader.onload = function(event) {
              profileImage.src = event.target.result;
              profileImage.style.display = 'block';
              defaultIcon.style.display = 'none';
            }
            
            reader.readAsDataURL(file);
          }
        });
  
        // Trigger file input when upload button is clicked
        const uploadBtn = document.querySelector('.upload-btn');
        uploadBtn.addEventListener('click', function() {
          profileUpload.click();
        });
      });

      document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-admin-btn');
        const modal = document.getElementById('addAdminModal');
        const closeBtn = document.querySelector('.close-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const addAdminForm = document.getElementById('addAdminForm');
        const adminTableBody = document.querySelector('#admin-table tbody');
        
        // Show modal
        function showModal() {
          modal.classList.add('show');
          document.body.style.overflow = 'hidden';
        }
  
        // Hide modal
        function hideModal() {
          modal.classList.remove('show');
          document.body.style.overflow = 'auto';
        }
  
        // Add admin to table
        function addAdminToTable(admin) {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${admin.id}</td>
            <td class="profile-cell">
              <img src="${admin.profilePic}" alt="Profile" class="profile-pic">
            </td>
            <td>${admin.fullName}</td>
            <td>${admin.username}</td>
            <td>${admin.email}</td>
            <td><span class="role-badge role-${admin.role.toLowerCase()}">${admin.role}</span></td>
            <td class="actions-cell">
              <button class="btn btn-sm btn-edit" onclick="editAdmin(${admin.id})">
                <i class="fas fa-edit"></i> Edit
              </button>
              <button class="btn btn-sm btn-delete" onclick="deleteAdmin(${admin.id})">
                <i class="fas fa-trash"></i> Delete
              </button>
            </td>
          `;
          adminTableBody.appendChild(row);
        }
  
        // Handle form submission to add new admin
        addAdminForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          const adminData = {
            id: Date.now(),  // Simulate an auto-generated ID
            profilePic: 'path/to/profile.jpg', // Placeholder for profile pic
            fullName: document.getElementById('full_name').value,
            username: document.getElementById('username').value,
            email: document.getElementById('email').value,
            role: document.getElementById('role').value
          };
          
          // Add new admin to table
          addAdminToTable(adminData);
          
          // Reset the form and hide modal
          addAdminForm.reset();
          hideModal();
        });
  
        // Close modal actions
        addBtn.addEventListener('click', showModal);
        closeBtn.addEventListener('click', hideModal);
        cancelBtn.addEventListener('click', hideModal);
        
        // Edit admin (placeholder function)
        function editAdmin(adminId) {
          alert('Editing admin with ID: ' + adminId);
        }
  
        // Delete admin
        function deleteAdmin(adminId) {
          const row = document.querySelector(`tr[data-id="${adminId}"]`);
          row.remove();
        }
  
        // Search admins (basic example)
        const searchInput = document.getElementById('search-input');
        const searchBtn = document.getElementById('search-btn');
        
        searchBtn.addEventListener('click', function() {
          const query = searchInput.value.toLowerCase();
          const rows = adminTableBody.querySelectorAll('tr');
          rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const fullName = cells[2].textContent.toLowerCase();
            if (fullName.includes(query)) {
              row.style.display = '';
            } else {
              row.style.display = 'none';
            }
          });
        });
  
        // Example admin data for testing
        const admins = [
          { id: 1, profilePic: 'path/to/profile.jpg', fullName: 'John Doe', username: 'johndoe', email: 'john.doe@example.com', role: 'ADMIN' },
          { id: 2, profilePic: 'path/to/profile.jpg', fullName: 'Jane Smith', username: 'janesmith', email: 'jane.smith@example.com', role: 'SECRETARY' }
        ];
  
        // Populate table with sample admins
        admins.forEach(addAdminToTable);
      });