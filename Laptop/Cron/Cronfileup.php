<?php

namespace Dell\Laptop\Cron;
class Cronfileup
{
    
    protected $_productCollectionFactory;

    public function __construct(
       
        \Psr\Log\LoggerInterface $logger,
        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        
        // parent::__construct();
        $this->logger = $logger;
        $this->_productCollectionFactory = $productCollectionFactory;        
      
    }
    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        
        return $collection;
    }
    public function execute()
    {
       
       
        $productCollection = $this->getProductCollection();
        $i =0;
        foreach ($productCollection as $product) {
            // var_dump($product->getData());
            // die();
            
            $per=$product['price'] + $product['price']*5/100;
            $this->logger->info("------------------------line after update");
            if($i < 3){
                $saveData = $product->save();
                $i++;
    
            }
            die();
          
        }
       
    }
 
}