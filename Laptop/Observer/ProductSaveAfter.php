<?php
namespace Dell\Laptop\Observer;
use Magento\Framework\Event\ObserverInterface;
class ProductSaveAfter implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $value = \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Framework\App\Config\ScopeConfigInterface::class)
            ->getValue(
                'job/general/admin_name',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            );

            $instance = \Magento\Framework\App\ObjectManager::getInstance();
            $productId = (int)$observer->getProduct()->getId();
            $user = $instance->get('Magento\Backend\Model\Auth\Session')->getUser()->getUsername();
            $action = $instance->create('Magento\Catalog\Model\Product\Action');
            $event = $observer->getEvent();
            $product = $event->getProduct();
            $action->updateAttributes([$productId], array('admin_name' => $user), 0);
            $action->updateAttributes([$productId], array('admin_user' => $user), 0);
            $product->lockAttribute('admin_name');
            $product->lockAttribute('admin_user');


        

    }
}
