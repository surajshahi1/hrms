<?php
$pageTitle = "Personnel Directory";
$pageSubtitle = "Complete list of commissioned officers and jawans.";
$activePage = "personnel";

// Prepare the content
ob_start();
?>

<!-- Search and Add Personnel Section -->
<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap;">
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Search by name, service no., rank or branch...">
        <button id="clearSearch" class="clear-search" style="display: none;">✕</button>
    </div>
    <button class="btn-add" id="addPersonnelBtn">
        <i class="fas fa-user-plus"></i> Add Personnel
    </button>
</div>

<div class="data-table">
    <table id="personnelTable">
        <thead>
            <tr>
                <th style="width: 60px;">S.No.</th>
                <th>Service No.</th>
                <th>Name</th>
                <th>Rank</th>
                <th>Branch</th>
                <th>Status</th>
                <th style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody id="personnelTableBody">
            <tr>
                <td>1</td>
                <td>IC-45231</td>
                <td>Col. Rajesh Kumar</td>
                <td>Colonel</td>
                <td>Infantry</td>
                <td><span class="badge">Active</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>IC-48912</td>
                <td>Lt. Col. Meera Nair</td>
                <td>Lieutenant Colonel</td>
                <td>Signals</td>
                <td><span class="badge">Active</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>JC-22145</td>
                <td>Subedar Major Harpal</td>
                <td>Subedar Major</td>
                <td>Artillery</td>
                <td><span class="badge">Active</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>4</td>
                <td>IC-50234</td>
                <td>Major Rohan Joshi</td>
                <td>Major</td>
                <td>Armoured Corps</td>
                <td><span class="badge leave">Leave</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>5</td>
                <td>JC-18903</td>
                <td>Havildar Suresh</td>
                <td>Havildar</td>
                <td>Infantry</td>
                <td><span class="badge">Active</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>6</td>
                <td>IC-56789</td>
                <td>Capt. Priya Sharma</td>
                <td>Captain</td>
                <td>Medical Corps</td>
                <td><span class="badge">Active</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>7</td>
                <td>JC-33456</td>
                <td>Naik Amarjeet</td>
                <td>Naik</td>
                <td>Engineers</td>
                <td><span class="badge leave">Leave</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>8</td>
                <td>IC-67890</td>
                <td>Lt. Arjun Reddy</td>
                <td>Lieutenant</td>
                <td>Infantry</td>
                <td><span class="badge">Active</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- No Results Message -->
<div id="noResults" style="display: none; text-align: center; padding: 40px; color: #6c7a8e;">
    <i class="fas fa-search" style="font-size: 48px; margin-bottom: 10px;"></i>
    <p>No personnel found matching your search criteria.</p>
</div>

