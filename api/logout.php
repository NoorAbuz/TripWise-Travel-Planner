<?php
    require_once '../init.php';

    session_destroy();

    // Redirect to login page with logout parameter
    header('Location: /Web dev/Project/registration.php?from=logout');
    exit;
?>