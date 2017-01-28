<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use Minute\Event\ImportEvent;

    class WalletMenu {
        public function adminLinks(ImportEvent $event) {
            $links = [
                'processors' => ['title' => 'Processors', 'icon' => 'fa-credit-card', 'href' => '/admin/wallet/processors', 'priority' => 50, 'parent' => 'e-commerce'],
                'wallet' => ['title' => 'Wallet', 'icon' => 'fa-money', 'href' => '/admin/wallet/config', 'priority' => 100, 'parent' => 'e-commerce']
            ];

            $event->addContent($links);
        }

        public function memberLinks(ImportEvent $event) {
            $links = ['member-wallet' => ['title' => "Wallet", 'icon' => 'fa-dollar', 'href' => '/members/wallet', 'priority' => 70]];

            $event->addContent($links);
        }

        public function profileLinks(ImportEvent $event) {
            $tabs = [["href" => "/members/wallet", "label" => "Wallet", "icon" => "fa-money", "priority" => 2]];

            $event->addContent($tabs);
        }
    }
}