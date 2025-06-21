<?php
    require ("../system/DatabaseConnector.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = sanitize($_POST['id']);
        $status = sanitize($_POST['status']);
        $income_statement = sanitize($_POST['income_statement']);

        // check if transaction exists
        $statement = $dbConnection->prepare("SELECT * FROM xpto_transactions WHERE transaction_id =?");
        $statement->execute([$id]);
        $count_row = $statement->rowCount();
        if ($count_row == 0) {
            echo "Transaction does not exist";
            exit;
        }

        // update transaction status in database
        $statement = $dbConnection->prepare("UPDATE xpto_transactions SET transaction_status = ?, transaction_income_statement = ? WHERE transaction_id = ?");
        $statement->execute([$status, '1', $id]);

        echo "Transaction status updated";
    }
    