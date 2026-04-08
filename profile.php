<?php
session_start();

// // Check if user is logged in
// if (!isset($_SESSION['user_id']) && !isset($_SESSION['personnel_number'])) {
//     header('Location: login.php');
//     exit;
// }

include('includes/config.php');

$pageTitle = "Personnel Profile";
$pageSubtitle = "View and manage personnel information";
$activePage = "profile";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the personnel number from session or URL parameter
$personnel_number = $_GET['personnel_number'] ?? $_SESSION['personnel_number'] ?? '';

// Handle AJAX requests for searching
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    header('Content-Type: application/json');
    
    $action = $_POST['action'] ?? '';
    
    // Search personnel by number or name
    if ($action === 'search_personnel') {
        $search = trim($_POST['search'] ?? '');
        
        if (empty($search)) {
            echo json_encode(['success' => false, 'error' => 'Please enter a search term']);
            exit;
        }
        
        // Search by personnel_number or full_name_en
        $stmt = $pdo->prepare("
            SELECT * FROM personnel 
            WHERE personnel_number LIKE ? OR full_name_en LIKE ? 
            ORDER BY full_name_en
            LIMIT 10
        ");
        $searchTerm = "%$search%";
        $stmt->execute([$searchTerm, $searchTerm]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'data' => $results]);
        exit;
    }
    
    // Update personnel profile
    if ($action === 'update_profile') {
        $personnel_number = $_POST['personnel_number'] ?? '';
        $full_name_en = trim($_POST['full_name_en'] ?? '');
        $full_name_ne = trim($_POST['full_name_ne'] ?? '');
        $dob = $_POST['dob'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $blood_group = $_POST['blood_group'] ?? null;
        $rank = trim($_POST['rank'] ?? '');
        $unit = trim($_POST['unit'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $contact = trim($_POST['contact'] ?? '');
        $joint_date = $_POST['joint_date'] ?? null;
        $going_date = $_POST['going_date'] ?? null;
        $father_name = trim($_POST['father_name'] ?? '');
        $mother_name = trim($_POST['mother_name'] ?? '');
        $spouse_name = trim($_POST['spouse_name'] ?? '');
        $grandfather_name = trim($_POST['grandfather_name'] ?? '');
        $higher_education = trim($_POST['higher_education'] ?? '');
        $training = trim($_POST['training'] ?? '');
        $training1 = trim($_POST['training1'] ?? '');
        $training2 = trim($_POST['training2'] ?? '');
        $training3 = trim($_POST['training3'] ?? '');
        $training4 = trim($_POST['training4'] ?? '');
        $training5 = trim($_POST['training5'] ?? '');
        $current_status = trim($_POST['current_status'] ?? 'Active');
        
        $stmt = $pdo->prepare("
            UPDATE personnel 
            SET full_name_en = ?, full_name_ne = ?, dob = ?, gender = ?, blood_group = ?,
                rank = ?, unit = ?, email = ?, contact = ?, joint_date = ?, going_date = ?,
                father_name = ?, mother_name = ?, spouse_name = ?, grandfather_name = ?,
                higher_education = ?, training = ?, training1 = ?, training2 = ?, 
                training3 = ?, training4 = ?, training5 = ?, current_status = ?, updated_at = NOW()
            WHERE personnel_number = ?
        ");
        
        $result = $stmt->execute([
            $full_name_en, $full_name_ne, $dob, $gender, $blood_group,
            $rank, $unit, $email, $contact, $joint_date, $going_date,
            $father_name, $mother_name, $spouse_name, $grandfather_name,
            $higher_education, $training, $training1, $training2,
            $training3, $training4, $training5, $current_status, $personnel_number
        ]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update profile']);
        }
        exit;
    }
    
    echo json_encode(['success' => false, 'error' => 'Invalid action']);
    exit;
}

// Fetch personnel data
$personnel = null;
if ($personnel_number) {
    $stmt = $pdo->prepare("SELECT * FROM personnel WHERE personnel_number = ?");
    $stmt->execute([$personnel_number]);
    $personnel = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Calculate years of service
function calculateYearsOfService($joint_date) {
    if (!$joint_date) return 'N/A';
    $join = new DateTime($joint_date);
    $today = new DateTime();
    $diff = $join->diff($today);
    return $diff->y . ' years ' . $diff->m . ' months';
}

ob_start();
?>

<!-- Search Section -->
<div class="search-section">
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="personnelSearch" class="search-input" 
               placeholder="Search by Personnel Number or Name..." 
               value="<?php echo htmlspecialchars($personnel_number); ?>">
        <button id="clearSearch" class="clear-search" style="display: none;">✕</button>
    </div>
    <div id="searchResults" class="search-results" style="display: none;"></div>
</div>

<?php if ($personnel): ?>
<!-- Profile Header with Avatar -->
<div class="profile-header">
    <div class="profile-avatar-container">
        <div class="profile-avatar" id="profileAvatar">
            <?php
            $avatarFile = 'uploads/profiles/' . $personnel['personnel_number'] . '.jpg';
            if (file_exists($avatarFile)): ?>
                <img src="<?php echo $avatarFile; ?>" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            <?php else: ?>
                <i class="fas fa-user-shield"></i>
            <?php endif; ?>
        </div>
        <button class="change-avatar-btn" id="changeAvatarBtn" title="Change Avatar">
            <i class="fas fa-camera"></i>
        </button>
        <input type="file" id="avatarUpload" accept="image/*" style="display: none;">
    </div>
    <div class="profile-title">
        <h2 id="profileName"><?php echo htmlspecialchars($personnel['full_name_en'] ?? 'N/A'); ?></h2>
        <p class="profile-badge">
            <i class="fas fa-star-of-life"></i> 
            <?php echo htmlspecialchars($personnel['rank'] ?? 'N/A'); ?> 
            | Service No: <?php echo htmlspecialchars($personnel['personnel_number']); ?>
        </p>
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
            <div class="info-label">Personnel Number</div>
            <div class="info-value"><?php echo htmlspecialchars($personnel['personnel_number'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Full Name (English)</div>
            <div class="info-value" id="fullNameEn"><?php echo htmlspecialchars($personnel['full_name_en'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Full Name (Nepali)</div>
            <div class="info-value" id="fullNameNe"><?php echo htmlspecialchars($personnel['full_name_ne'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Date of Birth</div>
            <div class="info-value" id="dob"><?php echo $personnel['dob'] ? date('d F Y', strtotime($personnel['dob'])) : 'N/A'; ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Gender</div>
            <div class="info-value" id="gender"><?php echo htmlspecialchars($personnel['gender'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Blood Group</div>
            <div class="info-value" id="bloodGroup"><?php echo htmlspecialchars($personnel['blood_group'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Current Status</div>
            <div class="info-value">
                <span class="status-badge status-<?php echo strtolower($personnel['current_status'] ?? 'active'); ?>">
                    <?php echo htmlspecialchars($personnel['current_status'] ?? 'N/A'); ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Family Information - Complete -->
    <div class="profile-info-card">
        <div class="card-header">
            <h4><i class="fas fa-family"></i> Family Information</h4>
        </div>
        <div class="info-row">
            <div class="info-label">Father's Name</div>
            <div class="info-value" id="fatherName"><?php echo htmlspecialchars($personnel['father_name'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Mother's Name</div>
            <div class="info-value" id="motherName"><?php echo htmlspecialchars($personnel['mother_name'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Spouse's Name</div>
            <div class="info-value" id="spouseName"><?php echo htmlspecialchars($personnel['spouse_name'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Grandfather's Name</div>
            <div class="info-value" id="grandfatherName"><?php echo htmlspecialchars($personnel['grandfather_name'] ?? 'N/A'); ?></div>
        </div>
        <?php if (!empty($personnel['children_names'])): ?>
        <div class="info-row">
            <div class="info-label">Children</div>
            <div class="info-value" id="childrenNames"><?php echo nl2br(htmlspecialchars($personnel['children_names'] ?? 'N/A')); ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Service Information -->
    <div class="profile-info-card">
        <div class="card-header">
            <h4><i class="fas fa-shield-alt"></i> Service Information</h4>
        </div>
        <div class="info-row">
            <div class="info-label">Rank</div>
            <div class="info-value" id="rank"><?php echo htmlspecialchars($personnel['rank'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Unit</div>
            <div class="info-value" id="unit"><?php echo htmlspecialchars($personnel['unit'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Date of Joining</div>
            <div class="info-value" id="jointDate"><?php echo $personnel['joint_date'] ? date('d F Y', strtotime($personnel['joint_date'])) : 'N/A'; ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Years of Service</div>
            <div class="info-value" id="yearsOfService"><?php echo calculateYearsOfService($personnel['joint_date']); ?></div>
        </div>
        <?php if ($personnel['going_date']): ?>
        <div class="info-row">
            <div class="info-label">Date of Leaving</div>
            <div class="info-value" id="goingDate"><?php echo date('d F Y', strtotime($personnel['going_date'])); ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Contact Information -->
    <div class="profile-info-card">
        <div class="card-header">
            <h4><i class="fas fa-address-card"></i> Contact Information</h4>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value" id="email"><?php echo htmlspecialchars($personnel['email'] ?? 'N/A'); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Contact Number</div>
            <div class="info-value" id="contact"><?php echo htmlspecialchars($personnel['contact'] ?? 'N/A'); ?></div>
        </div>
    </div>

    <!-- Education & Training -->
    <div class="profile-info-card">
        <div class="card-header">
            <h4><i class="fas fa-graduation-cap"></i> Education & Training</h4>
        </div>
        <div class="info-row">
            <div class="info-label">Higher Education</div>
            <div class="info-value" id="higherEducation"><?php echo nl2br(htmlspecialchars($personnel['higher_education'] ?? 'N/A')); ?></div>
        </div>
        <div class="info-row">
            <div class="info-label">Primary Training</div>
            <div class="info-value" id="training"><?php echo nl2br(htmlspecialchars($personnel['training'] ?? 'N/A')); ?></div>
        </div>
        <?php if ($personnel['training1']): ?>
        <div class="info-row">
            <div class="info-label">Additional Training 1</div>
            <div class="info-value"><?php echo htmlspecialchars($personnel['training1']); ?></div>
        </div>
        <?php endif; ?>
        <?php if ($personnel['training2']): ?>
        <div class="info-row">
            <div class="info-label">Additional Training 2</div>
            <div class="info-value"><?php echo htmlspecialchars($personnel['training2']); ?></div>
        </div>
        <?php endif; ?>
        <?php if ($personnel['training3']): ?>
        <div class="info-row">
            <div class="info-label">Additional Training 3</div>
            <div class="info-value"><?php echo htmlspecialchars($personnel['training3']); ?></div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal">
    <div class="modal-content modal-large">
        <div class="modal-header">
            <h3><i class="fas fa-user-edit"></i> Edit Profile - <?php echo htmlspecialchars($personnel['full_name_en']); ?></h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editProfileForm">
                <input type="hidden" name="personnel_number" value="<?php echo htmlspecialchars($personnel['personnel_number']); ?>">
                
                <div class="form-tabs">
                    <button type="button" class="tab-btn active" data-tab="personal">Personal</button>
                    <button type="button" class="tab-btn" data-tab="family">Family</button>
                    <button type="button" class="tab-btn" data-tab="service">Service</button>
                    <button type="button" class="tab-btn" data-tab="education">Education</button>
                </div>
                
                <!-- Personal Tab -->
                <div class="tab-content active" id="personal-tab">
                    <div class="form-grid">
                        <div class="input-field full-width">
                            <label>Full Name (English) <span class="required-star">*</span></label>
                            <input type="text" id="editFullNameEn" value="<?php echo htmlspecialchars($personnel['full_name_en'] ?? ''); ?>">
                        </div>
                        <div class="input-field full-width">
                            <label>Full Name (Nepali)</label>
                            <input type="text" id="editFullNameNe" value="<?php echo htmlspecialchars($personnel['full_name_ne'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" id="editDob" value="<?php echo $personnel['dob'] ?? ''; ?>">
                        </div>
                        <div class="input-field">
                            <label>Gender</label>
                            <select id="editGender">
                                <option value="">Select Gender</option>
                                <option value="Male" <?php echo ($personnel['gender'] ?? '') == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($personnel['gender'] ?? '') == 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo ($personnel['gender'] ?? '') == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Blood Group</label>
                            <select id="editBloodGroup">
                                <option value="">Select Blood Group</option>
                                <?php
                                $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                                foreach ($bloodGroups as $bg) {
                                    $selected = ($personnel['blood_group'] ?? '') == $bg ? 'selected' : '';
                                    echo "<option value='$bg' $selected>$bg</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-field">
                            <label>Current Status</label>
                            <select id="editCurrentStatus">
                                <option value="Active" <?php echo ($personnel['current_status'] ?? '') == 'Active' ? 'selected' : ''; ?>>Active</option>
                                <option value="Leave" <?php echo ($personnel['current_status'] ?? '') == 'Leave' ? 'selected' : ''; ?>>Leave</option>
                                <option value="Training" <?php echo ($personnel['current_status'] ?? '') == 'Training' ? 'selected' : ''; ?>>Training</option>
                                <option value="Retired" <?php echo ($personnel['current_status'] ?? '') == 'Retired' ? 'selected' : ''; ?>>Retired</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Family Tab - Complete -->
                <div class="tab-content" id="family-tab">
                    <div class="form-grid">
                        <div class="input-field">
                            <label>Father's Name</label>
                            <input type="text" id="editFatherName" value="<?php echo htmlspecialchars($personnel['father_name'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Mother's Name</label>
                            <input type="text" id="editMotherName" value="<?php echo htmlspecialchars($personnel['mother_name'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Spouse's Name</label>
                            <input type="text" id="editSpouseName" value="<?php echo htmlspecialchars($personnel['spouse_name'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Grandfather's Name</label>
                            <input type="text" id="editGrandfatherName" value="<?php echo htmlspecialchars($personnel['grandfather_name'] ?? ''); ?>">
                        </div>
                        <div class="input-field full-width">
                            <label>Children (comma separated)</label>
                            <input type="text" id="editChildrenNames" value="<?php echo htmlspecialchars($personnel['children_names'] ?? ''); ?>" placeholder="e.g., Son: Raj, Daughter: Sita">
                        </div>
                        <div class="input-field full-width">
                            <label>Additional Family Notes</label>
                            <textarea id="editFamilyNotes" rows="3" placeholder="Any additional family information..."><?php echo htmlspecialchars($personnel['family_notes'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Service Tab -->
                <div class="tab-content" id="service-tab">
                    <div class="form-grid">
                        <div class="input-field">
                            <label>Rank</label>
                            <input type="text" id="editRank" value="<?php echo htmlspecialchars($personnel['rank'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Unit</label>
                            <input type="text" id="editUnit" value="<?php echo htmlspecialchars($personnel['unit'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" id="editEmail" value="<?php echo htmlspecialchars($personnel['email'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Contact Number</label>
                            <input type="tel" id="editContact" value="<?php echo htmlspecialchars($personnel['contact'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Date of Joining</label>
                            <input type="date" id="editJointDate" value="<?php echo $personnel['joint_date'] ?? ''; ?>">
                        </div>
                        <div class="input-field">
                            <label>Date of Leaving (if applicable)</label>
                            <input type="date" id="editGoingDate" value="<?php echo $personnel['going_date'] ?? ''; ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Education Tab -->
                <div class="tab-content" id="education-tab">
                    <div class="form-grid">
                        <div class="input-field full-width">
                            <label>Higher Education</label>
                            <textarea id="editHigherEducation" rows="3"><?php echo htmlspecialchars($personnel['higher_education'] ?? ''); ?></textarea>
                        </div>
                        <div class="input-field full-width">
                            <label>Primary Training</label>
                            <textarea id="editTraining" rows="3"><?php echo htmlspecialchars($personnel['training'] ?? ''); ?></textarea>
                        </div>
                        <div class="input-field">
                            <label>Additional Training 1</label>
                            <input type="text" id="editTraining1" value="<?php echo htmlspecialchars($personnel['training1'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Additional Training 2</label>
                            <input type="text" id="editTraining2" value="<?php echo htmlspecialchars($personnel['training2'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Additional Training 3</label>
                            <input type="text" id="editTraining3" value="<?php echo htmlspecialchars($personnel['training3'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Additional Training 4</label>
                            <input type="text" id="editTraining4" value="<?php echo htmlspecialchars($personnel['training4'] ?? ''); ?>">
                        </div>
                        <div class="input-field">
                            <label>Additional Training 5</label>
                            <input type="text" id="editTraining5" value="<?php echo htmlspecialchars($personnel['training5'] ?? ''); ?>">
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

<?php else: ?>
<!-- No Personnel Selected -->
<div class="no-personnel-message">
    <i class="fas fa-search" style="font-size: 64px; color: #cbd5e1; margin-bottom: 20px;"></i>
    <h3>No Personnel Selected</h3>
    <p>Please search for a personnel by entering their service number or name above.</p>
</div>
<?php endif; ?>

<!-- Toast Notification -->
<div id="toast" class="toast" style="display: none;">
    <span id="toastMessage"></span>
</div>

<style>
    .search-section {
        position: relative;
        margin-bottom: 30px;
    }
    
    .search-container {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa9bc;
    }
    
    .search-input {
        width: 100%;
        padding: 12px 40px 12px 40px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .search-input:focus {
        border-color: #2c5f4e;
        outline: none;
        box-shadow: 0 0 0 3px rgba(44, 95, 78, 0.1);
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
        font-size: 16px;
    }
    
    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-top: 5px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .search-result-item {
        padding: 12px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f0f2f5;
        transition: background 0.2s;
    }
    
    .search-result-item:hover {
        background: #f8fafc;
    }
    
    .search-result-name {
        font-weight: 600;
        color: #1a2c3e;
    }
    
    .search-result-number {
        font-size: 12px;
        color: #6c7a8e;
        margin-top: 3px;
    }
    
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
        overflow: hidden;
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
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .profile-info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-active {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-leave {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .status-training {
        background: #fed7aa;
        color: #9a3412;
    }
    
    .status-retired {
        background: #f3f4f6;
        color: #4b5563;
    }
    
    .no-personnel-message {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid #eef2f6;
    }
    
    .modal-large {
        max-width: 800px;
        width: 90%;
    }
    
    .form-tabs {
        display: flex;
        gap: 10px;
        border-bottom: 1px solid #eef2f6;
        margin-bottom: 20px;
        flex-wrap: wrap;
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
        transition: all 0.2s;
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
        transition: all 0.2s;
    }
    
    .btn-submit:hover {
        background: #14362c;
    }
    
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #1e3a32;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        z-index: 1100;
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
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
        
        .form-tabs {
            justify-content: center;
        }
    }
</style>

<script>
    let searchTimeout;
    const searchInput = document.getElementById('personnelSearch');
    const searchResults = document.getElementById('searchResults');
    const clearSearchBtn = document.getElementById('clearSearch');
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.trim();
        clearSearchBtn.style.display = searchTerm !== '' ? 'block' : 'none';
        
        if (searchTerm.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => performSearch(searchTerm), 500);
    });
    
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        searchResults.style.display = 'none';
        this.style.display = 'none';
        searchInput.focus();
    });
    
    async function performSearch(searchTerm) {
        try {
            const formData = new FormData();
            formData.append('action', 'search_personnel');
            formData.append('search', searchTerm);
            
            const response = await fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            
            const result = await response.json();
            
            if (result.success && result.data.length > 0) {
                displaySearchResults(result.data);
            } else {
                searchResults.innerHTML = '<div class="search-result-item">No results found</div>';
                searchResults.style.display = 'block';
            }
        } catch (error) {
            console.error('Search error:', error);
        }
    }
    
    function displaySearchResults(results) {
        searchResults.innerHTML = '';
        results.forEach(person => {
            const div = document.createElement('div');
            div.className = 'search-result-item';
            div.innerHTML = `
                <div class="search-result-name">${escapeHtml(person.full_name_en)}</div>
                <div class="search-result-number">${escapeHtml(person.personnel_number)} | ${escapeHtml(person.rank)}</div>
            `;
            div.onclick = () => {
                window.location.href = `?personnel_number=${encodeURIComponent(person.personnel_number)}`;
            };
            searchResults.appendChild(div);
        });
        searchResults.style.display = 'block';
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Close search results when clicking outside
    document.addEventListener('click', function(e) {
        if (searchInput && !searchInput.contains(e.target) && searchResults && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
    
    // Modal elements
    const editModal = document.getElementById('editProfileModal');
    const editBtn = document.getElementById('editProfileBtn');
    const closeBtn = editModal?.querySelector('.close');
    const cancelBtn = document.getElementById('cancelEditBtn');
    const editForm = document.getElementById('editProfileForm');
    
    if (editBtn) {
        editBtn.onclick = () => { editModal.style.display = 'block'; };
    }
    
    function closeModal() {
        if (editModal) editModal.style.display = 'none';
    }
    
    if (closeBtn) closeBtn.onclick = closeModal;
    if (cancelBtn) cancelBtn.onclick = closeModal;
    
    window.onclick = function(event) {
        if (event.target == editModal) closeModal();
    };
    
    // Tab functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.getAttribute('data-tab');
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            const activeTab = document.getElementById(`${tabId}-tab`);
            if (activeTab) activeTab.classList.add('active');
        });
    });
    
    // Calculate years of service
    function calculateYearsOfService(jointDate) {
        if (!jointDate) return 'N/A';
        const join = new Date(jointDate);
        const today = new Date();
        let years = today.getFullYear() - join.getFullYear();
        const monthDiff = today.getMonth() - join.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < join.getDate())) {
            years--;
        }
        const months = ((today.getFullYear() - join.getFullYear()) * 12 + (today.getMonth() - join.getMonth()));
        const remainingMonths = ((months % 12) + 12) % 12;
        return `${years} years ${remainingMonths} months`;
    }
    
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');
        if (!toast || !toastMessage) return;
        toastMessage.textContent = message;
        toast.style.backgroundColor = type === 'success' ? '#1e3a32' : '#dc2626';
        toast.style.display = 'block';
        setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }
    
    // Handle form submission
    if (editForm) {
        editForm.onsubmit = async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'update_profile');
            formData.append('personnel_number', document.querySelector('input[name="personnel_number"]')?.value || '');
            formData.append('full_name_en', document.getElementById('editFullNameEn')?.value || '');
            formData.append('full_name_ne', document.getElementById('editFullNameNe')?.value || '');
            formData.append('dob', document.getElementById('editDob')?.value || '');
            formData.append('gender', document.getElementById('editGender')?.value || '');
            formData.append('blood_group', document.getElementById('editBloodGroup')?.value || '');
            formData.append('rank', document.getElementById('editRank')?.value || '');
            formData.append('unit', document.getElementById('editUnit')?.value || '');
            formData.append('email', document.getElementById('editEmail')?.value || '');
            formData.append('contact', document.getElementById('editContact')?.value || '');
            formData.append('joint_date', document.getElementById('editJointDate')?.value || '');
            formData.append('going_date', document.getElementById('editGoingDate')?.value || '');
            formData.append('father_name', document.getElementById('editFatherName')?.value || '');
            formData.append('mother_name', document.getElementById('editMotherName')?.value || '');
            formData.append('spouse_name', document.getElementById('editSpouseName')?.value || '');
            formData.append('grandfather_name', document.getElementById('editGrandfatherName')?.value || '');
            formData.append('children_names', document.getElementById('editChildrenNames')?.value || '');
            formData.append('family_notes', document.getElementById('editFamilyNotes')?.value || '');
            formData.append('higher_education', document.getElementById('editHigherEducation')?.value || '');
            formData.append('training', document.getElementById('editTraining')?.value || '');
            formData.append('training1', document.getElementById('editTraining1')?.value || '');
            formData.append('training2', document.getElementById('editTraining2')?.value || '');
            formData.append('training3', document.getElementById('editTraining3')?.value || '');
            formData.append('training4', document.getElementById('editTraining4')?.value || '');
            formData.append('training5', document.getElementById('editTraining5')?.value || '');
            formData.append('current_status', document.getElementById('editCurrentStatus')?.value || 'Active');
            
            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Update displayed values
                    const fullNameEn = document.getElementById('editFullNameEn')?.value || '';
                    const fullNameNe = document.getElementById('editFullNameNe')?.value || '';
                    const rank = document.getElementById('editRank')?.value || '';
                    const unit = document.getElementById('editUnit')?.value || '';
                    const email = document.getElementById('editEmail')?.value || '';
                    const contact = document.getElementById('editContact')?.value || '';
                    const fatherName = document.getElementById('editFatherName')?.value || '';
                    const motherName = document.getElementById('editMotherName')?.value || '';
                    const spouseName = document.getElementById('editSpouseName')?.value || '';
                    const grandfatherName = document.getElementById('editGrandfatherName')?.value || '';
                    const higherEducation = document.getElementById('editHigherEducation')?.value || '';
                    const training = document.getElementById('editTraining')?.value || '';
                    const gender = document.getElementById('editGender')?.value || '';
                    const bloodGroup = document.getElementById('editBloodGroup')?.value || '';
                    const currentStatus = document.getElementById('editCurrentStatus')?.value || 'Active';
                    
                    // Update DOM elements
                    const fullNameEnEl = document.getElementById('fullNameEn');
                    const fullNameNeEl = document.getElementById('fullNameNe');
                    const rankEl = document.getElementById('rank');
                    const unitEl = document.getElementById('unit');
                    const emailEl = document.getElementById('email');
                    const contactEl = document.getElementById('contact');
                    const fatherNameEl = document.getElementById('fatherName');
                    const motherNameEl = document.getElementById('motherName');
                    const spouseNameEl = document.getElementById('spouseName');
                    const grandfatherNameEl = document.getElementById('grandfatherName');
                    const higherEducationEl = document.getElementById('higherEducation');
                    const trainingEl = document.getElementById('training');
                    const genderEl = document.getElementById('gender');
                    const bloodGroupEl = document.getElementById('bloodGroup');
                    const profileNameEl = document.getElementById('profileName');
                    
                    if (fullNameEnEl) fullNameEnEl.textContent = fullNameEn || 'N/A';
                    if (fullNameNeEl) fullNameNeEl.textContent = fullNameNe || 'N/A';
                    if (profileNameEl) profileNameEl.textContent = fullNameEn || 'N/A';
                    if (rankEl) rankEl.textContent = rank || 'N/A';
                    if (unitEl) unitEl.textContent = unit || 'N/A';
                    if (emailEl) emailEl.textContent = email || 'N/A';
                    if (contactEl) contactEl.textContent = contact || 'N/A';
                    if (fatherNameEl) fatherNameEl.textContent = fatherName || 'N/A';
                    if (motherNameEl) motherNameEl.textContent = motherName || 'N/A';
                    if (spouseNameEl) spouseNameEl.textContent = spouseName || 'N/A';
                    if (grandfatherNameEl) grandfatherNameEl.textContent = grandfatherName || 'N/A';
                    if (higherEducationEl) higherEducationEl.innerHTML = (higherEducation || 'N/A').replace(/\n/g, '<br>');
                    if (trainingEl) trainingEl.innerHTML = (training || 'N/A').replace(/\n/g, '<br>');
                    if (genderEl) genderEl.textContent = gender || 'N/A';
                    if (bloodGroupEl) bloodGroupEl.textContent = bloodGroup || 'N/A';
                    
                    // Update date fields
                    const dob = document.getElementById('editDob')?.value;
                    if (dob) {
                        const dobDate = new Date(dob);
                        const dobEl = document.getElementById('dob');
                        if (dobEl) dobEl.textContent = dobDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                    }
                    
                    const jointDate = document.getElementById('editJointDate')?.value;
                    if (jointDate) {
                        const jDate = new Date(jointDate);
                        const jointDateEl = document.getElementById('jointDate');
                        if (jointDateEl) jointDateEl.textContent = jDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        const years = calculateYearsOfService(jointDate);
                        const yearsEl = document.getElementById('yearsOfService');
                        if (yearsEl) yearsEl.textContent = years;
                    }
                    
                    const goingDate = document.getElementById('editGoingDate')?.value;
                    if (goingDate) {
                        const gDate = new Date(goingDate);
                        const goingDateEl = document.getElementById('goingDate');
                        if (goingDateEl) goingDateEl.textContent = gDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                    }
                    
                    // Update status badge
                    const statusBadge = document.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.className = `status-badge status-${currentStatus.toLowerCase()}`;
                        statusBadge.textContent = currentStatus;
                    }
                    
                    showToast(result.message, 'success');
                    closeModal();
                } else {
                    showToast(result.error || 'Failed to update profile', 'error');
                }
            } catch (error) {
                console.error('Error updating profile:', error);
                showToast('Error updating profile', 'error');
            }
        };
    }
    
    // Avatar upload functionality
    const changeAvatarBtn = document.getElementById('changeAvatarBtn');
    const avatarUpload = document.getElementById('avatarUpload');
    const profileAvatar = document.getElementById('profileAvatar');
    
    if (changeAvatarBtn) {
        changeAvatarBtn.addEventListener('click', () => {
            avatarUpload.click();
        });
    }
    
    if (avatarUpload) {
        avatarUpload.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('action', 'upload_avatar');
                formData.append('personnel_number', '<?php echo $personnel_number; ?>');
                formData.append('avatar', file);
                
                try {
                    const response = await fetch('upload_avatar.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    if (result.success) {
                        if (profileAvatar) {
                            profileAvatar.innerHTML = `<img src="${result.path}?t=${Date.now()}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
                        }
                        showToast('Profile picture updated!', 'success');
                    }
                } catch (error) {
                    console.error('Error uploading avatar:', error);
                    showToast('Error uploading image', 'error');
                }
            }
        });
    }
</script>

<?php
$content = ob_get_clean();
include('includes/layout.php');
?>