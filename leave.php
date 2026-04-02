<?php
$pageTitle = "Dashboard";
$pageSubtitle = "Welcome back, Personnel. Here's your HR overview.";
$activePage = "dashboard";

// Prepare the content
ob_start();
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-user-friends"></i></div>
        <div>
            <div class="stat-value">1,284</div>
            <div class="stat-label">Total Personnel</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-user-check"></i></div>
        <div>
            <div class="stat-value">892</div>
            <div class="stat-label">Active Duty</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
        <div>
            <div class="stat-value">34</div>
            <div class="stat-label">On Leave</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div>
            <div class="stat-value">12</div>
            <div class="stat-label">Pending Requests</div>
        </div>
    </div>
</div>

<div class="data-table">
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Major</td><td>Vikram Rathore</td><td>Infantry</td><td><span class="badge">Active</span></td></tr>
            <tr><td>Captain</td><td>Anjali Sharma</td><td>Signals</td><td><span class="badge">Active</span></td></tr>
            <tr><td>Subedar</td><td>Baldev Singh</td><td>Artillery</td><td><span class="badge leave">Leave</span></td></tr>
            <tr><td>Lieutenant</td><td>Arjun Mehta</td><td>Armoured Corps</td><td><span class="badge">Active</span></td></tr>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
include('includes/layout.php');
?>