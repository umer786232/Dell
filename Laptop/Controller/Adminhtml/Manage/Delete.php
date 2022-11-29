<?php
namespace Dell\Laptop\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Delete extends Action
{
    public $customFactory;

    public function __construct(
        Context $context,
        \Dell\Laptop\Model\CustomFactory $customFactory
    ) {
        $this->customFactory = $customFactory;
        parent::__construct($context);
    }
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dell_Laptop::delete');
    }
    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            $customModel = $this->customFactory->create();
            $customModel->load($id);
            $customModel->delete();
            $this->messageManager->addSuccessMessage(__('You deleted the blog.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('uiexample/index/index');
    }


}
