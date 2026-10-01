<?php
require(__DIR__ . '/../system/config_version.php');
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Codychat Installation</title>
    <link rel="stylesheet" href="builder/install_2.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="builder/install_2.js"></script>
</head>
<body>
    <div id="container_install">
        <div id="install_head">
            <span class="install_welcome">Codychat Installation</span>
        </div>
        <div id="install_box">
            <div id="install_content">
                <!-- سيتم جلب حقول البيانات هنا تلقائياً -->
            </div>
            <div id="wait_install" style="display:none; text-align:center; padding:20px;">
                <p>جاري التثبيت... يرجى الانتظار</p>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function(){
            // استدعاء فحص التصاريح ونموذج التثبيت مباشرة عند تحميل الصفحة
            checkPermission();
        });
    </script>
</body>
</html>
