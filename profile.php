<?php
$pageTitle = "My Profile";
$pageSubtitle = "Your personal and service information.";
$activePage = "profile";

ob_start();
?>

<div class="profile-card">
    <div class="info-row">
        <div class="info-label">Full Name</div>
        <div class="info-value">Col. Rajesh Kumar</div>
    </div>
    <div class="info-row">
        <div class="info-label">Rank</div>
        <div class="info-value">Colonel</div>
    </div>
    <div class="info-row">
        <div class="info-label">Service Number</div>
        <div class="info-value">IC-45231</div>
    </div>
    <div class="info-row">
        <div class="info-label">Branch / Arm</div>
        <div class="info-value">Infantry</div>
    </div>
    <div class="info-row">
        <div class="info-label">Unit</div>
        <div class="info-value">9th Battalion, Rajput Regiment</div>
    </div>
    <div class="info-row">
        <div class="info-label">Commission Date</div>
        <div class="info-value">15 June 2005</div>
    </div>
    <div class="info-row">
        <div class="info-label">Email</div>
        <div class="info-value">col.rajesh@army.hrms.in</div>
    </div>
</div>

<?php
$content = ob_get_clean();
include('includes/layout.php');
?>