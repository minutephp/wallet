<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 2:54 AM
 */
namespace Minute\Event {

    class ProcessorPaymentEvent extends Event {
        const IMPORT_PAYMENT_PROCESSORS = 'import.payment.processors';

        const PROCESSOR_CHECKOUT_URL = 'processor.checkout.url';
        /**
         * @var string
         */
        private $processor;
        /**
         * @var
         */
        private $order_id;
        /**
         * @var
         */
        private $item_name;
        /**
         * @var array
         */
        private $payment;

        /**
         * @var string
         */
        private $url;

        /**
         * ProcessorPaymentEvent constructor.
         *
         * @param string $processor
         * @param int $order_id
         * @param string $item_name
         * @param array $payment
         */
        public function __construct(string $processor, $order_id, $item_name, array $payment) {
            $this->processor = $processor;
            $this->order_id  = $order_id;
            $this->item_name = $item_name;
            $this->payment   = $payment;
        }

        /**
         * @return mixed
         */
        public function getUrl() {
            return $this->url;
        }

        /**
         * @param mixed $url
         *
         * @return ProcessorPaymentEvent
         */
        public function setUrl(string $url) {
            $this->url = $url;

            return $this;
        }

        /**
         * @return string
         */
        public function getProcessor(): string {
            return strtolower($this->processor);
        }

        /**
         * @param string $processor
         *
         * @return ProcessorPaymentEvent
         */
        public function setProcessor(string $processor): ProcessorPaymentEvent {
            $this->processor = $processor;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getOrderId() {
            return $this->order_id;
        }

        /**
         * @param mixed $order_id
         *
         * @return ProcessorPaymentEvent
         */
        public function setOrderId($order_id) {
            $this->order_id = $order_id;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getItemName() {
            return $this->item_name;
        }

        /**
         * @param mixed $item_name
         *
         * @return ProcessorPaymentEvent
         */
        public function setItemName($item_name) {
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
         * @return ProcessorPaymentEvent
         */
        public function setPayment(array $payment): ProcessorPaymentEvent {
            $this->payment = $payment;

            return $this;
        }

    }
}