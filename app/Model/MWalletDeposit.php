<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MWalletDeposit extends ModelEx {
        protected $table      = 'm_wallet_deposits';
        protected $primaryKey = 'wallet_deposit_id';
    }
}