<!-- Modal for Add/Edit Personnel -->
<div id="personnelModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle"><i class="fas fa-user-plus"></i> Add New Personnel</h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="personnelForm">
                <div class="form-grid">
                    <div class="input-field">
                        <label><i class="fas fa-id-card"></i> Service No. <span class="required-star">*</span></label>
                        <input type="text" id="serviceNo" placeholder="e.g., IC-12345" required>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-user"></i> Full Name <span class="required-star">*</span></label>
                        <input type="text" id="fullName" placeholder="e.g., Col. Rajesh Kumar" required>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-star-of-life"></i> Rank <span class="required-star">*</span></label>
                        <select id="rank" required>
                            <option value="" disabled selected>Select rank</option>
                            <option>General</option>
                            <option>Lieutenant General</option>
                            <option>Major General</option>
                            <option>Brigadier</option>
                            <option>Colonel</option>
                            <option>Lieutenant Colonel</option>
                            <option>Major</option>
                            <option>Captain</option>
                            <option>Lieutenant</option>
                            <option>Subedar Major</option>
                            <option>Subedar</option>
                            <option>Naib Subedar</option>
                            <option>Havildar</option>
                            <option>Naik</option>
                            <option>Lance Naik</option>
                            <option>Sepoy</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-gun"></i> Branch <span class="required-star">*</span></label>
                        <select id="branch" required>
                            <option value="" disabled selected>Select branch</option>
                            <option>Infantry</option>
                            <option>Armoured Corps</option>
                            <option>Artillery</option>
                            <option>Corps of Engineers</option>
                            <option>Signals</option>
                            <option>Army Aviation</option>
                            <option>Intelligence</option>
                            <option>Medical Corps</option>
                            <option>Ordnance</option>
                            <option>EME</option>
                            <option>Education Corps</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-calendar"></i> Date of Commission <span class="required-star">*</span></label>
                        <input type="date" id="commissionDate" required>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-flag-checkered"></i> Status <span class="required-star">*</span></label>
                        <select id="status" required>
                            <option value="Active">Active</option>
                            <option value="Leave">Leave</option>
                            <option value="Retired">Retired</option>
                            <option value="Training">Training</option>
                        </select>
                    </div>
                    <div class="input-field full-width">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" placeholder="official@army.in">
                    </div>
                    <div class="input-field full-width">
                        <label><i class="fas fa-phone"></i> Contact Number</label>
                        <input type="tel" id="contact" placeholder="+91 XXXXX XXXXX">
                    </div>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn-submit">Save Personnel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Search Container Styles */
    .search-container {
        position: relative;
        flex: 1;
        max-width: 400px;
    }
    
    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa9bc;
        font-size: 14px;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 35px 10px 38px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        outline: none;
    }
    
    .search-input:focus {
        border-color: #2c5f4e;
        box-shadow: 0 0 0 3px rgba(44, 95, 78, 0.08);
    }
    
    .clear-search {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9aa9bc;
        font-size: 14px;
        padding: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    
    .clear-search:hover {
        background: #e2e8f0;
        color: #c2410c;
    }
    
    /* Button Styles */
    .btn-add {
        background: #1e3a32;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    
    .btn-add:hover {
        background: #14362c;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Action Buttons */
    .btn-icon {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px 8px;
        margin: 0 3px;
        border-radius: 4px;
        transition: all 0.2s;
        font-size: 14px;
    }
    
    .edit-btn {
        color: #2c5f4e;
    }
    
    .edit-btn:hover {
        background: #e8f5f0;
        transform: scale(1.1);
    }
    
    .delete-btn {
        color: #c2410c;
    }
    
    .delete-btn:hover {
        background: #fff0ed;
        transform: scale(1.1);
    }
    
    /* Table Styles */
    .data-table table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        text-align: left;
        padding: 12px;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        font-weight: 600;
        color: #1a2c3e;
    }
    
    .data-table td {
        padding: 12px;
        border-bottom: 1px solid #eef2f6;
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s;
    }
    
    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        width: 90%;
        max-width: 700px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        animation: slideDown 0.3s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-header h3 {
        margin: 0;
        color: #1a2c3e;
        font-size: 20px;
    }
    
    .close {
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #9aa9bc;
        transition: 0.2s;
    }
    
    .close:hover {
        color: #c2410c;
    }
    
    .modal-body {
        padding: 24px;
        max-height: 70vh;
        overflow-y: auto;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .input-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .input-field label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }
    
    .input-field input, .input-field select {
        padding: 10px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        outline: none;
    }
    
    .input-field input:focus, .input-field select:focus {
        border-color: #2c5f4e;
        box-shadow: 0 0 0 3px rgba(44, 95, 78, 0.08);
    }
    
    .full-width {
        grid-column: span 2;
    }
    
    .required-star {
        color: #c2410c;
    }
    
    .modal-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #eef2f6;
    }
    
    .btn-cancel {
        padding: 10px 20px;
        background: #f1f3f5;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: 0.2s;
    }
    
    .btn-cancel:hover {
        background: #e9ecef;
    }
    
    .btn-submit {
        padding: 10px 24px;
        background: #1e3a32;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
    }
    
    .btn-submit:hover {
        background: #14362c;
    }
    
    /* Highlight matching text */
    .highlight {
        background-color: #fef3c7;
        font-weight: 600;
    }
    
    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .full-width {
            grid-column: span 1;
        }
        .modal-content {
            margin: 10% auto;
            width: 95%;
        }
        .search-container {
            max-width: 100%;
        }
    }
</style>

