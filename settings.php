<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber HRMS | Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <?php include('includes/styles.php'); ?>
</head>
<body>
<?php include('includes/navbar.php'); ?>
<div class="layout">
    <?php include('includes/sidebar.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="page-title">Settings</div>
            <div class="page-subtitle">Manage your preferences and account.</div>
            <div class="profile-card">
                <div class="info-row"><div class="info-label">Language</div><div class="info-value">English (Default)</div></div>
                <div class="info-row"><div class="info-label">Theme</div><div class="info-value">Light Mode</div></div>
                <div class="info-row"><div class="info-label">Notifications</div><div class="info-value">Email & SMS alerts enabled</div></div>
                <div class="info-row"><div class="info-label">Two-Factor Auth</div><div class="info-value">Disabled</div></div>
                <div class="info-row"><div class="info-label">Session Timeout</div><div class="info-value">30 minutes</div></div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
</div>
<script src="helper/toast.js"></script>
<script>
    document.querySelector('.sidebar-link[data-page="settings"]')?.classList.add('active');
    document.getElementById('logoutBtnNav')?.addEventListener('click', () => {
        showToast('Logged out successfully', 'success');
        setTimeout(() => { window.location.href = 'index.html'; }, 1000);
    });
</script>
</body>
</html>
