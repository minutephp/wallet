<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 8:04 AM
 */
namespace Minute\Event {

    class WalletPurchaseEvent extends UserEvent {
        //in-wallet purchase via cart
        const USER_WALLET_PURCHASE = "user.wallet.purchase";
        //back to cart
        const USER_WALLET_PURCHASE_PASS = "user.wallet.purchase.pass";
        const USER_WALLET_PURCHASE_FAIL = "user.wallet.purchase.fail";

        const USER_WALLET_PURCHASE_CANCEL      = "user.wallet.purchase.cancel";
        const USER_WALLET_PURCHASE_CANCEL_PASS = "user.wallet.purchase.cancel.pass";
        const USER_WALLET_PURCHASE_CANCEL_FAIL = "user.wallet.purchase.cancel.fail";

        /**
         * @var string
         */
        private $item_type;
        /**
         * @var int
         */
        private $item_id;
        /**
         * @var float
         */
        private $amount;

        /**
         * WalletPurchaseEvent constructor.
         *
         * @param int $user_id
         * @param string $item_type
         * @param int $item_id
         * @param float $amount
         */
        public function __construct(int $user_id, string $item_type, int $item_id, float $amount) {
            parent::__construct($user_id);

            $this->item_type = $item_type;
            $this->item_id   = $item_id;
            $this->amount    = $amount;
        }

        /**
         * @return string
         */
        public function getItemType(): string {
            return $this->item_type;
        }

        /**
         * @param string $item_type
         *
         * @return WalletPurchaseEvent
         */
        public function setItemType(string $item_type): WalletPurchaseEvent {
            $this->item_type = $item_type;

            return $this;
        }

        /**
         * @return int
         */
        public function getItemId(): int {
            return $this->item_id;
        }

        /**
         * @param int $item_id
         *
         * @return WalletPurchaseEvent
         */
        public function setItemId(int $item_id): WalletPurchaseEvent {
            $this->item_id = $item_id;

            return $this;
        }

        /**
         * @return float
         */
        public function getAmount(): float {
            return $this->amount;
        }

        /**
         * @param float $amount
         *
         * @return WalletPurchaseEvent
         */
        public function setAmount(float $amount): WalletPurchaseEvent {
            $this->amount = $amount;

            return $this;
        }

        public function attributesToArray() {
            return ['user_id' => $this->user_id, 'item_type' => $this->item_type, 'item_id' => $this->item_id, 'amount' => $this->amount];
        }
    }
}