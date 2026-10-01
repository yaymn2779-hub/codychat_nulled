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
</head>
<body>
    <div id="container_install">
        <div id="install_head">
            <span class="install_welcome">Codychat Installation</span>
        </div>
        <div id="install_box">
            <div id="install_content">
                <p style="text-align:center; padding:20px;">جاري تحميل نموذج البيانات...</p>
            </div>
            <div id="wait_install" style="display:none; text-align:center; padding:20px;">
                <p>جاري التثبيت... يرجى الانتظار</p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // أولاً نتحقق من الأذونات ثم نجلب نموذج البيانات تلقائياً
            $.post('builder/permission.php', { check: 1 }, function(permResponse) {
                // استدعاء جلب عناصر التثبيت
                $.post('builder/element.php', { check: 1 }, function(elemResponse) {
                    $('#install_content').html(elemResponse);
                }).fail(function(xhr) {
                    $('#install_content').html('<p style="color:red; text-align:center; padding:20px;">حدث خطأ أثناء تحميل عناصر التثبيت (Status: ' + xhr.status + ')</p>');
                });
            }).fail(function(xhr) {
                // في حال كان المسار يستدعي المجلد مباشرة بدون builder/
                $.post('element.php', { check: 1 }, function(elemResponse) {
                    $('#install_content').html(elemResponse);
                }).fail(function(err) {
                    $('#install_content').html('<p style="color:red; text-align:center; padding:20px;">تعذر الاتصال بالسيرفر للجلب (Status: ' + err.status + ')</p>');
                });
            });
        });
    </script>
</body>
</html>
