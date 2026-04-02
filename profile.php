<?php
$pageTitle = "My Profile";
$pageSubtitle = "Your personal and service information.";
$activePage = "profile";

ob_start();
?>

<!-- Profile Header with Avatar -->
<div class="profile-header">
    <div class="profile-avatar-container">
        <div class="profile-avatar" id="profileAvatar">
            <i class="fas fa-user-shield"></i>
        </div>
        <button class="change-avatar-btn" id="changeAvatarBtn" title="Change Avatar">
            <i class="fas fa-camera"></i>
        </button>
        <input type="file" id="avatarUpload" accept="image/*" style="display: none;">
    </div>
    <div class="profile-title">
        <h2>Col. Rajesh Kumar</h2>
        <p class="profile-badge"><i class="fas fa-star-of-life"></i> Senior Officer</p>
    </div>
    <button class="edit-profile-btn" id="editProfileBtn">
        <i class="fas fa-edit"></i> Edit Profile
    </button>
</div>

<!-- Profile Information Cards -->
<div class="profile-grid">
    <!-- Personal Information -->
    <div class="profile-info-card">
        <div class="card-header">
            <h4><i class="fas fa-user-circle"></i> Personal Information</h4>
        </div>
        <div class="info-row">
            <div class="info-label">Full Name</div>
            <div class="info-value" id="fullName">Col. Rajesh Kumar</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date of Birth</div>
            <div class="info-value" id="dob">15 March 1975</div>
        </div>
        <div class="info-row">
            <div class="info-label">Gender</div>
            <div class="info-value" id="gender">Male</div>
        </div>
        <div class="info-row">
            <div class="info-label">Blood Group</div>
            <div class="info-value" id="bloodGroup">O+</div>
        </div>
        <div class="info-row">
            <div class="info-label">Marital Status</div>
            <div class="info-value" id="maritalStatus">Married</div>
        </div>
    </div>

    <!-- Service Information -->
    <div class="profile-info-card">
        <div class="card-header">
            <h4><i class="fas fa-shield-alt"></i> Service Information</h4>
        </div>
        <div class="info-row">
            <div class="info-label">Rank</div>
            <div class="info-value" id="rank">Colonel</div>
        </div>
        <div class="info-row">
            <div class="info-label">Service Number</div>
            <div class="info-value" id="serviceNo">IC-45231</div>
        </div>
        <div class="info-row">
            <div class="info-label">Branch / Arm</div>
            <div class="info-value" id="branch">Infantry</div>
        </div>
        <div class="info-row">
            <div class="info-label">Unit</div>
            <div class="info-value" id="unit">9th Battalion, Rajput Regiment</div>
        </div>
        <div class="info-row">
            <div class="info-label">Commission Date</div>
            <div class="info-value" id="commissionDate">15 June 2005</div>
        </div>
        <div class="info-row">
            <div class="info-label">Years of Service</div>
            <div class="info-value" id="yearsOfService">20 years</div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="profile-info-card">
        <div class="card-header">
            <h4><i class="fas fa-address-card"></i> Contact Information</h4>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value" id="email">col.rajesh@army.hrms.in</div>
        </div>
        <div class="info-row">
            <div class="info-label">Phone (Personal)</div>
            <div class="info-value" id="phonePersonal">+91 98765 43210</div>
        </div>
        <div class="info-row">
            <div class="info-label">Phone (Official)</div>
            <div class="info-value" id="phoneOfficial">+91 12345 67890</div>
        </div>
        <div class="info-row">
            <div class="info-label">Office Address</div>
            <div class="info-value" id="officeAddress">Room 101, Headquarters, New Delhi</div>
        </div>
        <div class="info-row">
            <div class="info-label">Residential Address</div>
            <div class="info-value" id="resAddress">Army Quarters, Cantt Area, New Delhi</div>
        </div>
    </div>

    <!-- Emergency Contact -->
    <div class="profile-info-card">
        <div class="card-header">
            <h4><i class="fas fa-ambulance"></i> Emergency Contact</h4>
        </div>
        <div class="info-row">
            <div class="info-label">Emergency Name</div>
            <div class="info-value" id="emergencyName">Mrs. Sunita Kumar</div>
        </div>
        <div class="info-row">
            <div class="info-label">Relationship</div>
            <div class="info-value" id="emergencyRelation">Spouse</div>
        </div>
        <div class="info-row">
            <div class="info-label">Emergency Phone</div>
            <div class="info-value" id="emergencyPhone">+91 99888 77777</div>
        </div>
        <div class="info-row">
            <div class="info-label">Alternative Phone</div>
            <div class="info-value" id="emergencyAltPhone">+91 98765 12345</div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal">
    <div class="modal-content modal-large">
        <div class="modal-header">
            <h3><i class="fas fa-user-edit"></i> Edit Profile</h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editProfileForm">
                <div class="form-tabs">
                    <button type="button" class="tab-btn active" data-tab="personal">Personal</button>
                    <button type="button" class="tab-btn" data-tab="service">Service</button>
                    <button type="button" class="tab-btn" data-tab="contact">Contact</button>
                    <button type="button" class="tab-btn" data-tab="emergency">Emergency</button>
                </div>
                
                <div class="tab-content active" id="personal-tab">
                    <div class="form-grid">
                        <div class="input-field">
                            <label>Full Name <span class="required-star">*</span></label>
                            <input type="text" id="editFullName" value="Col. Rajesh Kumar">
                        </div>
                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" id="editDob" value="1975-03-15">
                        </div>
                        <div class="input-field">
                            <label>Gender</label>
                            <select id="editGender">
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Blood Group</label>
                            <select id="editBloodGroup">
                                <option>A+</option><option>A-</option>
                                <option>B+</option><option>B-</option>
                                <option>O+</option><option>O-</option>
                                <option>AB+</option><option>AB-</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Marital Status</label>
                            <select id="editMaritalStatus">
                                <option>Single</option>
                                <option>Married</option>
                                <option>Divorced</option>
                                <option>Widowed</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content" id="service-tab">
                    <div class="form-grid">
                        <div class="input-field">
                            <label>Rank</label>
                            <input type="text" id="editRank" value="Colonel">
                        </div>
                        <div class="input-field">
                            <label>Service Number</label>
                            <input type="text" id="editServiceNo" value="IC-45231" readonly style="background:#f8fafc;">
                        </div>
                        <div class="input-field">
                            <label>Branch / Arm</label>
                            <input type="text" id="editBranch" value="Infantry">
                        </div>
                        <div class="input-field">
                            <label>Unit</label>
                            <input type="text" id="editUnit" value="9th Battalion, Rajput Regiment">
                        </div>
                        <div class="input-field">
                            <label>Commission Date</label>
                            <input type="date" id="editCommissionDate" value="2005-06-15">
                        </div>
                    </div>
                </div>
                
                <div class="tab-content" id="contact-tab">
                    <div class="form-grid">
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" id="editEmail" value="col.rajesh@army.hrms.in">
                        </div>
                        <div class="input-field">
                            <label>Phone (Personal)</label>
                            <input type="tel" id="editPhonePersonal" value="+91 98765 43210">
                        </div>
                        <div class="input-field">
                            <label>Phone (Official)</label>
                            <input type="tel" id="editPhoneOfficial" value="+91 12345 67890">
                        </div>
                        <div class="input-field full-width">
                            <label>Office Address</label>
                            <textarea id="editOfficeAddress" rows="2">Room 101, Headquarters, New Delhi</textarea>
                        </div>
                        <div class="input-field full-width">
                            <label>Residential Address</label>
                            <textarea id="editResAddress" rows="2">Army Quarters, Cantt Area, New Delhi</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content" id="emergency-tab">
                    <div class="form-grid">
                        <div class="input-field">
                            <label>Emergency Contact Name</label>
                            <input type="text" id="editEmergencyName" value="Mrs. Sunita Kumar">
                        </div>
                        <div class="input-field">
                            <label>Relationship</label>
                            <input type="text" id="editEmergencyRelation" value="Spouse">
                        </div>
                        <div class="input-field">
                            <label>Emergency Phone</label>
                            <input type="tel" id="editEmergencyPhone" value="+91 99888 77777">
                        </div>
                        <div class="input-field">
                            <label>Alternative Phone</label>
                            <input type="tel" id="editEmergencyAltPhone" value="+91 98765 12345">
                        </div>
                    </div>
                </div>
                
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" id="cancelEditBtn">Cancel</button>
                    <button type="submit" class="btn-submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Profile Header */
    .profile-header {
        background: linear-gradient(135deg, #1e3a32 0%, #2c5f4e 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
        color: white;
        position: relative;
    }
    
    .profile-avatar-container {
        position: relative;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        border: 3px solid white;
    }
    
    .change-avatar-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        background: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        color: #1e3a32;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    
    .change-avatar-btn:hover {
        transform: scale(1.1);
    }
    
    .profile-title h2 {
        margin: 0 0 5px 0;
        font-size: 24px;
    }
    
    .profile-badge {
        margin: 0;
        font-size: 13px;
        opacity: 0.9;
    }
    
    .edit-profile-btn {
        margin-left: auto;
        background: white;
        color: #1e3a32;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .edit-profile-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    /* Profile Grid */
    .profile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 25px;
    }
    
    .profile-info-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #eef2f6;
        overflow: hidden;
    }
    
    .card-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #eef2f6;
    }
    
    .card-header h4 {
        margin: 0;
        color: #1a2c3e;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .info-row {
        display: flex;
        padding: 14px 20px;
        border-bottom: 1px solid #f0f2f5;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        width: 140px;
        font-size: 13px;
        font-weight: 600;
        color: #6c7a8e;
    }
    
    .info-value {
        flex: 1;
        font-size: 14px;
        color: #1a2c3e;
        font-weight: 500;
    }
    
    /* Modal Large */
    .modal-large {
        max-width: 800px;
        width: 90%;
    }
    
    /* Form Tabs */
    .form-tabs {
        display: flex;
        gap: 10px;
        border-bottom: 1px solid #eef2f6;
        margin-bottom: 20px;
        padding-bottom: 0;
    }
    
    .tab-btn {
        padding: 10px 20px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #6c7a8e;
        transition: all 0.2s;
        position: relative;
    }
    
    .tab-btn:hover {
        color: #2c5f4e;
    }
    
    .tab-btn.active {
        color: #2c5f4e;
    }
    
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #2c5f4e;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    /* Form Styles */
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
    }
    
    .btn-submit:hover {
        background: #14362c;
    }
    
    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
        
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
        
        .edit-profile-btn {
            margin-left: 0;
        }
        
        .info-row {
            flex-direction: column;
            gap: 5px;
        }
        
        .info-label {
            width: auto;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .full-width {
            grid-column: span 1;
        }
    }
