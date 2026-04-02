<?php
$pageTitle = "Attendance Register";
$pageSubtitle = "Monthly attendance summary for personnel.";
$activePage = "attendance";

// Prepare the content
ob_start();
?>

<!-- Search and Action Section -->
<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap;">
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Search by name or rank...">
        <button id="clearSearch" class="clear-search" style="display: none;">✕</button>
    </div>
    <div style="display: flex; gap: 10px;">
        <button class="btn-add" id="markAttendanceBtn">
            <i class="fas fa-calendar-check"></i> Mark Attendance
        </button>
        <button class="btn-export" id="exportBtn">
            <i class="fas fa-download"></i> Export
        </button>
    </div>
</div>

<div class="data-table">
    <table id="attendanceTable">
        <thead>
            <tr>
                <th style="width: 60px;">S.No.</th>
                <th>Name</th>
                <th>Rank</th>
                <th>Present Days</th>
                <th>Absent</th>
                <th>Attendance %</th>
                <th style="width: 100px;">Status</th>
                <th style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody id="attendanceTableBody">
            <tr>
                <td>1</td>
                <td>Vikram Rathore</td>
                <td>Major</td>
                <td>24</td>
                <td>1</td>
                <td>96%</td>
                <td><span class="badge badge-good">Good</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editAttendance(this)"><i class="fas fa-edit"></i></button>
                 </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Anjali Sharma</td>
                <td>Captain</td>
                <td>25</td>
                <td>0</td>
                <td>100%</td>
                <td><span class="badge badge-excellent">Excellent</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editAttendance(this)"><i class="fas fa-edit"></i></button>
                 </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Baldev Singh</td>
                <td>Subedar</td>
                <td>18</td>
                <td>7</td>
                <td>72%</td>
                <td><span class="badge badge-warning">Needs Improvement</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editAttendance(this)"><i class="fas fa-edit"></i></button>
                 </td>
            </tr>
            <tr>
                <td>4</td>
                <td>Arjun Mehta</td>
                <td>Lieutenant</td>
                <td>23</td>
                <td>2</td>
                <td>92%</td>
                <td><span class="badge badge-good">Good</span></td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editAttendance(this)"><i class="fas fa-edit"></i></button>
                 </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- No Results Message -->
<div id="noResults" style="display: none; text-align: center; padding: 40px; color: #6c7a8e;">
    <i class="fas fa-search" style="font-size: 48px; margin-bottom: 10px;"></i>
    <p>No attendance records found matching your search criteria.</p>
</div>

