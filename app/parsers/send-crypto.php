<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/xpto/system/DatabaseConnector.php");

	if (!user_is_logged_in()) {
		redirect(PROOT . 'auth/logout');
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $msg = "";

        $send_amount = sanitize($_POST["send_amount"]);
        $to_cypto = sanitize($_POST["to_cypto"]);
        $to_wallet_address = sanitize($_POST["to_wallet_address"]);
        $note = sanitize($_POST["note"]);
        $pin = sanitize($_POST["pin"]);

        // get crypto details from $to_crypto
        $breakdown = explode("/", $to_cypto);
        $to_cypto_id = $breakdown[0];
        $to_crypto_symbol = $breakdown[1];
        $to_crypto_name = $breakdown[2];
        $to_crypto_price = $breakdown[3];
        // dnd($to_crypto_price);


        if (empty($send_amount) || empty($to_cypto) || empty($to_wallet_address) || empty($pin)) {
            $msg = "All fields are required.";
        }

        try {
            // Check if the user has enough balance
            if ($user_data['user_balance'] < $send_amount) {
                $msg = "Insufficient balance.";
            }

            // Check if the user pin provided is correct
            if (!password_verify($pin, $user_data['user_pin'])) {
                $msg = "Invalid pin.";
            }

            if (empty($msg) || $msg == "") {
                // Send crypto
                $statement = $dbConnection->prepare("INSERT INTO xpto_transactions (transaction_id, transaction_by, transaction_amount, transaction_crypto_id, transaction_crypto_symbol, transaction_crypto_name, transaction_crypto_price, transaction_to_address, transaction_message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $statement->execute([
                    guidv4(), 
                    $user_id, 
                    $send_amount, 
                    $to_cypto_id, 
                    $to_crypto_symbol, 
                    $to_crypto_name, 
                    $to_crypto_price, 
                    $to_wallet_address, 
                    $note
                ]);

                // Update user balance
                $statement = $dbConnection->prepare("UPDATE xpto_users SET user_balance = user_balance - ? WHERE user_id = ?");
                $statement->execute([
                    $send_amount, $user_id
                ]);

                $_SESSION['flash_success'] = "Transaction successful.";
                redirect(PROOT . 'app/transactions');
            }

        } catch (PDOException $e) {
            $msg = "Transaction failed: " . $e->getMessage();
        }

        if (!empty($msg) || $msg != "") {
            $_SESSION['flash_error'] = $msg;
            redirect(PROOT . 'app/');
        }
    }

   