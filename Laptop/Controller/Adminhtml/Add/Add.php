<?php

namespace Dell\Laptop\Controller\Adminhtml\Add;



class Add extends \Magento\Backend\App\Action

{

    protected $resultPageFactory;

    public function __construct(

        \Magento\Backend\App\Action\Context $context,

        \Magento\Framework\View\Result\PageFactory $resultPageFactory

    ) {

        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;

    }
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dell_Laptop::add');
    }
    public function execute()

    {

        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->prepend(__('Manage Grid'));

        return $resultPage;

    }

}
