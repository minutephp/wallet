<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 5:05 AM
 */
namespace Minute\Payment {

    use App\Model\MWallet;
    use Carbon\Carbon;
    use Minute\Event\Dispatcher;
    use Minute\Event\PaymentNotificationEvent;
    use Minute\Event\WalletOrderEvent;
    use Minute\View\Redirection;
    use Minute\Wallet\WalletManager;

    class PaymentHandler {
        /**
         * @var WalletManager
         */
        private $walletManager;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * PaymentHandler constructor.
         *
         * @param WalletManager $walletManager
         * @param Dispatcher $dispatcher
         */
        public function __construct(WalletManager $walletManager, Dispatcher $dispatcher) {
            MWallet::unguard();

            $this->walletManager = $walletManager;
            $this->dispatcher    = $dispatcher;
        }

        /**
         * @param PaymentNotificationEvent $event
         */
        public function unconfirmed(PaymentNotificationEvent $event) {
            if ($order = $this->processEvent(0, $event)) {
                $walletEvent = new WalletOrderEvent($order->user_id, $order->processor, $order->item_type, $order->item_id, $order->item_name);
                $this->dispatcher->fire(WalletOrderEvent::USER_WALLET_ORDER_RETURN, $walletEvent);

                if ($url = $walletEvent->getRedirect()) {
                    $event->setRedirect($url);
                }
            }
        }

        public function confirmed(PaymentNotificationEvent $event) {
            if ($order = $this->processEvent($event->getAmount(), $event)) {
                $walletEvent = new WalletOrderEvent($order->user_id, $order->processor, $order->item_type, $order->item_id, $order->item_name);
                $this->dispatcher->fire(WalletOrderEvent::USER_WALLET_ORDER_PROCESSED, $walletEvent);
            }
        }

        public function refund(PaymentNotificationEvent $event) {
            if ($order = $this->processEvent(-1 * abs($event->getAmount()), $event)) {
                $walletEvent = new WalletOrderEvent($order->user_id, $order->processor, $order->item_type, $order->item_id, $order->item_name);
                $this->dispatcher->fire(WalletOrderEvent::USER_WALLET_ORDER_REFUND, $walletEvent);
            }
        }

        public function cancel(PaymentNotificationEvent $event) {
            if ($order = $this->processEvent(0, $event)) {
                $walletEvent = new WalletOrderEvent($order->user_id, $order->processor, $order->item_type, $order->item_id, $order->item_name);
                $this->dispatcher->fire(WalletOrderEvent::USER_WALLET_ORDER_CANCELLED, $walletEvent);
            }
        }

        protected function processEvent(float $amount, PaymentNotificationEvent $event) {
            if ($order = $this->walletManager->findOrder($event->getItemId())) {
                $log = $this->walletManager->logTransaction($order->user_id, $event->getItemId(), $event->getSubscriptionId(), $event->getTransactionId(), $event->getAmount(),
                    $event->getName(), $event->getInfo());

                if ($log) {
                    if ($amount != 0) {
                        MWallet::create(['user_id' => $order->user_id, 'created_at' => Carbon::now(), 'amount' => $amount, 'payment_type' => $amount > 0 ? 'deposit' : 'refund',
                                         'wallet_order_id' => $order->wallet_order_id, 'wallet_log_id' => $log->wallet_log_id]);
                    }

                    return $order;
                }
            }

            return false;
        }
    }
}