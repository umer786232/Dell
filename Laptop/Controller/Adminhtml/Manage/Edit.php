<?php
namespace Dell\Laptop\Controller\Adminhtml\Manage;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
class Edit extends Action

{

    public function execute()
    {
        //exit("this");
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__("Edit Blog"));
        return $resultPage;
    }
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dell_Laptop::edit');
    }

}
