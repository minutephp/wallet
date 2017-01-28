<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 6:58 AM
 */
namespace Minute\Event {

    class WalletOrderModifyEvent extends Event {
        const USER_WALLET_ORDER_MODIFY = 'user.wallet.order.modify';
        /**
         * @var string
         */
        private $item_type;
        /**
         * @var int
         */
        private $item_id;
        /**
         * @var array
         */
        private $updates;

        /**
         * WalletOrderModifyEvent constructor.
         *
         * @param string $item_type
         * @param int $item_id
         * @param array $updates
         */
        public function __construct(string $item_type, int $item_id, array $updates) {
            $this->item_type = $item_type;
            $this->item_id   = $item_id;
            $this->updates   = $updates;
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
         * @return WalletOrderModifyEvent
         */
        public function setItemType(string $item_type): WalletOrderModifyEvent {
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
         * @return WalletOrderModifyEvent
         */
        public function setItemId(int $item_id): WalletOrderModifyEvent {
            $this->item_id = $item_id;

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
         * @return WalletOrderModifyEvent
         */
        public function setUpdates(array $updates): WalletOrderModifyEvent {
            $this->updates = $updates;

            return $this;
        }
    }
}