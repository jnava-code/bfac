
    function previewImage(event) {
        const preview = document.getElementById("imagePreview");
        preview.innerHTML = ""; // Clear previous image
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.createElement("img");
                img.src = reader.result;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }

document.addEventListener("DOMContentLoaded", function() {
    let modal = document.getElementById("editModal");
    let openModalBtn = document.getElementById("openModal");
    let closeModalBtn = document.querySelector(".close");
    let saveChangesBtn = document.getElementById("saveChanges");

    // Open modal and populate fields
    openModalBtn.addEventListener("click", function() {
        modal.style.display = "block";

        // Populate modal fields with existing values
        document.getElementById("editRegistryID").value = document.getElementById("registryID").value;
        document.getElementById("editDob").value = document.getElementById("dob").value;
        document.getElementById("editTagID").value = document.getElementById("tagID").value;
        document.getElementById("editSex").value = document.getElementById("sex").value;

        document.getElementById("editSireRegistryID").value = document.getElementById("sireRegistryID").value;
        document.getElementById("editSireName").value = document.getElementById("sireName").value;
        document.getElementById("editSireBreed").value = document.getElementById("sireBreed").value;

        document.getElementById("editDamRegistryID").value = document.getElementById("damRegistryID").value;
        document.getElementById("editDamName").value = document.getElementById("damName").value;
        document.getElementById("editDamBreed").value = document.getElementById("damBreed").value;

        document.getElementById("editCharacteristics").value = document.getElementById("characteristics").value;
        document.getElementById("editPropertyNo").value = document.getElementById("propertyNo").value;
        document.getElementById("editCooperator").value = document.getElementById("cooperator").value;
        document.getElementById("editDateAcquired").value = document.getElementById("dateAcquired").value;
        document.getElementById("editDateReleased").value = document.getElementById("dateReleased").value;
        document.getElementById("editCost").value = document.getElementById("cost").value;
        document.getElementById("editRemarks").value = document.getElementById("remarks").value;
    });

    // Close modal when clicking "X"
    closeModalBtn.addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Save changes and update main form
    saveChangesBtn.addEventListener("click", function() {
        document.getElementById("registryID").value = document.getElementById("editRegistryID").value;
        document.getElementById("dob").value = document.getElementById("editDob").value;
        document.getElementById("tagID").value = document.getElementById("editTagID").value;
        document.getElementById("sex").value = document.getElementById("editSex").value;

        document.getElementById("sireRegistryID").value = document.getElementById("editSireRegistryID").value;
        document.getElementById("sireName").value = document.getElementById("editSireName").value;
        document.getElementById("sireBreed").value = document.getElementById("editSireBreed").value;

        document.getElementById("damRegistryID").value = document.getElementById("editDamRegistryID").value;
        document.getElementById("damName").value = document.getElementById("editDamName").value;
        document.getElementById("damBreed").value = document.getElementById("editDamBreed").value;

        document.getElementById("characteristics").value = document.getElementById("editCharacteristics").value;
        document.getElementById("propertyNo").value = document.getElementById("editPropertyNo").value;
        document.getElementById("cooperator").value = document.getElementById("editCooperator").value;
        document.getElementById("dateAcquired").value = document.getElementById("editDateAcquired").value;
        document.getElementById("dateReleased").value = document.getElementById("editDateReleased").value;
        document.getElementById("cost").value = document.getElementById("editCost").value;
        document.getElementById("remarks").value = document.getElementById("editRemarks").value;

        modal.style.display = "none";
    });

    // Close modal when clicking outside of it
    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("growthModal");  // Fixed modal ID
    const openModalBtn = document.getElementById("openGrowthModal"); 
    const closeModalBtn = document.getElementById("closeGrowthModal");

    if (openModalBtn) {
        openModalBtn.addEventListener("click", function () {
            modal.style.display = "flex";  // Show modal
        });
    }

    closeModalBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const calvingModal = document.getElementById("calvingModal");
    const openCalvingModalBtn = document.getElementById("openCalvingModal"); 
    const closeCalvingModalBtn = document.getElementById("closeCalvingModal");

    if (calvingModal) {
        calvingModal.style.display = "none"; // Ensure it starts hidden

        if (openCalvingModalBtn) {
            openCalvingModalBtn.addEventListener("click", function () {
                calvingModal.style.display = "flex"; 
            });
        }

        if (closeCalvingModalBtn) {
            closeCalvingModalBtn.addEventListener("click", function () {
                calvingModal.style.display = "none";
            });
        }

        window.addEventListener("click", function (event) {
            if (event.target === calvingModal) {
                calvingModal.style.display = "none";
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Get the current animal ID (you would get this from your system)
    const currentAnimalId = 'ANIMAL123'; // Replace with actual animal ID
    
    // Modal handling for growth records
    const growthModal = document.getElementById("growthModal");
    const openGrowthModalBtn = document.getElementById("openGrowthModal"); 
    const closeGrowthModalBtn = document.getElementById("closeGrowthModal");
    const growthForm = document.getElementById("growthForm");
    
    // Modal handling for calving records
    const calvingModal = document.getElementById("calvingModal");
    const openCalvingModalBtn = document.getElementById("openCalvingModal"); 
    const closeCalvingModalBtn = document.getElementById("closeCalvingModal");
    const calvingForm = document.getElementById("calvingForm");
    
    // Initialize modals
    if (growthModal) growthModal.style.display = "none";
    if (calvingModal) calvingModal.style.display = "none";
    
    // Open/close growth modal
    if (openGrowthModalBtn) {
        openGrowthModalBtn.addEventListener("click", function () {
            if (growthModal) growthModal.style.display = "flex";
        });
    }
    if (closeGrowthModalBtn) {
        closeGrowthModalBtn.addEventListener("click", function () {
            if (growthModal) growthModal.style.display = "none";
        });
    }
    
    // Open/close calving modal
    if (openCalvingModalBtn) {
        openCalvingModalBtn.addEventListener("click", function () {
            if (calvingModal) calvingModal.style.display = "flex";
        });
    }
    if (closeCalvingModalBtn) {
        closeCalvingModalBtn.addEventListener("click", function () {
            if (calvingModal) calvingModal.style.display = "none";
        });
    }
    
    // Close modals when clicking outside
    window.addEventListener("click", function (event) {
        if (growthModal && event.target === growthModal) {
            growthModal.style.display = "none";
        }
        if (calvingModal && event.target === calvingModal) {
            calvingModal.style.display = "none";
        }
    });
    
    // Handle growth form submission
    if (growthForm) {
        growthForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            const formData = {
                animal_id: currentAnimalId,
                record_date: document.getElementById("date").value,
                weight_kg: document.getElementById("weight").value,
                height_cm: document.getElementById("height").value,
                heart_girth_cm: document.getElementById("girth").value,
                body_length_cm: document.getElementById("length").value
            };
            
            submitFormData('add_growth_record', formData, growthModal, growthForm);
        });
    }
    
    // Handle calving form submission
    if (calvingForm) {
        calvingForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            const formData = {
                animal_id: currentAnimalId,
                calving_date: document.getElementById("calvingDate").value,
                calf_id: document.getElementById("calfID").value,
                calf_sex: document.getElementById("calfSex").value,
                calf_breed: document.getElementById("calfBreed").value,
                sire_id: document.getElementById("sireID").value,
                milk_production: document.getElementById("milkProduction").value,
                days_in_milk: document.getElementById("daysInMilk").value
            };
            
            submitFormData('add_calving_record', formData, calvingModal, calvingForm);
        });
    }
    
    // Function to submit form data
    function submitFormData(action, formData, modal, form) {
        fetch('growth_records_backend.php?action=' + action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (modal) modal.style.display = "none";
                    if (form) form.reset();
                    loadRecords(); // Refresh the records
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while submitting the form',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // Function to load and display records
    function loadRecords() {
        // Load growth records
        fetch(`growth_records_backend.php?action=get_growth_records&animal_id=${currentAnimalId}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector(".order:first-child table tbody");
                if (tbody) {
                    tbody.innerHTML = '';
                    
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5">No growth records found</td></tr>';
                        return;
                    }
                    
                    data.forEach(record => {
                        const row = `
                            <tr>
                                <td>${record.record_date}</td>
                                <td>${record.weight_kg} kg</td>
                                <td>${record.height_cm} cm</td>
                                <td>${record.heart_girth_cm} cm</td>
                                <td>${record.body_length_cm} cm</td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                }
            });
        
        // Load calving records
        fetch(`growth_records_backend.php?action=get_calving_records&animal_id=${currentAnimalId}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector(".order:last-child table tbody");
                if (tbody) {
                    tbody.innerHTML = '';
                    
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="7">No calving records found</td></tr>';
                        return;
                    }
                    
                    data.forEach(record => {
                        const row = `
                            <tr>
                                <td>${record.calving_date}</td>
                                <td>${record.calf_id}</td>
                                <td>${record.calf_sex}</td>
                                <td>${record.calf_breed}</td>
                                <td>${record.sire_id}</td>
                                <td>${record.milk_production} L/day</td>
                                <td>${record.days_in_milk} days</td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                }
            });
    }
    
    // Initial load of records
    loadRecords();
})



