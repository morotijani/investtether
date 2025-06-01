<?php
    require ("../system/DatabaseConnector.php");
    unset($_SESSION['XPADMIN']);
    session_destroy();
    $_SESSION['flash_success'] = 'You have been logged out!';
    redirect(PROOT . 'xd192/login');
?>
