document.querySelectorAll('.icon-edit').forEach(button => {
    button.addEventListener('click', function () {
        const row = this.closest('tr');
        document.getElementById('modalOrderNo').value = row.cells[0].innerText;
        document.getElementById('modalCustomer').value = row.cells[1].innerText;
        document.getElementById('modalProduct').value = row.cells[2].innerText;
        document.getElementById('modalQuantity').value = row.cells[3].innerText;
        document.getElementById('modalAddress').value = row.cells[4].innerText;
        document.getElementById('modalDate').value = row.cells[6].innerText;

        const currentStatus = row.querySelector('.status').innerText.trim();
        document.getElementById('statusSelect').value = currentStatus;

        document.getElementById('statusModal').style.display = 'flex';
    });
});

document.querySelector('.close').onclick = () => {
    document.getElementById('statusModal').style.display = 'none';
};

document.getElementById('statusForm').onsubmit = (e) => {
    e.preventDefault();

    const status = document.getElementById('statusSelect').value;
    const orderNo = document.getElementById('modalOrderNo').value;

    // Update the row in the table
    document.querySelectorAll('tbody tr').forEach(row => {
        if (row.cells[0].innerText === orderNo) {
            row.cells[5].innerHTML = `<span class='status ${status.toLowerCase().replace(/ /g, "-")}'>${status}</span>`;
        }
    });

    document.getElementById('statusModal').style.display = 'none';
};