<script>
    // Modal elements
    const modal = document.getElementById('personnelModal');
    const addBtn = document.getElementById('addPersonnelBtn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelBtn');
    const modalTitle = document.getElementById('modalTitle');
    const form = document.getElementById('personnelForm');
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearch');
    const tableBody = document.getElementById('personnelTableBody');
    const noResultsDiv = document.getElementById('noResults');
    const table = document.getElementById('personnelTable');
    
    let isEditing = false;
    let editingRow = null;
    
    // Function to update serial numbers
    function updateSerialNumbers() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }
    
    // Search functionality
    function searchTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const rows = tableBody.querySelectorAll('tr');
        let hasResults = false;
        
        rows.forEach(row => {
            const serviceNo = row.cells[1].textContent.toLowerCase();
            const name = row.cells[2].textContent.toLowerCase();
            const rank = row.cells[3].textContent.toLowerCase();
            const branch = row.cells[4].textContent.toLowerCase();
            
            const matches = searchTerm === '' || 
                           serviceNo.includes(searchTerm) || 
                           name.includes(searchTerm) || 
                           rank.includes(searchTerm) || 
                           branch.includes(searchTerm);
            
            if (matches) {
                row.style.display = '';
                hasResults = true;
                
                // Highlight matching text if search term exists
                if (searchTerm !== '') {
                    highlightText(row.cells[1], searchTerm);
                    highlightText(row.cells[2], searchTerm);
                    highlightText(row.cells[3], searchTerm);
                    highlightText(row.cells[4], searchTerm);
                } else {
                    removeHighlight(row.cells[1]);
                    removeHighlight(row.cells[2]);
                    removeHighlight(row.cells[3]);
                    removeHighlight(row.cells[4]);
                }
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (!hasResults && searchTerm !== '') {
            noResultsDiv.style.display = 'block';
            table.style.display = 'none';
        } else {
            noResultsDiv.style.display = 'none';
            table.style.display = 'table';
        }
        
        // Show/hide clear button
        clearSearchBtn.style.display = searchTerm !== '' ? 'block' : 'none';
    }
    
    // Highlight text function
    function highlightText(cell, searchTerm) {
        const originalText = cell.textContent;
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        if (originalText.toLowerCase().includes(searchTerm)) {
            cell.innerHTML = originalText.replace(regex, '<span class="highlight">$1</span>');
        }
    }
    
    // Remove highlight function
    function removeHighlight(cell) {
        cell.innerHTML = cell.textContent;
    }
    
    // Clear search
    function clearSearch() {
        searchInput.value = '';
        searchTable();
        searchInput.focus();
    }
    
    // Event listeners for search
    searchInput.addEventListener('input', searchTable);
    clearSearchBtn.addEventListener('click', clearSearch);
    
    // Open modal for adding
    addBtn.onclick = function() {
        isEditing = false;
        editingRow = null;
        modalTitle.innerHTML = '<i class="fas fa-user-plus"></i> Add New Personnel';
        form.reset();
        modal.style.display = 'block';
    }
    
    // Close modal
    function closeModal() {
        modal.style.display = 'none';
        form.reset();
        isEditing = false;
        editingRow = null;
    }
    
    closeBtn.onclick = closeModal;
    cancelBtn.onclick = closeModal;
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
    
    // Edit personnel function
    function editPersonnel(button) {
        const row = button.closest('tr');
        const cells = row.cells;
        
        isEditing = true;
        editingRow = row;
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Personnel';
        
        // Fill form with existing data
        document.getElementById('serviceNo').value = cells[1].textContent;
        document.getElementById('fullName').value = cells[2].textContent;
        document.getElementById('rank').value = cells[3].textContent;
        document.getElementById('branch').value = cells[4].textContent;
        
        const statusSpan = cells[5].querySelector('span');
        document.getElementById('status').value = statusSpan.textContent;
        
        modal.style.display = 'block';
    }
    
    // Delete personnel function
    function deletePersonnel(button) {
        const row = button.closest('tr');
        const serviceNo = row.cells[1].textContent;
        const name = row.cells[2].textContent;
        
        if(confirm(`Are you sure you want to delete ${name} (${serviceNo})?`)) {
            row.remove();
            updateSerialNumbers();
            showToast(`Personnel ${name} deleted successfully`, 'success');
            searchTable(); // Refresh search results
        }
    }
    
    // Handle form submission
    form.onsubmit = function(e) {
        e.preventDefault();
        
        // Get form values
        const serviceNo = document.getElementById('serviceNo').value;
        const fullName = document.getElementById('fullName').value;
        const rank = document.getElementById('rank').value;
        const branch = document.getElementById('branch').value;
        const status = document.getElementById('status').value;
        
        // Validate
        if(!serviceNo || !fullName || !rank || !branch || !status) {
            showToast('Please fill all required fields', 'error');
            return;
        }
        
        const statusClass = status === 'Active' ? 'badge' : 'badge leave';
        const statusHtml = `<span class="${statusClass}">${status}</span>`;
        
        if(isEditing && editingRow) {
            // Update existing row
            editingRow.cells[1].textContent = serviceNo;
            editingRow.cells[2].textContent = fullName;
            editingRow.cells[3].textContent = rank;
            editingRow.cells[4].textContent = branch;
            editingRow.cells[5].innerHTML = statusHtml;
            showToast(`Personnel ${fullName} updated successfully`, 'success');
        } else {
            // Add new row
            const newRow = tableBody.insertRow();
            const newIndex = tableBody.rows.length;
            newRow.innerHTML = `
                <td>${newIndex}</td>
                <td>${serviceNo}</td>
                <td>${fullName}</td>
                <td>${rank}</td>
                <td>${branch}</td>
                <td>${statusHtml}</td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editPersonnel(this)"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete-btn" onclick="deletePersonnel(this)"><i class="fas fa-trash"></i></button>
                </td>
            `;
            updateSerialNumbers();
            showToast(`Personnel ${fullName} added successfully`, 'success');
        }
        
        closeModal();
        searchTable(); // Refresh search if needed
    }
</script>

<?php
$content = ob_get_clean();
include('includes/layout.php');
?>