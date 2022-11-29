<?php

namespace Dell\Laptop\Model;

use Magento\Framework\Model\AbstractModel;

class Custom extends AbstractModel  {

const CACHE_TAG = 'id';

    protected function _construct()

{

        $this->_init('Dell\Laptop\Model\ResourceModel\Custom');

  }

public function getIdentities()

    {

        return [self::CACHE_TAG . '_' . $this->getId()];

    }

}
