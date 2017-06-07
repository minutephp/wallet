<?php

/** @var Router $router */
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/admin/wallet/processors', null, 'admin', 'm_configs[type] as configs')
       ->setReadPermission('configs', 'admin')->setDefault('type', 'wallet');
$router->post('/admin/wallet/processors', null, 'admin', 'm_configs as configs')
       ->setAllPermissions('configs', 'admin');

$router->get('/admin/wallet/config', null, 'admin', 'm_configs[type] as configs')
       ->setReadPermission('configs', 'admin')->setDefault('type', 'wallet');
$router->post('/admin/wallet/config', null, 'admin', 'm_configs as configs')
       ->setAllPermissions('configs', 'admin');

$router->get('/members/wallet', null, true, 'm_wallets[5] as wallets ORDER by created_at DESC', 'm_wallet_logs[wallets.wallet_log_id] as log ORDER BY created_at DESC',
    'm_wallet_orders[wallets.wallet_order_id] as order', 'm_configs[type] as configs')
       ->setDefault('wallets', '*')->setDefault('type', 'wallet')
       ->setReadPermission('wallets', Permission::SAME_USER)->setReadPermission('configs', Permission::ANY_USER);

$router->post('/members/wallet', null, true, 'm_wallets as wallets')
       ->setAllPermissions('wallets', Permission::SAME_USER);

//deposits
$router->get('/wallet/deposit/start', 'Wallet/Deposit', false, 'm_configs[type] as configs')
       ->setReadPermission('configs', Permission::EVERYONE)->setDefault('type', 'wallet')->setDefault('_noView', true);
$router->get('/wallet/deposit/complete', null, false);

$router->get('/members/wallet/invoice/{wallet_log_id}', null, true, 'm_wallet_logs[wallet_log_id][1] as logs', 'm_wallet_orders[logs.wallet_order_id] as order',
    'm_product_carts[product_cart_id=order.item_id] as cart', 'm_products[cart.product_id] as product');

