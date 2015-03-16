<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/* @var $installer \Magento\Setup\Module\SetupModule */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'cron_schedule'
 */
//  `packagename`, `version`, `date`, `counter` 
/*
`packagename` VARCHAR(255) NOT NULL,
  `version` VARCHAR(100) NOT NULL,
  `date` DATE NOT NULL,
  `counter` BIGINT NULL,
  PRIMARY KEY (`packagename`, `version`, `date`));
*/
$table = $installer->getConnection()->newTable(
    $installer->getTable('cotya_composer_downloads')
)->addColumn(
    'entity_id',
    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
    null,
    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
    'Schedule Id'
)->addColumn(
    'packagename',
    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
    255,
    ['identity' => false, 'nullable' => false,],
    'Package Vendor and Name'
)->addColumn(
    'version',
    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
    255,
    ['nullable' => false,],
    'Package Version'
)->addColumn(
    'date',
    \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
    null,
    ['nullable' => false,],
    'date for downloads'
)->addColumn(
    'counter',
    \Magento\Framework\DB\Ddl\Table::TYPE_BIGINT,
    null,
    [],
    'number of downloads'
)->addIndex(
    $installer->getIdxName(
        'unique_per_day',
        ['packagename','version','date'],
        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
    ),
    ['packagename','version','date'],
    [
        'type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
    ]
)->setComment(
    'Cron Schedule'
);
$installer->getConnection()->createTable($table);

$installer->endSetup();
