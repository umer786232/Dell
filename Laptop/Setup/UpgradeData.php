<?php

namespace Dell\Laptop\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /* Product Custom Title */
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'admin_name');
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'admin_name',
            [
                'type' => 'varchar',
                'label' => 'Admin Name',
                'input' => 'text',
                'required' => false,
                'sort_order' => 10,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'custom_content_hide',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
            ]
        );

        }
    }
}
