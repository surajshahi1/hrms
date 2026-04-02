<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber HRMS | Attendance</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <?php include('includes/styles.php'); ?>
</head>
<body>
<?php include('includes/navbar.php'); ?>
<div class="layout">
    <?php include('includes/sidebar.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="page-title">Attendance Register</div>
            <div class="page-subtitle">Monthly attendance summary for personnel.</div>
            <div class="data-table">
                <table>
                    <thead><tr><th>Name</th><th>Rank</th><th>Present Days</th><th>Absent</th><th>Attendance %</th></tr></thead>
                    <tbody>
                        <tr><td>Vikram Rathore</td><td>Major</td><td>24</td><td>1</td><td>96%</td></tr>
                        <tr><td>Anjali Sharma</td><td>Captain</td><td>25</td><td>0</td><td>100%</td></tr>
                        <tr><td>Baldev Singh</td><td>Subedar</td><td>18</td><td>7</td><td>72%</td></tr>
                        <tr><td>Arjun Mehta</td><td>Lieutenant</td><td>23</td><td>2</td><td>92%</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>
    </div>
</div>
<script src="helper/toast.js"></script>
<script>
    document.querySelector('.sidebar-link[data-page="attendance"]')?.classList.add('active');
    document.getElementById('logoutBtnNav')?.addEventListener('click', () => {
        showToast('Logged out successfully', 'success');
        setTimeout(() => { window.location.href = 'index.html'; }, 1000);
    });
</script>
</body>
</html>
