<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 8:10 AM
 */
namespace Minute\Wallet {

    use App\Model\MWallet;
    use App\Model\MWalletLog;
    use App\Model\MWalletOrder;
    use Carbon\Carbon;
    use Minute\Event\Dispatcher;
    use Minute\Event\WalletPurchaseEvent;

    class WalletHandler {
        /**
         * @var WalletManager
         */
        private $walletManager;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * WalletHandler constructor.
         *
         * @param WalletManager $walletManager
         * @param Dispatcher $dispatcher
         */
        public function __construct(WalletManager $walletManager, Dispatcher $dispatcher) {
            MWallet::unguard();

            $this->walletManager = $walletManager;
            $this->dispatcher    = $dispatcher;
        }

        public function purchase(WalletPurchaseEvent $event) {
            $amount = abs($event->getAmount());
            $wallet = MWalletOrder::where('item_type', '=', $event->getItemType())->where('item_id', '=', $event->getItemId())->first();

            $wallet_order_id = $wallet->wallet_order_id;

            if ($user_id = $event->getUserId()) { //if user_id is missing, we try to find by wallet_order_id
                $balance = $this->walletManager->getBalanceByUserId($user_id);
            } else {
                $balance = $this->walletManager->getBalanceByWalletOrderId($wallet_order_id);
            }

            if ($balance > $amount) {
                /** @var MWalletLog $log */
                /** @var MWallet $purchase */
                $log = $this->walletManager->logTransaction($user_id ?? 0, $wallet_order_id, null, uniqid($event->getItemType()), $amount, $event->getName(), $event->attributesToArray());

                if ($log) {
                    $purchase = MWallet::create(['user_id' => $wallet->user_id, 'created_at' => Carbon::now(), 'amount' => -$amount, 'payment_type' => 'purchase',
                                                 'wallet_order_id' => $wallet_order_id, 'wallet_log_id' => $log->wallet_log_id]);;
                    $purchase_id = $purchase->wallet_id;
                }
            }

            $this->dispatcher->fire(!empty($purchase_id) ? WalletPurchaseEvent::USER_WALLET_PURCHASE_PASS : WalletPurchaseEvent::USER_WALLET_PURCHASE_FAIL, $event);
        }

        public function purchaseCancel(WalletPurchaseEvent $event) {
            if ($wallet = MWalletOrder::where('item_type', '=', $event->getItemType())->where('item_id', '=', $event->getItemId())->first()) {
                if ($wallet_order_id = $wallet->wallet_order_id) {
                    $lastPurchase = MWallet::where('payment_type', '=', 'purchase')->where('wallet_order_id', '=', $wallet_order_id)->orderBy('created_at', 'DESC')->first();

                    if ($amount = abs($lastPurchase->amount)) {
                        $event->setAmount($amount);

                        $log = $this->walletManager->logTransaction($user_id ?? 0, $wallet_order_id, null, uniqid($event->getItemType()), -$amount, $event->getName(), $event->attributesToArray());

                        if ($log) {
                            /** @var MWallet $purchase */
                            $purchase = MWallet::create(['user_id' => $wallet->user_id, 'created_at' => Carbon::now(), 'amount' => $amount, 'payment_type' => 'purchase_cancel',
                                                         'wallet_order_id' => $wallet_order_id, 'wallet_log_id' => $log->wallet_log_id]);;
                            $purchase_id = $purchase->wallet_id;
                        }

                        $this->dispatcher->fire(!empty($purchase_id) ? WalletPurchaseEvent::USER_WALLET_PURCHASE_CANCEL_PASS : WalletPurchaseEvent::USER_WALLET_PURCHASE_CANCEL_FAIL, $event);
                    }
                }
            }
        }
    }
}