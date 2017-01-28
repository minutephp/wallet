<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MWalletOrder extends ModelEx {
        protected $table      = 'm_wallet_orders';
        protected $primaryKey = 'wallet_order_id';
    }
}