<?php
function renderPagination($currentPage, $totalPages, $search = '')
{
    if ($totalPages <= 1) return;
    
    // Build query string preserving all parameters
    $buildQuery = function($params) {
        // Get all current GET parameters
        $queryParams = $_GET;
        
        // Merge with new parameters
        foreach ($params as $key => $value) {
            $queryParams[$key] = $value;
        }
        
        // Remove empty parameters
        $queryParams = array_filter($queryParams, function($value) {
            return $value !== '' && $value !== null;
        });
        
        return http_build_query($queryParams);
    };
?>

<div class="pagination-container">
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?<?php echo $buildQuery(['page' => $currentPage - 1]); ?>" class="pagination-btn">
                <i class="fas fa-chevron-left"></i> Previous
            </a>
        <?php endif; ?>

        <div class="page-numbers">
            <?php
            $start = max(1, $currentPage - 2);
            $end = min($totalPages, $currentPage + 2);

            if ($start > 1) {
                echo '<a href="?' . $buildQuery(['page' => 1]) . '" class="page-number">1</a>';
                if ($start > 2) echo '<span class="page-dots">...</span>';
            }

            for ($i = $start; $i <= $end; $i++): ?>
                <a href="?<?php echo $buildQuery(['page' => $i]); ?>"
                   class="page-number <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor;

            if ($end < $totalPages) {
                if ($end < $totalPages - 1) echo '<span class="page-dots">...</span>';
                echo '<a href="?' . $buildQuery(['page' => $totalPages]) . '" class="page-number">' . $totalPages . '</a>';
            }
            ?>
        </div>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?<?php echo $buildQuery(['page' => $currentPage + 1]); ?>" class="pagination-btn">
                Next <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
</div>

<?php
}

function renderPaginationInfo($offset, $limit, $total)
{
    if ($total == 0) return;
    
    $start = $offset + 1;
    $end = min($offset + $limit, $total);
?>
<div class="pagination-info">
    Showing <?php echo $start; ?> to <?php echo $end; ?> of <?php echo $total; ?> entries
</div>
<?php
}
?>