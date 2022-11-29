<?php

namespace Dell\Laptop\Model\ResourceModel\Custom;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection

{

    protected function _construct()

    {

        $this->_init('Dell\Laptop\Model\Custom','Dell\Laptop\Model\ResourceModel\Custom');

    }

}
