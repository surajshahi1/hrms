<?php
$pageTitle = "Dashboard";
$pageSubtitle = "Welcome back, Personnel. Here's your HR overview.";
$activePage = "dashboard";

// Prepare the content
ob_start();
?>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-user-friends"></i></div>
        <div>
            <div class="stat-value" id="totalPersonnel">1,284</div>
            <div class="stat-label">Total Personnel</div>
            <div class="stat-trend positive">
                <i class="fas fa-arrow-up"></i> +12 this month
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-user-check"></i></div>
        <div>
            <div class="stat-value" id="activeDuty">892</div>
            <div class="stat-label">Active Duty</div>
            <div class="stat-trend positive">
                <i class="fas fa-arrow-up"></i> +5% from last month
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
        <div>
            <div class="stat-value" id="onLeave">34</div>
            <div class="stat-label">On Leave</div>
            <div class="stat-trend negative">
                <i class="fas fa-arrow-down"></i> -8 from last month
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div>
            <div class="stat-value" id="pendingRequests">12</div>
            <div class="stat-label">Pending Requests</div>
            <div class="stat-trend neutral">
                <i class="fas fa-minus"></i> Same as last month
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-section">
    <div class="chart-card">
        <div class="chart-header">
            <h4><i class="fas fa-chart-line"></i> Attendance Trends</h4>
            <select id="attendanceMonth" class="month-select">
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4" selected>April</option>
                <option value="5">May</option>
                <option value="6">June</option>
            </select>
        </div>
        <canvas id="attendanceChart" height="200"></canvas>
    </div>
    
    <div class="chart-card">
        <div class="chart-header">
            <h4><i class="fas fa-chart-pie"></i> Personnel Distribution</h4>
        </div>
        <canvas id="distributionChart" height="200"></canvas>
    </div>
</div>

<!-- Recent Personnel Table -->
<div class="data-table">
    <div class="table-header">
        <h4><i class="fas fa-users"></i> Recent Personnel Updates</h4>
        <a href="personnel.php" class="view-all-link">View All <i class="fas fa-arrow-right"></i></a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Unit</th>
                <th>Status</th>
                <th>Join Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Major</td>
                <td>Vikram Rathore</td>
                <td>Infantry</td>
                <td><span class="badge">Active</span></td>
                <td>2024-03-15</td>
            </tr>
            <tr>
                <td>Captain</td>
                <td>Anjali Sharma</td>
                <td>Signals</td>
                <td><span class="badge">Active</span></td>
                <td>2024-02-10</td>
            </tr>
            <tr>
                <td>Subedar</td>
                <td>Baldev Singh</td>
                <td>Artillery</td>
                <td><span class="badge leave">Leave</span></td>
                <td>2023-11-20</td>
            </tr>
            <tr>
                <td>Lieutenant</td>
                <td>Arjun Mehta</td>
                <td>Armoured Corps</td>
                <td><span class="badge">Active</span></td>
                <td>2024-04-01</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
    <div class="action-buttons">
        <a href="personnel.php" class="action-btn">
            <i class="fas fa-user-plus"></i> Add Personnel
        </a>
        <a href="leave.php" class="action-btn">
            <i class="fas fa-calendar-alt"></i> Manage Leave
        </a>
        <a href="attendance.php" class="action-btn">
            <i class="fas fa-clock"></i> Mark Attendance
        </a>
        <a href="#" class="action-btn" id="generateReportBtn">
            <i class="fas fa-file-alt"></i> Generate Report
        </a>
    </div>
</div>

