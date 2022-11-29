<?php

namespace Dell\Laptop\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class OrderObserver implements ObserverInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;
    protected $messageManager;
    protected $itemFactory;
    protected $_request;
    protected $_logger; 

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Sales\Model\Order $order,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Sales\Model\Order\ItemFactory $itemFactory,
        \Magento\Framework\App\ResourceConnection $resource,
        \Psr\Log\LoggerInterface $logger,
        ManagerInterface $messageManager
    )
    {
        $this->_objectManager = $objectManager;
        $this->messageManager = $messageManager;
        $this->itemFactory = $itemFactory;
        $this->_logger = $logger;
        $this->resource = $resource->getConnection();
        $this->_request = $request;

    }


    public function execute(Observer $observer)
    {
        //  /** @var OrderInterface $order */
        
        $order = $this->itemFactory->create()->getCollection();
    foreach ($order as $items) {
        $productid=$items->getitem_id(); 
        
        
    
    // die("~~~~~~~~~~~");
    $Invoice = $observer->getEvent()->getInvoice();
        foreach($Invoice->getItems() as $invoiceitem){
            $invoiceid=$invoiceitem->getorder_item_id();
            if($productid==$invoiceid){
                // print_r($productid); 
                // print_r($productid);

                $clearance = $items->getclearance();
                $isclearance = ($clearance=="1") ? 1 : 0;
                $invoiceitem->setclearance($isclearance);
            }
            
            
        
        }
    }
    // return $invoice;
    }
}