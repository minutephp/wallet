<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 4:56 AM
 */
namespace Minute\Event {

    class PaymentNotificationEvent extends Event {
        const PAYMENT_CONFIRMED = "payment.confirmed";  // your payment now belongs to us
        const PAYMENT_REFUND    = "payment.refund";     // the user took his money back

        const PAYMENT_FAIL   = "payment.fail";       // some problem with cc, auto-retry later
        const PAYMENT_CANCEL = "payment.cancel";     // subscriber permanency cancelled subscription

        const PAYMENT_FREE_TRIAL = "payment.free.trial"; // we don't have the money but we have a promise
        const PAYMENT_PROCESSING = "payment.processing";  // user is back on our site after completing checkout (i.e. pdt)

        /**
         * @var string
         */
        private $subscription_id;
        /**
         * @var string
         */
        private $transaction_id;
        /**
         * @var int
         */
        private $item_id;
        /**
         * @var float
         */
        private $amount;
        /**
         * @var array
         */
        private $info; //so far so good but bank hasn't confirmed yet (PDT)
        /**
         * @var string
         */
        private $redirect;

        /**
         * PaymentNotificationEvent constructor.
         *
         * @param string $subscription_id
         * @param string $transaction_id
         * @param int $item_id
         * @param float $amount
         * @param array $info
         */
        public function __construct($subscription_id, $transaction_id, int $item_id, float $amount, array $info) {
            $this->subscription_id = $subscription_id;
            $this->transaction_id  = $transaction_id;
            $this->item_id         = $item_id;
            $this->amount          = $amount;
            $this->info            = $info;
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
         * @return PaymentNotificationEvent
         */
        public function setRedirect($redirect) {
            $this->redirect = $redirect;

            return $this;
        }

        /**
         * @return string
         */
        public function getSubscriptionId() {
            return $this->subscription_id ?? null;
        }

        /**
         * @param string $subscription_id
         *
         * @return PaymentNotificationEvent
         */
        public function setSubscriptionId($subscription_id): PaymentNotificationEvent {
            $this->subscription_id = $subscription_id;

            return $this;
        }

        /**
         * @return string
         */
        public function getTransactionId() {
            return $this->transaction_id ?? null;
        }

        /**
         * @param string $transaction_id
         *
         * @return PaymentNotificationEvent
         */
        public function setTransactionId($transaction_id): PaymentNotificationEvent {
            $this->transaction_id = $transaction_id;

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
         * @return PaymentNotificationEvent
         */
        public function setItemId(int $item_id): PaymentNotificationEvent {
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
         * @return PaymentNotificationEvent
         */
        public function setAmount(float $amount): PaymentNotificationEvent {
            $this->amount = $amount;

            return $this;
        }

        /**
         * @return array
         */
        public function getInfo(): array {
            return $this->info;
        }

        /**
         * @param array $info
         *
         * @return PaymentNotificationEvent
         */
        public function setInfo(array $info): PaymentNotificationEvent {
            $this->info = $info;

            return $this;
        }

    }
}