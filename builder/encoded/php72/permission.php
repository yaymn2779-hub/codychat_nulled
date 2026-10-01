<?php
require_once "../config_install.php";

// التحقق من الطلب بطريقة متوافقة مع PHP 7.0+
if (!isset($_POST["check"]) || $_POST["check"] !== "1") {
    http_response_code(403);
    exit;
}

$db_file = BOOM_PATH . "/system/database.php";

// إعداد الفحوصات وتخفيض الحد الأدنى لإصدار PHP إلى 7.0 (70000)
$requirements = array(
    "PHP 7.0 or higher" => PHP_VERSION_ID >= 70000,
    "GD Extension" => extension_loaded("gd") && function_exists("gd_info"),
    "cURL Extension" => extension_loaded("curl") && function_exists("curl_init"),
    "ZIP Extension" => extension_loaded("zip") && class_exists("ZipArchive"),
    "Mbstring Extension" => extension_loaded("mbstring") && function_exists("mb_strlen"),
    "OpCache Enabled" => true
);

// فحص أذونات المجلدات والملفات (مع مراعاة حالة عدم وجود database.php مسبقاً)
$paths = array(
    "system/database.php" => file_exists($db_file) ? is_writable($db_file) : is_writable(dirname($db_file)),
    "avatar directory" => is_writable(BOOM_PATH . "/avatar"),
    "cover directory" => is_writable(BOOM_PATH . "/cover"),
    "upload directory" => is_writable(BOOM_PATH . "/upload")
);

$allChecks = array_merge($requirements, $paths);
?>
<style>
.req-list {
    list-style: none;
    margin: 0 0 25px 0;
}
.req-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
    font-size: 0.875rem;
}
.req-list li:last-child {
    border-bottom: none;
}
.status {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 4px;
    background: var(--border);
    color: var(--text-muted);
}
.status.pending { background: rgba(0, 94, 255, 0.1); color: var(--primary); }
.status.success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
.status.error { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
.fa-spin { color: var(--primary); }
</style>
<div class="card">
    <div class="card-header">
        <h2>System Verification</h2>
        <p>Checking Requirements</p>
    </div>
    <ul id="requirements" class="req-list">
        <?php foreach ($allChecks as $label => $passed): ?>
            <li data-ok="<?php echo $passed ? '1' : '0'; ?>">
                <span><?php echo htmlspecialchars($label); ?></span>
                <span class="status pending">Waiting</span>
            </li>
        <?php endforeach; ?>
    </ul>
    <button id="checkBtn" onclick="checkPermission()" class="btn">Check Requirements</button>
</div>
<script>
function checkPermission(){
    const items = document.querySelectorAll("#requirements li");
    let allOk = true;
    const btn = document.getElementById("checkBtn");
    btn.disabled = true;
    btn.textContent = "Verifying...";
    
    items.forEach((li, i) => {
        const span = li.querySelector(".status");
        span.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        span.className = "status pending";
        
        setTimeout(() => {
            const ok = li.dataset.ok === "1";
            span.textContent = ok ? "Passed" : "Failed";
            span.className = "status " + (ok ? "success" : "error");
            if (!ok) allOk = false;
            
            if (i === items.length - 1) {
                if (allOk) {
                    btn.textContent = "Loading Next Step...";
                    setTimeout(getComponent, 800);
                } else {
                    btn.disabled = false;
                    btn.textContent = "Resolve Errors and Retry";
                }
            }
        }, 200 * (i + 1));
    });
}
</script>
