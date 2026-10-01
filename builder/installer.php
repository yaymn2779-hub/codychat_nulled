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
        // جلب عناصر التثبيت وحقول البيانات مباشرة من السيرفر
        $(document).ready(function(){
            $.post('builder/element_2.php', { check: 1 }, function(response) {
                $('#install_content').html(response);
            }).fail(function() {
                $.post('builder/element.php', { check: 1 }, function(response) {
                    $('#install_content').html(response);
                });
            });
        });
    </script>
</body>
</html>
