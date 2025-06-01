<?php
    // headers to allow request from https://xpto.logisticexpresscompany.com
    header("Access-Control-Allow-Origin: https://xpto.logisticexpresscompany.com");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    require_once ($_SERVER['DOCUMENT_ROOT'] . "/xpto/system/DatabaseConnector.php");

    // check the existance of the parameters
    if (!isset($_GET['amount']) || !isset($_GET['symbol']) || !isset($_GET['convert'])) {
        echo json_encode([
            'status' => [
                'error_code' => '100',
                'error_message' => 'Missing parameters',
            ],
            'data' => null
        ]);
        exit;
    }
    // get the parameters
    $amount = $_GET['amount'];
    $symbol = $_GET['symbol'];
    $convert = $_GET['convert'];

    // Validate parameters (add more validation as needed)
    if (!is_numeric($amount) || $amount <= 0) {
        echo json_encode([
            'status' => [
                'error_code' => '101',
                'error_message' => 'Invalid amount',
            ],
            'data' => null
        ]);
        exit;
    }

    // Make the request to CoinMarketCap's API
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=' . $symbol . '&convert=' . $convert,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'X-CMC_PRO_API_KEY: ' . COINCAP_APIKEY,
        ),
    ));

    $response = curl_exec($curl);
    
    // Handle cURL errors
    if (curl_errno($curl)) {
        echo json_encode([
            'status' => [
                'error_code' => '102',
                'error_message' => 'cURL error: ' . curl_error($curl),
            ],
            'data' => null
        ]);
        curl_close($curl);
        exit;
    }
    
    curl_close($curl);

    // Respond with JSON, including error handling
    $exchange_data = json_decode($response, true);

    // error handling
    if (isset($exchange_data['status']['error_code']) && $exchange_data['status']['error_code'] != 0) {
        // an error occoured on coinmarketcap side
        echo json_encode([
            'status' => $exchange_data['status'],
            'data' => null
        ]);
    } else {
        // success
        echo json_encode($exchange_data);
    }
