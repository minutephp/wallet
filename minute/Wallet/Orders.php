<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 1:45 AM
 */
namespace Minute\Wallet {

    use App\Model\MWallet;
    use App\Model\MWalletLog;
    use App\Model\MWalletOrder;
    use Minute\Error\PaymentError;
    use Minute\Event\Dispatcher;
    use Minute\Event\ProcessorPaymentEvent;
    use Minute\Event\WalletModifyEvent;
    use Minute\Event\WalletOrderEvent;

    class Orders {
        /**
         * @var WalletManager
         */
        private $walletManager;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * Orders constructor.
         *
         * @param WalletManager $walletManager
         * @param Dispatcher $dispatcher
         */
        public function __construct(WalletManager $walletManager, Dispatcher $dispatcher) {
            $this->walletManager = $walletManager;
            $this->dispatcher    = $dispatcher;
        }

        public function create(WalletOrderEvent $event) {
            $user_id = $event->getUserId();
            $data    = ['user_id' => $user_id, 'processor' => $event->getProcessor(), 'item_type' => $event->getItemType(), 'item_id' => $event->getItemId(),
                        'item_name' => $event->getItemName()];

            /** @var MWalletOrder $order */
            if ($order = MWalletOrder::create($data)) {
                $payment = $event->getPayment();

                if ($event->isUseBalance() && !empty($user_id) && (empty($payment['rebill_amount']) || empty($payment['rebill_time']))) { //one time purchase
                    if ($balance = $this->walletManager->getBalanceByUserId($user_id)) {
                        if (!empty($payment['setup_amount']) && ($balance > $payment['setup_amount'])) { //wallet balance is enough to cover this one time purchase!
                            $this->dispatcher->fire(WalletOrderEvent::USER_WALLET_ORDER_PROCESSED, $event);
                            $this->dispatcher->fire(WalletOrderEvent::USER_WALLET_ORDER_RETURN, $event); //this will set a redirect url

                            return;
                        }
                    }
                }

                $checkoutEvent = new ProcessorPaymentEvent($event->getProcessor(), $order->wallet_order_id, $event->getItemName(), $payment);
                $this->dispatcher->fire(ProcessorPaymentEvent::PROCESSOR_CHECKOUT_URL, $checkoutEvent);

                if ($url = $checkoutEvent->getUrl()) {
                    $event->setRedirect($url);

                    return;
                }

                throw new PaymentError($event->getProcessor() . " did not set a checkout url!");
            }
        }

        public function modify(WalletModifyEvent $event) {
            /** @var MWalletOrder $wallet */
            $wallet = MWalletOrder::where('item_type', '=', $event->getItemType())->where('item_id', '=', $event->getItemId())->first();

            if (!empty($wallet->wallet_order_id)) {
                foreach ($event->getUpdates() as $key => $value) {
                    $wallet->$key = $value;

                    if ($key === 'user_id') {
                        MWallet::where('wallet_order_id', '=', $wallet->wallet_order_id)->limit(10)->update(['user_id' => $value]);
                        MWalletLog::where('wallet_order_id', '=', $wallet->wallet_order_id)->limit(10)->update(['user_id' => $value]);
                    }
                }

                $wallet->save();
            }
        }
    }
}