<?php 
    
    require ("../system/DatabaseConnector.php");

    if (isset($_POST['id'])) {
        $id = sanitize($_POST['id']);

        $sql = "
            SELECT * FROM xpto_transactions 
            WHERE transaction_id = ?
        ";
        $statement = $dbConnection->prepare($sql);
        $statement->execute([$id]);
        $count_row = $statement->rowCount();
        $transaction = $statement->fetch();

        $by = get_id_details($dbConnection, $transaction['transaction_by']);
        $crypto_id = $transaction['transaction_crypto_id'];
        $icon = "https://s2.coinmarketcap.com/static/img/coins/64x64/{$crypto_id}.png";
        $transaction_status = $transaction['transaction_status'];

        $userName = '';
        if ($by['user_firstname'] != '' && $by['user_lastname'] != '') {
            $userName = ucwords($by['user_firstname'] . ' ' . $by['user_lastname']);
        }

        $status = '';
        $status_text = '';
        if ($transaction_status == 0) {
            $status = 'Pending';
            $status_text = 'warning';
        } elseif ($transaction_status == 1) {
            $status = 'Successful';
            $status_text = 'success';
        } else {
            $status = 'Canceled';
            $status_text = 'danger';
        }

?>
<?php ob_start(); ?>
    <div class="modal fade" id="details-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailsBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailsModalLabel">Transaction details</h1>
                    <button type="button" class="btn-close" onclick="closeModal()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($count_row > 0): ?>
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header">
                                    Crypto Details
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <img src="<?= $icon; ?>" class="img-thumbnail" alt="...">
                                    </li>
                                    <li class="list-group-item">ID: <b><?= $transaction['transaction_crypto_id']; ?></b></li>
                                    <li class="list-group-item">Name: <b><?= $transaction['transaction_crypto_name']; ?></b></li>
                                    <li class="list-group-item">Symbol: <b><?= $transaction['transaction_crypto_symbol']; ?></b></li>
                                    <li class="list-group-item">Current price (Before transaction): <b>$<?= $transaction['transaction_crypto_price']; ?></b></li>
                                </ul>
                                <br>
                                <p>
                                    TRANSACTION STATUS: <buton class="btn btn-<?= $status_text; ?>"><?= $status; ?></button>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    Transaction Details
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Transaction ID: <b><?= $transaction['transaction_id']; ?></b></li>
                                    <li class="list-group-item">Name: <b><?= $userName; ?></b></li>
                                    <li class="list-group-item">Email: <b><?= $by['user_email']; ?></b></li>
                                    <li class="list-group-item">
                                    Transaction to:
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"  style="cursor: pointer;" onclick="copyToClipboard(document.getElementById('address').value)"><i class="bi bi-clipboard2"></i></span>
                                            <input class="form-control" type="text" id="address" value="<?= $transaction['transaction_to_address']; ?>" readonly>
                                        </div>
                                    </li>
                                    <li class="list-group-item">Transaction amount: <b><?= money($transaction['transaction_amount']); ?></b></li>
                                    <li class="list-group-item">Transaction note: <b><?= $transaction['transaction_message']; ?></b></li>
                                    <li class="list-group-item">Transaction date: <b><?= pretty_date($transaction['createdAt']); ?></b></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <label for="">Update transaction status</label>
                    <select name="update_status" id="update_status">
                        <option value="" selected="selected"></option>
                        <option value="0">Pending</option>
                        <option value="1">Successful</option>
                        <option value="2">Canceled</option>
                    </select>
                    <input type="hidden" id="transaction_id" name="transaction_id" value="<?= $transaction['transaction_id']; ?>" />
                    <?php else: ?>
                        No data.
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" id="update_transaction" onclick="updateTransaction()" class="btn btn-primary mb-1">Save changes</button>
                    <a href="<?= PROOT; ?>xd192/delete.transaction/<?= $transaction['transaction_id']; ?>" class="btn btn-danger">Delete transaction</a>
                </div>
            </div>
        </div>
    </div>

<?php        
        }
?>

<script>
    function closeModal() {
        $('#details-modal').modal('hide');
        setTimeout(function() {
            $('#details-modal').remove();
            $('.modal-backdrop').remove();
        }, 500);
    }

    function updateTransaction() { 

        var status = $('#update_status').val();
        var id = $('#transaction_id').val();

        if (status == '') {
            return false;
        }

        var data = {
            id: id,
            status: status
        };
        $.ajax({
            url : "<?= PROOT; ?>xd192/update.transaction.php",
            method : "POST",
            data : data,
            beforeSend : function() {
                $('#update_transaction').attr('disabled', true);
                $('#update_transaction').html(`<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span role="status">Saving...</span>`);
            },
            success : function(response) {
                $('#update_transaction').html('Save changes');
                $('#update_transaction').attr('disabled', false);
                
                $('.toast').addClass('alert-info');
				$('.toast-body').html(response);
				$('.toast').toast('show');

                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        })

    }
</script>

<?php echo ob_get_clean(); ?>
