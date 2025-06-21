<?php
    require ("../system/DatabaseConnector.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = sanitize($_POST['id']);
        $status = sanitize($_POST['status']);
        $income_statement = sanitize($_POST['income_statement']);

        // update transaction status in database
        $statement = $dbConnection->prepare("UPDATE xpto_transactions SET transaction_status = ? WHERE transaction_id = ?, transaction_income_statement = ?");
        $statement->execute([$status, $id, $income_statement]);

        echo "Transaction status updated";
    }
    