<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber HRMS | Personnel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <?php include('includes/styles.php'); ?>
</head>
<body>
<?php include('includes/navbar.php'); ?>
<div class="layout">
    <?php include('includes/sidebar.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="page-title">Personnel Directory</div>
            <div class="page-subtitle">Complete list of commissioned officers and jawans.</div>
            <div class="data-table">
                <table>
                    <thead><tr><th>Service No.</th><th>Name</th><th>Rank</th><th>Branch</th><th>Status</th></tr></thead>
                    <tbody>
                        <tr><td>IC-45231</td><td>Col. Rajesh Kumar</td><td>Colonel</td><td>Infantry</td><td><span class="badge">Active</span></td></tr>
                        <tr><td>IC-48912</td><td>Lt. Col. Meera Nair</td><td>Lieutenant Colonel</td><td>Signals</td><td><span class="badge">Active</span></td></tr>
                        <tr><td>JC-22145</td><td>Subedar Major Harpal</td><td>Subedar Major</td><td>Artillery</td><td><span class="badge">Active</span></td></tr>
                        <tr><td>IC-50234</td><td>Major Rohan Joshi</td><td>Major</td><td>Armoured Corps</td><td><span class="badge leave">Leave</span></td></tr>
                        <tr><td>JC-18903</td><td>Havildar Suresh</td><td>Havildar</td><td>Infantry</td><td><span class="badge">Active</span></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
</div>
<script src="helper/toast.js"></script>
<script>
    document.querySelector('.sidebar-link[data-page="personnel"]')?.classList.add('active');
    document.getElementById('logoutBtnNav')?.addEventListener('click', () => {
        showToast('Logged out successfully', 'success');
        setTimeout(() => { window.location.href = 'index.html'; }, 1000);
    });
</script>
</body>
</html>
