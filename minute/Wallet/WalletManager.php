<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/15/2016
 * Time: 1:48 AM
 */
namespace Minute\Wallet {

    use App\Model\MWallet;
    use App\Model\MWalletLog;
    use App\Model\MWalletOrder;
    use Carbon\Carbon;
    use Minute\Utils\Sniffer;

    class WalletManager {
        /**
         * @var Sniffer
         */
        private $sniffer;

        /**
         * WalletManager constructor.
         *
         * @param Sniffer $sniffer
         */
        public function __construct(Sniffer $sniffer) {
            MWallet::unguard();
            MWalletLog::unguard();
            MWalletOrder::unguard();

            $this->sniffer = $sniffer;
        }

        public function getBalanceByUserId($user_id) {
            return $user_id > 0 ? MWallet::where('user_id', '=', $user_id)->sum('amount') : 0;
        }

        public function getBalanceByWalletOrderId($wallet_order_id) {
            return $wallet_order_id > 0 ? MWallet::where('wallet_order_id', '=', $wallet_order_id)->sum('amount') : 0;
        }

        /**
         * @param int $user_id
         * @param int $wallet_order_id
         * @param $subscription_id
         * @param $transaction_id
         * @param float $amount
         * @param $payment_event
         * @param array $data
         *
         * @return MWalletLog|bool
         */
        public function logTransaction(int $user_id, int $wallet_order_id, $subscription_id, $transaction_id, float $amount, $payment_event, array $data) {
            $data = ['user_id' => $user_id, 'created_at' => Carbon::now(), 'wallet_order_id' => $wallet_order_id, 'subscription_id' => $subscription_id, 'transaction_id' => $transaction_id,
                     'payment_event' => $payment_event, 'amount' => $amount, 'data_json' => json_encode($data), 'ip_addr' => $this->sniffer->getUserIP()];

            try {
                return MWalletLog::create($data);
            } catch (\Throwable $e) {
                echo '';
            }

            return false;
        }

        /**
         * @param int $wallet_order_id
         *
         * @return MWallet
         */
        public function findOrder(int $wallet_order_id) {
            return MWalletOrder::find($wallet_order_id);
        }
    }
}