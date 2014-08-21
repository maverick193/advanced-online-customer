<?php
/**
 * Cecropia Advanced Online Customers Extension
 *
 * NOTICE OF LICENSE
 *
 *
 * @version     0.1.0
 * @category    Cecropia
 * @package     Cecropia_AdvancedOC
 * @copyright   Copyright (c) 2013
 * @license
 */

/**
 * Install Script
 *
 * @category   Cecropia
 * @package    Cecropia_AdvancedOC
 * @author     Mohammed NAHHAS <m.nahhas@live.fr>
 */

//$installer Mage_Core_Model_Resource_Setup
$installer = $this;

$installer->startSetup();

/**
 * drop table 'cecropia_advancedoc/blockedip' if it exists
 */
if ($installer->getConnection()->isTableExists($installer->getTable('cecropia_advancedoc/blockedip'))) {
    $installer->getConnection()->dropTable($installer->getTable('cecropia_advancedoc/blockedip'));
}

/**
 * Create table 'cecropia_advancedoc/blockedip'
 */

$table = $installer->getConnection()
    ->newTable($installer->getTable('cecropia_advancedoc/blockedip'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Entity Id')
    ->addColumn('nbr_times', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
    ), 'Nbr Of Connections Attempted')
    ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_TEXT, 128, array(
        'nullable'  => false,
    ), 'Ip Address')
    ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
    ), 'Comment')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'        => false,
    ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'        => false,
    ), 'Updated At')
    ->setComment('Blocked Ip Addresses');

$installer->getConnection()->createTable($table);

$installer->endSetup();