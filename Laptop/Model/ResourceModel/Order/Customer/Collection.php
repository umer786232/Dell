<?php
namespace Vendor\Module\Model\ResourceModel\Order\Customer;

class Collection extends \Magento\Sales\Model\ResourceModel\Order\Customer\Collection
{
    /**
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->addAttributeToSelect(
            'clearence_item'
        );
        return $this;
    }
}