</style>

<script>
    // Modal elements
    const editModal = document.getElementById('editProfileModal');
    const editBtn = document.getElementById('editProfileBtn');
    const closeBtn = editModal.querySelector('.close');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const editForm = document.getElementById('editProfileForm');
    
    // Tab functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.getAttribute('data-tab');
            
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            btn.classList.add('active');
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });
    
    // Open modal and populate with current values
    function openEditModal() {
        // Populate form with current values
        document.getElementById('editFullName').value = document.getElementById('fullName').textContent;
        document.getElementById('editRank').value = document.getElementById('rank').textContent;
        document.getElementById('editServiceNo').value = document.getElementById('serviceNo').textContent;
        document.getElementById('editBranch').value = document.getElementById('branch').textContent;
        document.getElementById('editUnit').value = document.getElementById('unit').textContent;
        document.getElementById('editEmail').value = document.getElementById('email').textContent;
        
        editModal.style.display = 'block';
    }
    
    editBtn.onclick = openEditModal;
    
    function closeModal() {
        editModal.style.display = 'none';
    }
    
    closeBtn.onclick = closeModal;
    cancelBtn.onclick = closeModal;
    
    window.onclick = function(event) {
        if (event.target == editModal) {
            closeModal();
        }
    }
    
    // Calculate years of service
    function calculateYearsOfService(commissionDate) {
        const join = new Date(commissionDate);
        const today = new Date();
        let years = today.getFullYear() - join.getFullYear();
        const monthDiff = today.getMonth() - join.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < join.getDate())) {
            years--;
        }
        return years;
    }
    
    // Handle form submission
    editForm.onsubmit = function(e) {
        e.preventDefault();
        
        // Update profile values
        document.getElementById('fullName').textContent = document.getElementById('editFullName').value;
        document.getElementById('rank').textContent = document.getElementById('editRank').value;
        document.getElementById('branch').textContent = document.getElementById('editBranch').value;
        document.getElementById('unit').textContent = document.getElementById('editUnit').value;
        document.getElementById('email').textContent = document.getElementById('editEmail').value;
        
        // Update header name
        document.querySelector('.profile-title h2').textContent = document.getElementById('editFullName').value;
        
        // Update years of service if commission date changed
        const commissionDate = document.getElementById('editCommissionDate').value;
        if (commissionDate) {
            const years = calculateYearsOfService(commissionDate);
            document.getElementById('yearsOfService').textContent = `${years} years`;
        }
        
        showToast('Profile updated successfully!', 'success');
        closeModal();
    };
    
    // Avatar upload functionality
    const changeAvatarBtn = document.getElementById('changeAvatarBtn');
    const avatarUpload = document.getElementById('avatarUpload');
    const profileAvatar = document.getElementById('profileAvatar');
    
    changeAvatarBtn.addEventListener('click', () => {
        avatarUpload.click();
    });
    
    avatarUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                profileAvatar.innerHTML = `<img src="${event.target.result}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
                showToast('Profile picture updated!', 'success');
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Calculate initial years of service
    document.addEventListener('DOMContentLoaded', function() {
        const commissionDate = document.getElementById('commissionDate').textContent;
        const years = calculateYearsOfService(commissionDate);
        document.getElementById('yearsOfService').textContent = `${years} years`;
    });
</script>

<?php
$content = ob_get_clean();
include('includes/layout.php');
?>