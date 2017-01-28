<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MWalletLog extends ModelEx {
        protected $table      = 'm_wallet_logs';
        protected $primaryKey = 'wallet_log_id';
    }
}