<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 6:58 AM
 */

namespace Minute\Event {

    class WalletModifyEvent extends Event {
        const USER_WALLET_MODIFY = 'user.wallet.modify';
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
         * WalletModifyEvent constructor.
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
         * @return WalletModifyEvent
         */
        public function setItemType(string $item_type): WalletModifyEvent {
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
         * @return WalletModifyEvent
         */
        public function setItemId(int $item_id): WalletModifyEvent {
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
         * @return WalletModifyEvent
         */
        public function setUpdates(array $updates): WalletModifyEvent {
            $this->updates = $updates;

            return $this;
        }
    }
}