<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/16/2016
 * Time: 4:46 AM
 */
namespace Minute\Interfaces {

    use Minute\Event\ProcessorPaymentEvent;

    interface PaymentProcessor {
        public function checkout(ProcessorPaymentEvent $event);
    }
}