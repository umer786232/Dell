<?php 
namespace Dell\Laptop\Plugin\Model\Quote\Item;

    class ToOrderItem {

        /**
         *
         * @var type \Magento\Catalog\Model\Product
         */
        protected $productRepository;
        protected $_orderFactory;

        /**
         * @param \Magento\Catalog\Model\Product $productRepository 
         */
        public function __construct(
        \Magento\Catalog\Model\Product $productRepository,
        \Magento\Sales\Model\OrderFactory $orderFactory
 
        ) {
            $this->productRepository = $productRepository;
            $this->_orderFactory = $orderFactory;
        }

        /**
         * 
         * @param \Magento\Quote\Model\Quote\Item\ToOrderItem $subject
         * @param \Vendorname\Modulename\Plugin\Model\Quote\Item\callable $proceed
         * @param \Magento\Quote\Model\Quote\Item\AbstractItem $item
         * @param type $additional
         * @return type
         */
        public function aroundConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject, callable $proceed, \Magento\Quote\Model\Quote\Item\AbstractItem $item, $additional = []
        ) {
      
            $orderItem = $proceed($item, $additional);
            $clearance = $item->getclearance();
            $isclearance = ($clearance=="1") ? 1 : 0;
            $orderItem->setclearance($isclearance);//saving into order item in `clearance` column
            return $orderItem;
        }

    }