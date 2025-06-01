<?php
    require ("../system/DatabaseConnector.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = sanitize($_POST['id']);
        $amount = sanitize($_POST['amount']);

        // update transaction status in database
        $statement = $dbConnection->prepare("UPDATE xpto_users SET user_balance = ? WHERE user_id = ?");
        $statement->execute([$amount, $id]);
        echo "Balance updated";
    }
    