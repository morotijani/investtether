<?php 

    require ("../system/DatabaseConnector.php");

    session_destroy();

    redirect(PROOT . 'auth/login');
