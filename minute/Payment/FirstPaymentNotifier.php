<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/7/2016
 * Time: 6:38 PM
 */
namespace Minute\Payment {

    use App\Model\MWallet;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserPaymentEvent;
    use Minute\Event\WalletOrderEvent;

    class FirstPaymentNotifier {
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * FirstPaymentNotifier constructor.
         *
         * @param Dispatcher $dispatcher
         */
        public function __construct(Dispatcher $dispatcher) {
            $this->dispatcher = $dispatcher;
        }

        public function notify(WalletOrderEvent $event) {
            $user_id = $event->getUserId();
            $count   = MWallet::where('user_id', '=', $user_id)->count();

            if (!$count) {
                $this->dispatcher->fire(WalletOrderEvent::USER_WALLET_FIRST_PAYMENT, $event);
            }
        }
    }
}