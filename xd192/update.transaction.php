<?php
    require ("../system/DatabaseConnector.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = sanitize($_POST['id']);
        $status = sanitize($_POST['status']);

        // update transaction status in database
        $statement = $dbConnection->prepare("UPDATE xpto_transactions SET transaction_status = ? WHERE transaction_id = ?");
        $statement->execute([$status, $id]);
        echo "Transaction status updated";
    }
    