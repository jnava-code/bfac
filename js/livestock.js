    // Open modal
    document.getElementById("openLivestockModal").addEventListener("click", function () {
        document.getElementById("addLivestockModal").style.display = "block";
    });

    // Close modal
    document.getElementById("closeLivestockModal").addEventListener("click", function () {
        document.getElementById("addLivestockModal").style.display = "none";
    });

    // Optional: Close modal if clicked outside the modal box
    window.addEventListener("click", function (e) {
        const modal = document.getElementById("addLivestockModal");
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });


    const openBtn = document.getElementById('openLivestockModal');
const closeBtn = document.getElementById('closeLivestockModal');
const modal = document.getElementById('addLivestockModal');

// Open modal
openBtn.addEventListener('click', () => {
    modal.classList.add('show');
});

// Close modal
closeBtn.addEventListener('click', () => {
    modal.classList.remove('show');
});

// Close when clicking outside the modal content
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.remove('show');
    }
});

// Sample data
const livestockData = [
    {
        id: 'LS-001',
        image: 'img/cow1.jpg',
        issuanceDate: '2025-03-10',
        breed: 'Angus',
        sex: 'Female',
        quantity: 3,
        grantedBy: 'John Doe',
        projectName: 'AgriSupport 2025'
    },
    {
        id: 'LS-002',
        image: 'img/goat1.jpg',
        issuanceDate: '2025-04-02',
        breed: 'Boer Goat',
        sex: 'Male',
        quantity: 2,
        grantedBy: 'Jane Smith',
        projectName: 'Livestock Boost'
    }
];

// Populate the table
const tableBody = document.getElementById('livestockTableBody');

livestockData.forEach(livestock => {
    const row = document.createElement('tr');

    row.innerHTML = `
        <td>${livestock.id}</td>
        <td><img src="${livestock.image}" alt="Livestock" width="50"></td>
        <td>${livestock.issuanceDate}</td>
        <td>${livestock.breed}</td>
        <td>${livestock.sex}</td>
        <td>${livestock.quantity}</td>
        <td>${livestock.grantedBy}</td>
        <td>${livestock.projectName}</td>
        <td><button>Edit</button></td>
        <td><button>View</button></td>
    `;

    tableBody.appendChild(row);
});
