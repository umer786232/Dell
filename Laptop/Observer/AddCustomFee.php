<?php declare(strict_types=1);
/**
 * Save Custom Fee in sales_order before place an order.
 */

namespace Dell\Laptop\Observer;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddCustomFee implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return $this;
     * @throws Exception
     */
    protected $_request;
    public function __construct(
       
        \Magento\Framework\App\RequestInterface $request
        
       
    )
    {
        
        $this->_request = $request;

    }
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        // Get Order Object
        /* @var $order \Magento\Sales\Model\Order */
        $order = $event->getOrder();
        // Get Quote Object
        /** @var $quote \Magento\Quote\Model\Quote $quote */
        $quote = $event->getQuote();
        $clearance    =$this->_request->getParam('custom-clearance');
        $expertise = isset($clearance) ? 1 : 0;
        $order->setClearance($expertise);
        // echo "<pre>";
        // print_r($expertise);
        // die("uuuuuuuuuuuuuu ");

        if ($quote->getclearance()) {
            $order->setclearance($expertise);
        }
        return $this;
    }
}