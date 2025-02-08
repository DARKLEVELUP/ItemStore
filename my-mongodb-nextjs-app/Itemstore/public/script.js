document.addEventListener("DOMContentLoaded", function() {
    function formatDateForInput(dateString) {
        const date = new Date(dateString);
        let day = date.getDate();
        let month = date.getMonth() + 1; // Months are zero-based
        let year = date.getFullYear();

        // Add leading zeros to day and month if necessary
        if (day < 10) {
            day = '0' + day;
        }
        if (month < 10) {
            month = '0' + month;
        }

        return `${year}-${month}-${day}`;
    }

    window.showUpdateForm = function(id, name, date_bought, check_date, warranty_years, expiry_date) {
        document.getElementById('update_id').value = id;
        document.getElementById('update_name').value = name;
        document.getElementById('update_date_bought').value = date_bought;
        document.getElementById('update_check_date').value = check_date;
        document.getElementById('update_warranty_years').value = warranty_years;
        document.getElementById('update_expiry_date').value = expiry_date;
        document.getElementById('updateForm').style.display = 'block';
    }

    function changeItemsPerPage() {
        const itemsPerPage = document.getElementById('itemsPerPage').value;
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('itemsPerPage', itemsPerPage);
        window.location.search = searchParams.toString();
    }

    document.getElementById('itemsPerPage').addEventListener('change', changeItemsPerPage);

    fetchItems();
});