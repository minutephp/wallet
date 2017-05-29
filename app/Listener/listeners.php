<?php

/** @var Binding $binding */
use App\Controller\Wallet\Deposit;
use Minute\Event\AdminEvent;
use Minute\Event\Binding;
use Minute\Event\MemberEvent;
use Minute\Event\PaymentNotificationEvent;
use Minute\Event\PaymentUserDataUpdateEvent;
use Minute\Event\ProcessorConfigEvent;
use Minute\Event\ProcessorPaymentEvent;
use Minute\Event\TodoEvent;
use Minute\Event\WalletOrderEvent;
use Minute\Event\WalletModifyEvent;
use Minute\Event\WalletPurchaseEvent;
use Minute\Menu\WalletMenu;
use Minute\Payment\FirstPaymentNotifier;
use Minute\Payment\PaymentHandler;
use Minute\Processors\ProcessorList;
use Minute\Todo\WalletTodo;
use Minute\User\UserDataHandler;
use Minute\Wallet\Orders;
use Minute\Wallet\WalletHandler;

$binding->addMultiple([
    //product admin links
    ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [WalletMenu::class, 'adminLinks']],

    //profile tabs
    ['event' => MemberEvent::IMPORT_MEMBERS_PROFILE_LINKS, 'handler' => [WalletMenu::class, 'profileLinks']],

    //get installed processors
    ['event' => ProcessorPaymentEvent::IMPORT_PAYMENT_PROCESSORS, 'handler' => [ProcessorList::class, 'getProcessors']],

    //static event listeners go here
    ['event' => WalletOrderEvent::USER_WALLET_ORDER_START, 'handler' => [Orders::class, 'create'], 'priority' => 99],

    //wallet order modifications
    ['event' => WalletModifyEvent::USER_WALLET_MODIFY, 'handler' => [Orders::class, 'modify'], 'priority' => 99],

    //from processor
    ['event' => PaymentNotificationEvent::PAYMENT_PROCESSING, 'handler' => [PaymentHandler::class, 'unconfirmed']],
    ['event' => PaymentNotificationEvent::PAYMENT_CONFIRMED, 'handler' => [PaymentHandler::class, 'confirmed']],
    ['event' => PaymentNotificationEvent::PAYMENT_REFUND, 'handler' => [PaymentHandler::class, 'refund']],
    ['event' => PaymentNotificationEvent::PAYMENT_CANCEL, 'handler' => [PaymentHandler::class, 'cancel']],

    //optional user update
    ['event' => PaymentUserDataUpdateEvent::PAYMENT_USER_DATA_UPDATE, 'handler' => [UserDataHandler::class, 'update']],

    //from cart
    ['event' => WalletPurchaseEvent::USER_WALLET_PURCHASE, 'handler' => [WalletHandler::class, 'purchase']],
    ['event' => WalletPurchaseEvent::USER_WALLET_PURCHASE_CANCEL, 'handler' => [WalletHandler::class, 'purchaseCancel']],

    //handle pdt for deposits
    ['event' => WalletOrderEvent::USER_WALLET_ORDER_RETURN, 'handler' => [Deposit::class, 'checkoutComplete']],
    ['event' => WalletOrderEvent::USER_WALLET_ORDER_PROCESSED, 'handler' => [Deposit::class, 'depositComplete']],
    ['event' => WalletOrderEvent::USER_WALLET_ORDER_REFUND, 'handler' => [Deposit::class, 'depositRefund']],

    ['event' => MemberEvent::IMPORT_MEMBERS_SIDEBAR_LINKS, 'handler' => [WalletMenu::class, 'memberLinks']],

    //tasks
    ['event' => TodoEvent::IMPORT_TODO_ADMIN, 'handler' => [WalletTodo::class, 'getTodoList']],

    //tracking first payment
    ['event' => WalletOrderEvent::USER_WALLET_ORDER_PROCESSED, 'handler' => [FirstPaymentNotifier::class, 'notify']],
]);