<style>
    /* Additional Dashboard Styles */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border: 1px solid #eef2f6;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 54px;
        height: 54px;
        background: #f0fdf4;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #2c5f4e;
    }
    
    .stat-card > div {
        flex: 1;
    }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1a2c3e;
        line-height: 1.2;
    }
    
    .stat-label {
        font-size: 13px;
        color: #6c7a8e;
        margin-top: 4px;
    }
    
    .stat-trend {
        font-size: 11px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .stat-trend.positive {
        color: #065f46;
    }
    
    .stat-trend.negative {
        color: #c2410c;
    }
    
    .stat-trend.neutral {
        color: #6c7a8e;
    }
    
    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #eef2f6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eef2f6;
    }
    
    .chart-header h4 {
        margin: 0;
        color: #1a2c3e;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .month-select {
        padding: 6px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        outline: none;
        cursor: pointer;
    }
    
    /* Table Header */
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eef2f6;
    }
    
    .table-header h4 {
        margin: 0;
        color: #1a2c3e;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .view-all-link {
        color: #2c5f4e;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: 0.2s;
    }
    
    .view-all-link:hover {
        text-decoration: underline;
    }
    
    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-top: 30px;
        border: 1px solid #eef2f6;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .quick-actions h4 {
        margin: 0 0 15px 0;
        color: #1a2c3e;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .action-btn {
        padding: 10px 20px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        color: #1a2c3e;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .action-btn:hover {
        background: #2c5f4e;
        color: white;
        border-color: #2c5f4e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(44, 95, 78, 0.2);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .charts-section {
            grid-template-columns: 1fr;
        }
        
        .stat-card {
            padding: 15px;
        }
        
        .stat-value {
            font-size: 22px;
        }
    }
</style>

<!-- Include Chart.js for charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Attendance Chart Data
    let attendanceChart;
    
    function updateAttendanceChart(month) {
        const attendanceData = {
            1: [85, 88, 92, 90, 89, 91, 94, 93, 92, 95, 96, 94],
            2: [86, 89, 91, 93, 90, 92, 93, 94, 95, 94, 93, 95],
            3: [87, 90, 93, 91, 92, 94, 95, 96, 94, 95, 97, 96],
            4: [88, 91, 94, 92, 93, 95, 96, 97, 95, 96, 98, 97],
            5: [86, 89, 92, 90, 91, 93, 94, 95, 93, 94, 96, 95],
            6: [85, 88, 91, 89, 90, 92, 93, 94, 92, 93, 95, 94]
        };
        
        const data = attendanceData[month] || attendanceData[4];
        const weeks = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8', 'Week 9', 'Week 10', 'Week 11', 'Week 12'];
        
        if (attendanceChart) {
            attendanceChart.destroy();
        }
        
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        attendanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: weeks,
                datasets: [{
                    label: 'Attendance %',
                    data: data,
                    borderColor: '#2c5f4e',
                    backgroundColor: 'rgba(44, 95, 78, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#2c5f4e',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Attendance: ${context.raw}%`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        min: 70,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Distribution Chart
    let distributionChart;
    
    function initDistributionChart() {
        const ctx = document.getElementById('distributionChart').getContext('2d');
        distributionChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Infantry', 'Signals', 'Artillery', 'Armoured Corps', 'Others'],
                datasets: [{
                    data: [45, 20, 15, 12, 8],
                    backgroundColor: [
                        '#2c5f4e',
                        '#3b82f6',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Month selector change event
    document.getElementById('attendanceMonth')?.addEventListener('change', function() {
        updateAttendanceChart(this.value);
    });
    
    // Generate Report Button
    document.getElementById('generateReportBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        showToast('Monthly report generation started. You will receive an email shortly.', 'success');
    });
    
    // Animate stats counter
    function animateValue(element, start, end, duration) {
        if (!element) return;
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        const timer = setInterval(() => {
            current += increment;
            if (current >= end) {
                element.textContent = end.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.round(current).toLocaleString();
            }
        }, 16);
    }
    
    // Initialize animations and charts on page load
    document.addEventListener('DOMContentLoaded', function() {
        animateValue(document.getElementById('totalPersonnel'), 0, 1284, 1500);
        animateValue(document.getElementById('activeDuty'), 0, 892, 1500);
        animateValue(document.getElementById('onLeave'), 0, 34, 1500);
        animateValue(document.getElementById('pendingRequests'), 0, 12, 1500);
        
        updateAttendanceChart(4);
        initDistributionChart();
    });
</script>

<?php
$content = ob_get_clean();
include('includes/layout.php');
?>