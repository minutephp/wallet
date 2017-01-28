<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Wallet {

    use App\Model\MWalletDeposit;
    use Carbon\Carbon;
    use Minute\Error\DepositError;
    use Minute\Event\Dispatcher;
    use Minute\Event\WalletOrderEvent;
    use Minute\Session\Session;
    use Minute\View\Redirection;

    class Deposit {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Session
         */
        private $session;

        /**
         * Deposit constructor.
         *
         * @param Dispatcher $dispatcher
         * @param Session $session
         */
        public function __construct(Dispatcher $dispatcher, Session $session) {
            MWalletDeposit::unguard();

            $this->dispatcher = $dispatcher;
            $this->session    = $session;
        }

        public function index($processor = 'paypal', $amount = 0, $configs) {
            $settings = json_decode($configs[0]->data_json ?? '{}', true);

            if (!isset($settings['wallet']['allowDeposits']) || ($settings['wallet']['allowDeposits'] !== false)) {
                $amount  = $amount > 0 ? $amount : 10;
                $payment = ['setup_amount' => $amount, 'description' => "Load wallet for $amount"];
                $user_id = $this->session->getLoggedInUserId();

                /** @var MWalletDeposit $deposit */
                if ($deposit = MWalletDeposit::create(['user_id' => $user_id, 'created_at' => Carbon::now(), 'amount' => $amount, 'status' => 'pending'])) {
                    $event = new WalletOrderEvent($user_id, $processor, 'deposit', $deposit->wallet_deposit_id, "Load wallet", $payment, false);
                    $this->dispatcher->fire(WalletOrderEvent::USER_WALLET_ORDER_START, $event);

                    if ($url = $event->getRedirect()) {
                        return new Redirection($url);
                    }
                }
            }

            throw new DepositError('Deposits are disabled by admin');
        }

        public function checkoutComplete(WalletOrderEvent $event) {
            if (($event->getItemType() === 'deposit') && ($cart_id = $event->getItemId())) {
                $event->setRedirect('/wallet/deposit/complete');
            }
        }

        public function depositComplete(WalletOrderEvent $event) {
            if (($event->getItemType() === 'deposit') && ($deposit_id = $event->getItemId())) {
                /** @var MWalletDeposit $deposit */
                if ($deposit = MWalletDeposit::find($deposit_id)) {
                    $deposit->status = 'complete';
                    $deposit->save();
                }
            }
        }

        public function depositRefund(WalletOrderEvent $event) {
            if (($event->getItemType() === 'deposit') && ($deposit_id = $event->getItemId())) {
                /** @var MWalletDeposit $deposit */
                if ($deposit = MWalletDeposit::find($deposit_id)) {
                    $deposit->status = 'refund';
                    $deposit->save();
                }
            }
        }
    }
}