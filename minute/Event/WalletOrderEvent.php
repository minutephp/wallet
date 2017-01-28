<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 1:38 AM
 */
namespace Minute\Event {

    class WalletOrderEvent extends UserEvent {
        //shopping cart
        const USER_WALLET_ORDER_START  = "user.wallet.order.start";
        const USER_WALLET_ORDER_RETURN = "user.wallet.order.return";

        const USER_WALLET_ORDER_PROCESSED = "user.wallet.order.process";
        const USER_WALLET_ORDER_CANCELLED = "user.wallet.order.cancelled";
        const USER_WALLET_ORDER_REFUND    = "user.wallet.order.refund";

        const USER_WALLET_FIRST_PAYMENT = "user.wallet.first.payment";

        //wallet ipn
        //const USER_WALLET_DEPOSIT = "user.wallet.deposit";
        //const USER_WALLET_REFUND  = "user.wallet.refund";

        /**
         * @var string
         */
        private $processor;
        /**
         * @var string
         */
        private $item_type;
        /**
         * @var int
         */
        private $item_id;
        /**
         * @var string
         */
        private $item_name;
        /**
         * @var array
         */
        private $payment;
        /**
         * @var bool
         */
        private $useBalance;
        /**
         * @var string
         */
        private $redirect;

        /**
         * WalletOrderEvent constructor.
         *
         * @param int $user_id
         * @param string $processor
         * @param string $item_type
         * @param int $item_id
         * @param string $item_name
         * @param array $payment
         * @param bool $useBalance
         */
        public function __construct(int $user_id, string $processor, string $item_type, int $item_id, string $item_name, array $payment = [], bool $useBalance = true) {
            parent::__construct($user_id);

            $this->processor  = $processor;
            $this->item_type  = $item_type;
            $this->item_id    = $item_id;
            $this->item_name  = $item_name;
            $this->payment    = $payment;
            $this->useBalance = $useBalance;
        }

        /**
         * @return mixed
         */
        public function getRedirect() {
            return $this->redirect;
        }

        /**
         * @param mixed $redirect
         *
         * @return WalletOrderEvent
         */
        public function setRedirect($redirect) {
            $this->redirect = $redirect;

            return $this;
        }

        /**
         * @return boolean
         */
        public function isUseBalance(): bool {
            return $this->useBalance;
        }

        /**
         * @param boolean $useBalance
         *
         * @return WalletOrderEvent
         */
        public function setUseBalance(bool $useBalance): WalletOrderEvent {
            $this->useBalance = $useBalance;

            return $this;
        }

        /**
         * @return string
         */
        public function getProcessor(): string {
            return $this->processor;
        }

        /**
         * @param string $processor
         *
         * @return WalletOrderEvent
         */
        public function setProcessor(string $processor): WalletOrderEvent {
            $this->processor = $processor;

            return $this;
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
         * @return WalletOrderEvent
         */
        public function setItemType(string $item_type): WalletOrderEvent {
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
         * @return WalletOrderEvent
         */
        public function setItemId(int $item_id): WalletOrderEvent {
            $this->item_id = $item_id;

            return $this;
        }

        /**
         * @return string
         */
        public function getItemName(): string {
            return $this->item_name;
        }

        /**
         * @param string $item_name
         *
         * @return WalletOrderEvent
         */
        public function setItemName(string $item_name): WalletOrderEvent {
            $this->item_name = $item_name;

            return $this;
        }

        /**
         * @return array
         */
        public function getPayment(): array {
            return $this->payment;
        }

        /**
         * @param array $payment
         *
         * @return WalletOrderEvent
         */
        public function setPayment(array $payment): WalletOrderEvent {
            $this->payment = $payment;

            return $this;
        }

        public function attributesToArray() {
            return ['user_id' => $this->user_id, 'processor' => $this->processor, 'item_type' => $this->item_type, 'item_id' => $this->item_id, 'item_name' => $this->item_name,
                    'payment' => $this->payment];
        }
    }
}