<!-- Modal for Mark/Edit Attendance -->
<div id="attendanceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle"><i class="fas fa-calendar-check"></i> Mark Attendance</h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="attendanceForm">
                <div class="form-grid">
                    <div class="input-field">
                        <label><i class="fas fa-user"></i> Personnel Name <span class="required-star">*</span></label>
                        <select id="personnelName" required>
                            <option value="" disabled selected>Select personnel</option>
                            <option>Vikram Rathore</option>
                            <option>Anjali Sharma</option>
                            <option>Baldev Singh</option>
                            <option>Arjun Mehta</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-star-of-life"></i> Rank <span class="required-star">*</span></label>
                        <input type="text" id="rank" readonly style="background: #f8fafc;">
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-calendar-week"></i> Month <span class="required-star">*</span></label>
                        <select id="month" required>
                            <option value="" disabled selected>Select month</option>
                            <option>January</option><option>February</option><option>March</option>
                            <option>April</option><option>May</option><option>June</option>
                            <option>July</option><option>August</option><option>September</option>
                            <option>October</option><option>November</option><option>December</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-calendar"></i> Year <span class="required-star">*</span></label>
                        <select id="year" required>
                            <option>2024</option>
                            <option selected>2025</option>
                            <option>2026</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-check-circle"></i> Present Days <span class="required-star">*</span></label>
                        <input type="number" id="presentDays" min="0" max="31" placeholder="e.g., 24" required>
                    </div>
                    <div class="input-field">
                        <label><i class="fas fa-times-circle"></i> Absent Days <span class="required-star">*</span></label>
                        <input type="number" id="absentDays" min="0" max="31" placeholder="e.g., 1" required>
                    </div>
                    <div class="input-field full-width">
                        <label><i class="fas fa-chart-line"></i> Attendance Percentage</label>
                        <input type="text" id="attendancePercent" readonly style="background: #f8fafc; font-weight: 600;">
                    </div>
                    <div class="input-field full-width">
                        <label><i class="fas fa-sticky-note"></i> Remarks (Optional)</label>
                        <textarea id="remarks" rows="3" placeholder="Any additional notes..."></textarea>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn-submit">Save Attendance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="summary-cards" style="margin-top: 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
    <div class="summary-card">
        <div class="summary-icon"><i class="fas fa-users"></i></div>
        <div class="summary-info">
            <div class="summary-label">Total Personnel</div>
            <div class="summary-value" id="totalPersonnel">4</div>
        </div>
    </div>
    <div class="summary-card">
        <div class="summary-icon"><i class="fas fa-chart-line"></i></div>
        <div class="summary-info">
            <div class="summary-label">Average Attendance</div>
            <div class="summary-value" id="avgAttendance">90%</div>
        </div>
    </div>
    <div class="summary-card">
        <div class="summary-icon"><i class="fas fa-trophy"></i></div>
        <div class="summary-info">
            <div class="summary-label">Excellent (>90%)</div>
            <div class="summary-value" id="excellentCount">2</div>
        </div>
    </div>
    <div class="summary-card">
        <div class="summary-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="summary-info">
            <div class="summary-label">Needs Improvement (<75%)</div>
            <div class="summary-value" id="needsImprovementCount">1</div>
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
    .btn-add, .btn-export {
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    
    .btn-add {
        background: #1e3a32;
        color: white;
    }
    
    .btn-add:hover {
        background: #14362c;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-export {
        background: #2c5f4e;
        color: white;
    }
    
    .btn-export:hover {
        background: #1e4a3a;
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
    
    /* Badge Styles */
    .badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-excellent {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-good {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .badge-warning {
        background: #fed7aa;
        color: #9a3412;
    }
    
    /* Summary Cards */
    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid #eef2f6;
    }
    
    .summary-icon {
        width: 48px;
        height: 48px;
        background: #f0fdf4;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #2c5f4e;
    }
    
    .summary-info {
        flex: 1;
    }
    
    .summary-label {
        font-size: 12px;
        color: #6c7a8e;
        margin-bottom: 4px;
    }
    
    .summary-value {
        font-size: 24px;
        font-weight: 700;
        color: #1a2c3e;
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
    
    .input-field input, .input-field select, .input-field textarea {
        padding: 10px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        outline: none;
        font-family: inherit;
    }
    
    .input-field input:focus, .input-field select:focus, .input-field textarea:focus {
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
        .summary-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    // Personnel data mapping
    const personnelData = {
        'Vikram Rathore': { rank: 'Major' },
        'Anjali Sharma': { rank: 'Captain' },
        'Baldev Singh': { rank: 'Subedar' },
        'Arjun Mehta': { rank: 'Lieutenant' }
    };
    
    // Modal elements
    const modal = document.getElementById('attendanceModal');
    const markBtn = document.getElementById('markAttendanceBtn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelBtn');
    const modalTitle = document.getElementById('modalTitle');
    const form = document.getElementById('attendanceForm');
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearch');
    const tableBody = document.getElementById('attendanceTableBody');
    const noResultsDiv = document.getElementById('noResults');
    const table = document.getElementById('attendanceTable');
    
    let isEditing = false;
    let editingRow = null;
    
    // Calculate attendance percentage
    function calculatePercentage() {
        const present = parseInt(document.getElementById('presentDays').value) || 0;
        const absent = parseInt(document.getElementById('absentDays').value) || 0;
        const total = present + absent;
        
        if (total > 0) {
            const percentage = ((present / total) * 100).toFixed(1);
            document.getElementById('attendancePercent').value = `${percentage}%`;
            return percentage;
        }
        return 0;
    }
    
    // Get status badge based on percentage
    function getStatusBadge(percentage) {
        const percent = parseFloat(percentage);
        if (percent >= 90) {
            return '<span class="badge badge-excellent">Excellent</span>';
        } else if (percent >= 75) {
            return '<span class="badge badge-good">Good</span>';
        } else {
            return '<span class="badge badge-warning">Needs Improvement</span>';
        }
    }
    
    // Update summary statistics
    function updateSummary() {
        const rows = tableBody.querySelectorAll('tr');
        let totalPercent = 0;
        let excellentCount = 0;
        let needsImprovementCount = 0;
        
        rows.forEach(row => {
            const percentCell = row.cells[5].textContent;
            const percent = parseFloat(percentCell);
            totalPercent += percent;
            
            if (percent >= 90) excellentCount++;
            if (percent < 75) needsImprovementCount++;
        });
        
        const avgAttendance = rows.length > 0 ? (totalPercent / rows.length).toFixed(1) : 0;
        
        document.getElementById('totalPersonnel').textContent = rows.length;
        document.getElementById('avgAttendance').textContent = `${avgAttendance}%`;
        document.getElementById('excellentCount').textContent = excellentCount;
        document.getElementById('needsImprovementCount').textContent = needsImprovementCount;
    }
    
    // Update serial numbers
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
            const name = row.cells[1].textContent.toLowerCase();
            const rank = row.cells[2].textContent.toLowerCase();
            
            const matches = searchTerm === '' || name.includes(searchTerm) || rank.includes(searchTerm);
            
            if (matches) {
                row.style.display = '';
                hasResults = true;
                
                if (searchTerm !== '') {
                    highlightText(row.cells[1], searchTerm);
                    highlightText(row.cells[2], searchTerm);
                } else {
                    removeHighlight(row.cells[1]);
                    removeHighlight(row.cells[2]);
                }
            } else {
                row.style.display = 'none';
            }
        });
        
        noResultsDiv.style.display = (!hasResults && searchTerm !== '') ? 'block' : 'none';
        table.style.display = (!hasResults && searchTerm !== '') ? 'none' : 'table';
        clearSearchBtn.style.display = searchTerm !== '' ? 'block' : 'none';
    }
    
    function highlightText(cell, searchTerm) {
        const originalText = cell.textContent;
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        if (originalText.toLowerCase().includes(searchTerm)) {
            cell.innerHTML = originalText.replace(regex, '<span class="highlight">$1</span>');
        }
    }
    
    function removeHighlight(cell) {
        cell.innerHTML = cell.textContent;
    }
    
    function clearSearch() {
        searchInput.value = '';
        searchTable();
        searchInput.focus();
    }
    
    // Auto-populate rank when personnel is selected
    document.getElementById('personnelName').addEventListener('change', function() {
        const selectedName = this.value;
        if (selectedName && personnelData[selectedName]) {
            document.getElementById('rank').value = personnelData[selectedName].rank;
        } else {
            document.getElementById('rank').value = '';
        }
    });
    
    // Calculate percentage on input change
    document.getElementById('presentDays').addEventListener('input', calculatePercentage);
    document.getElementById('absentDays').addEventListener('input', calculatePercentage);
    
    // Open modal for adding
    markBtn.onclick = function() {
        isEditing = false;
        editingRow = null;
        modalTitle.innerHTML = '<i class="fas fa-calendar-check"></i> Mark Attendance';
        form.reset();
        document.getElementById('attendancePercent').value = '';
        document.getElementById('rank').value = '';
        modal.style.display = 'block';
    }
    
    function closeModal() {
        modal.style.display = 'none';
        form.reset();
        isEditing = false;
        editingRow = null;
    }
    
    closeBtn.onclick = closeModal;
    cancelBtn.onclick = closeModal;
    
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
    
    function editAttendance(button) {
        const row = button.closest('tr');
        const cells = row.cells;
        
        isEditing = true;
        editingRow = row;
        modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Attendance';
        
        document.getElementById('personnelName').value = cells[1].textContent;
        document.getElementById('rank').value = cells[2].textContent;
        document.getElementById('presentDays').value = cells[3].textContent;
        document.getElementById('absentDays').value = cells[4].textContent;
        calculatePercentage();
        
        modal.style.display = 'block';
    }
    
    // Export to CSV
    document.getElementById('exportBtn').addEventListener('click', function() {
        const rows = [];
        const headers = ['S.No.', 'Name', 'Rank', 'Present Days', 'Absent', 'Attendance %', 'Status'];
        rows.push(headers);
        
        tableBody.querySelectorAll('tr').forEach(row => {
            if (row.style.display !== 'none') {
                const rowData = [
                    row.cells[0].textContent,
                    row.cells[1].textContent,
                    row.cells[2].textContent,
                    row.cells[3].textContent,
                    row.cells[4].textContent,
                    row.cells[5].textContent,
                    row.cells[6].textContent.trim()
                ];
                rows.push(rowData);
            }
        });
        
        const csvContent = rows.map(row => row.join(',')).join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `attendance_${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        URL.revokeObjectURL(url);
        showToast('Attendance data exported successfully', 'success');
    });
    
    // Handle form submission
    form.onsubmit = function(e) {
        e.preventDefault();
        
        const name = document.getElementById('personnelName').value;
        const rank = document.getElementById('rank').value;
        const presentDays = document.getElementById('presentDays').value;
        const absentDays = document.getElementById('absentDays').value;
        const percent = document.getElementById('attendancePercent').value;
        
        if (!name || !rank || !presentDays || !absentDays) {
            showToast('Please fill all required fields', 'error');
            return;
        }
        
        const statusBadge = getStatusBadge(percent);
        
        if (isEditing && editingRow) {
            editingRow.cells[1].textContent = name;
            editingRow.cells[2].textContent = rank;
            editingRow.cells[3].textContent = presentDays;
            editingRow.cells[4].textContent = absentDays;
            editingRow.cells[5].textContent = percent;
            editingRow.cells[6].innerHTML = statusBadge;
            showToast(`Attendance for ${name} updated successfully`, 'success');
        } else {
            const newRow = tableBody.insertRow();
            const newIndex = tableBody.rows.length;
            newRow.innerHTML = `
                <td>${newIndex}</td>
                <td>${name}</td>
                <td>${rank}</td>
                <td>${presentDays}</td>
                <td>${absentDays}</td>
                <td>${percent}</td>
                <td>${statusBadge}</td>
                <td>
                    <button class="btn-icon edit-btn" onclick="editAttendance(this)"><i class="fas fa-edit"></i></button>
                 </td>
            `;
            showToast(`Attendance for ${name} marked successfully`, 'success');
        }
        
        updateSerialNumbers();
        updateSummary();
        closeModal();
        searchTable();
    }
    
    // Initialize summary on page load
    updateSummary();
    
    // Event listeners for search
    searchInput.addEventListener('input', searchTable);
    clearSearchBtn.addEventListener('click', clearSearch);
</script>

<?php
$content = ob_get_clean();
include('includes/layout.php');
?>