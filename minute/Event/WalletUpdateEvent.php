<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 2:44 AM
 */
namespace Minute\Event {

    class WalletUpdateEvent extends UserEvent {
        const WALLET_PROCESS_ITEM = 'wallet.process.item';
        /**
         * @var string
         */
        private $item_type;
        /**
         * @var int
         */
        private $item_id;

        /**
         * WalletUpdateEvent constructor.
         *
         * @param int $user_id
         * @param string $item_type
         * @param int $item_id
         */
        public function __construct(int $user_id, string $item_type, int $item_id) {
            parent::__construct($user_id);

            $this->item_type = $item_type;
            $this->item_id   = $item_id;
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
         * @return WalletUpdateEvent
         */
        public function setItemType(string $item_type): WalletUpdateEvent {
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
         * @return WalletUpdateEvent
         */
        public function setItemId(int $item_id): WalletUpdateEvent {
            $this->item_id = $item_id;

            return $this;
        }
    }
}