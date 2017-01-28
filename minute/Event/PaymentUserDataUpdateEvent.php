<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/19/2016
 * Time: 4:23 AM
 */
namespace Minute\Event {

    class PaymentUserDataUpdateEvent {
        const PAYMENT_USER_DATA_UPDATE = 'payment.user.data.update';
        /**
         * @var int
         */
        private $wallet_order_id;
        /**
         * @var array
         */
        private $updates;

        /**
         * PaymentUserDataUpdateEvent constructor.
         *
         * @param int $wallet_order_id
         * @param array $updates
         */
        public function __construct(int $wallet_order_id, array $updates) {
            $this->wallet_order_id = $wallet_order_id;
            $this->updates = $updates;
        }

        /**
         * @return int
         */
        public function getWalletOrderId(): int {
            return $this->wallet_order_id;
        }

        /**
         * @param int $wallet_order_id
         *
         * @return PaymentUserDataUpdateEvent
         */
        public function setWalletOrderId(int $wallet_order_id): PaymentUserDataUpdateEvent {
            $this->wallet_order_id = $wallet_order_id;

            return $this;
        }

        /**
         * @return array
         */
        public function getUpdates(): array {
            return $this->updates;
        }

        /**
         * @param array $updates
         *
         * @return PaymentUserDataUpdateEvent
         */
        public function setUpdates(array $updates): PaymentUserDataUpdateEvent {
            $this->updates = $updates;

            return $this;
        }

    }
}