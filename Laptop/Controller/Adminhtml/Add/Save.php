<?php

namespace Dell\Laptop\Controller\Adminhtml\Add;
use Exception;
use Magento\Framework\Filesystem\DirectoryList;
class Save extends \Magento\Backend\App\Action

{
    protected $customFactory;
    protected $adapterFactory;
    protected $uploader;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dell\Laptop\Model\CustomFactory $customFactory
    ) {
        parent::__construct($context);
        $this->customFactory = $customFactory;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Customer::manage');
    }
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        try {
            $model = $this->customFactory->create();
$model->addData([
    "title" => $data['title'],
    "short_description" => $data['short_description'],
    "description" => $data['description'],
    "author" => $data['author'],
]);
$saveData = $model->save();
if($saveData){
    $this->messageManager->addSuccess( __('Insert data Successfully !') );
}
        }catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('uiexample/index/index');
    }
}
