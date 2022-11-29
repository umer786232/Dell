<?php

namespace Dell\Laptop\Cron;
class Cronfile
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
       
        echo "<pre>";
        $productCollection = $this->getProductCollection();
        $i =0;
        foreach ($productCollection as $product) {
            // var_dump($product->getData());
            // die();
            if($i < 3)  
            {
            $per=$product['price'] + $product['price']*3/100;
            $this->logger->info("------------------------line before update");
            $product->setPrice($per);
            $saveData = $product->save();
            $i++;

            }
   
        }
       
    }
 
}