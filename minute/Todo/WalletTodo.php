<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/5/2016
 * Time: 11:04 AM
 */
namespace Minute\Todo {

    use Minute\Config\Config;
    use Minute\Event\ImportEvent;

    class WalletTodo {
        /**
         * @var TodoMaker
         */
        private $todoMaker;
        /**
         * @var Config
         */
        private $config;

        /**
         * MailerTodo constructor.
         *
         * @param TodoMaker $todoMaker - This class is only called by TodoEvent (so we assume TodoMaker is be available)
         * @param Config $config
         */
        public function __construct(TodoMaker $todoMaker, Config $config) {
            $this->todoMaker = $todoMaker;
            $this->config    = $config;
        }

        public function getTodoList(ImportEvent $event) {
            $processors = $this->config->get('wallet/processors', []);

            $todos[] = ['name' => 'Have two or more payment processors', 'description' => 'Have a main and a backup payment processors for site',
                        'status' => count($processors) > 1 ? 'complete' : 'incomplete', 'link' => '/admin/wallet/processors'];

            $todos[] = $this->todoMaker->createManualItem("configure-wallet-deposits", "Configure wallet deposits", 'Configure wallet and user deposit settings', '/admin/wallet/config');
            $todos[] = $this->todoMaker->createManualItem("check-wallet-deposits", "Check wallet deposits", 'Check if purchases are showing in member\'s area (including deposits)', '/members/wallet');
            $todos[] = $this->todoMaker->createManualItem("check-user-deposits", "check-user-deposits", 'Check if users can make deposits to wallet', '/wallet/deposit/start');

            $event->addContent(['Wallet' => $todos]);
        }
    }
}