document.addEventListener("DOMContentLoaded", function () {
    const breedingModal = document.getElementById("breedingModal");
    const openBreedingModalBtn = document.getElementById("openBreedingModal"); 
    const closeBreedingModalBtn = document.getElementById("closeBreedingModal");

    if (breedingModal) {
        breedingModal.style.display = "none"; // Ensure it starts hidden

        if (openBreedingModalBtn) {
            openBreedingModalBtn.addEventListener("click", function () {
                breedingModal.style.display = "flex"; 
            });
        }

        if (closeBreedingModalBtn) {
            closeBreedingModalBtn.addEventListener("click", function () {
                breedingModal.style.display = "none";
            });
        }

        window.addEventListener("click", function (event) {
            if (event.target === breedingModal) {
                breedingModal.style.display = "none";
            }
        });
    }
});


document.getElementById("breedingForm").addEventListener("submit", function (e) {
    e.preventDefault();

    // Get values
    const serviceDate = document.getElementById("serviceDate").value;
    const bcs = parseFloat(document.getElementById("bcs").value);
    const vo = parseInt(document.getElementById("vo").value);
    const ut = parseInt(document.getElementById("ut").value);
    const md = parseInt(document.getElementById("md").value);
    const serviceType = document.getElementById("serviceType").value;
    const bullId = document.getElementById("bullId").value.trim();
    const pdName = document.getElementById("pdName").value.trim();
    const pdDate = document.getElementById("pdDate").value;
    const result = document.getElementById("result").value;
    const aiTech = document.getElementById("aiTech").value.trim();

    // Add record to the table
    const breedingTable = document.querySelector("#breedingTable tbody");
    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>${serviceDate}</td>
        <td>${bcs.toFixed(1)}</td>
        <td>${vo}</td>
        <td>${ut}</td>
        <td>${md}</td>
        <td>${serviceType}</td>
        <td>${bullId}</td>
        <td>${pdName}</td>
        <td>${pdDate}</td>
        <td>${result}</td>
        <td>${aiTech}</td>
    `;
    breedingTable.appendChild(newRow);

    alert("Breeding/AI Record saved successfully!");

    // Reset form
    document.getElementById("breedingForm").reset();
});


document.addEventListener("DOMContentLoaded", function () {
    const healthModal = document.getElementById("healthModal");
    const openhealthModalBtn = document.getElementById("openhealthModal"); 
    const closehealthModalBtn = document.getElementById("closehealthModal");

    if (healthModal) {
        healthModal.style.display = "none"; // Ensure it starts hidden

        if (openhealthModalBtn) {
            openhealthModalBtn.addEventListener("click", function () {
                healthModal.style.display = "flex"; 
            });
        }

        if (closehealthModalBtn) {
            closehealthModalBtn.addEventListener("click", function () {
                healthModal.style.display = "none";
            });
        }

        window.addEventListener("click", function (event) {
            if (event.target === healthModal) {
                healthModal.style.display = "none";
            }
        });
    }
});