<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/19/2016
 * Time: 4:22 AM
 */
namespace Minute\User {

    use App\Model\User;
    use Minute\Event\Dispatcher;
    use Minute\Event\PaymentUserDataUpdateEvent;
    use Minute\Event\UserUpdateDataEvent;
    use Minute\Wallet\WalletManager;

    class UserDataHandler {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var WalletManager
         */
        private $walletManager;

        /**
         * UserDataHandler constructor.
         *
         * @param Dispatcher $dispatcher
         * @param WalletManager $walletManager
         */
        public function __construct(Dispatcher $dispatcher, WalletManager $walletManager) {
            $this->dispatcher    = $dispatcher;
            $this->walletManager = $walletManager;
        }

        public function update(PaymentUserDataUpdateEvent $event) {
            if ($wallet = $this->walletManager->findOrder($event->getWalletOrderId())) {
                $updates = $event->getUpdates();

                if ($user_id = $wallet->user_id) {
                    $user = User::find($user_id);
                } else {
                    $user = User::where('email', '=', $updates['email'])->first();
                }

                if (!empty($user->user_id)) {
                    $updateEvent = new UserUpdateDataEvent($user, $updates, false);
                    $this->dispatcher->fire(UserUpdateDataEvent::USER_UPDATE_DATA, $updateEvent);
                }
            }
        }
    }
}