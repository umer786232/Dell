<?php

namespace Dell\Laptop\Controller\Adminhtml\Ajax;

use Magento\Framework\Controller\ResultFactory;

class UpdateClearance extends \Magento\Backend\App\Action

{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\ResourceConnection $resourceConnection
    ) {
        parent::__construct($context);
        $this->_resourceConnection = $resourceConnection;
    }
    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $clearance    =$this->getRequest()->getParam('item_value');
        $clearanceCheck = $this->getRequest()->getParam('checkbox_val');
        $isclearance = ($clearanceCheck=="true") ? 1 : 0;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $quoteId = $clearance;
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $tableName = $resource->getTableName('quote_item'); 
        $sql = "Update `" . $tableName . "` Set `clearance` = '{$isclearance}' where `item_id` = '{$quoteId}'";        
        
        try{
            $connection->query($sql);
            $response['status'] = "Success";
            $response['msg'] = "Successfully set";
        }catch(\Exception $e){
            $response['status'] = "Fail";
            $response['msg'] = $e->getMessage();
        }
        
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);  //create Json type return object
        $resultJson->setData($response);  

        return $resultJson;
    }

}
