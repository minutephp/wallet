<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class WalletInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_wallet_deposits
        $table = $this->table('m_wallet_deposits', array('id' => 'wallet_deposit_id'));
        $table
            ->addColumn('user_id', 'integer', array('null' => true, 'limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('amount', 'float', array('default' => '0'))
            ->addColumn('status', 'enum', array('default' => 'pending', 'values' => array('pending','complete','refund')))
            ->create();


        // Migration for table m_wallet_logs
        $table = $this->table('m_wallet_logs', array('id' => 'wallet_log_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('wallet_order_id', 'integer', array('null' => true, 'limit' => 11))
            ->addColumn('subscription_id', 'string', array('null' => true, 'limit' => 99))
            ->addColumn('transaction_id', 'string', array('null' => true, 'limit' => 99))
            ->addColumn('amount', 'float', array('null' => true))
            ->addColumn('payment_event', 'string', array('limit' => 99))
            ->addColumn('data_json', 'text', array('limit' => MysqlAdapter::TEXT_LONG))
            ->addColumn('ip_addr', 'string', array('null' => true, 'limit' => 16))
            ->addIndex(array('transaction_id'), array('unique' => true))
            ->create();


        // Migration for table m_wallet_orders
        $table = $this->table('m_wallet_orders', array('id' => 'wallet_order_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('processor', 'string', array('null' => true, 'limit' => 50))
            ->addColumn('item_type', 'string', array('default' => 'cart', 'limit' => 50))
            ->addColumn('item_id', 'integer', array('limit' => 11))
            ->addColumn('item_name', 'string', array('null' => true, 'limit' => 255))
            ->addIndex(array('item_type', 'item_id'), array('unique' => true))
            ->create();


        // Migration for table m_wallets
        $table = $this->table('m_wallets', array('id' => 'wallet_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('amount', 'float', array('default' => '0'))
            ->addColumn('payment_type', 'enum', array('values' => array('deposit','refund','purchase','purchase_cancel')))
            ->addColumn('wallet_order_id', 'integer', array('null' => true, 'limit' => 11))
            ->addColumn('wallet_log_id', 'integer', array('limit' => 11))
            ->create();


    }
}