<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MWallet extends ModelEx {
        protected $table      = 'm_wallets';
        protected $primaryKey = 'wallet_id';
    }
}