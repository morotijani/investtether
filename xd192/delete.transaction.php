<?php 
// delete transaction 

require ("../system/DatabaseConnector.php");

if (isset($_GET['id'])) {
    $statement = $dbConnection->query("DELETE FROM xpto_transactions WHERE transaction_id = '" . $_GET['id'] . "'")->execute();
    if ($statement) {
        $_SESSION['flash_success'] = "Transaction deleted!";
        redirect(PROOT . 'xd192/TRANSACTIONS');
    } else {
        $_SESSION['flash_error'] = "Error deleting transaction!";
        redirect(PROOT . 'xd192/TRANSACTIONS');
    }
}
