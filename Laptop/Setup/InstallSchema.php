<?php
namespace Dell\Laptop\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('magecomp_customtable')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('magecomp_customtable')
            )
                ->addColumn('id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ], 'ID')
                ->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'title'
                )
                ->addColumn('short_description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '64k',
                    [
                        'input' => 'textarea'
                    ],
                    'short_description'
                )
                ->addColumn('description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [
                        'input' => 'textarea'
                    ],
                    'description'
                )
                ->addColumn('author',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'author'
                );

            $installer->getConnection()->createTable($table);
            $installer->getConnection()->addIndex(

                $installer->getTable('magecomp_customtable'),
                $setup->getIdxName($installer->getTable('magecomp_customtable'),
                    ['title', 'short_description','description','author'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                    ['title', 'short_description','description','author'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
