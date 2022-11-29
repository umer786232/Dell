<?php
namespace Dell\Laptop\Controller\Adminhtml\Import;

use Exception;
use Dell\Laptop\Model\ImageUploader;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Filesystem\DirectoryList;

class Uploadcsv extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dell_Laptop::manage_pincodes';


    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_filesystem;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * CSV Processor
     *
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;
    protected $imageUploader;

    /**
     * @param Magento\Backend\App\Action\Context $context
     * @param Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Driver\File $driverFile,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\ResourceConnection $resource,
        \Dell\Laptop\Model\CustomFactory $custom,
        \Dell\Laptop\Model\ImageUploader $imageUploader

    ) {
        parent::__construct($context);
        $this->custom = $custom;
        $this->resourceCon =$resource->getConnection();
        $this->_filesystem = $filesystem;
        $this->_storeManager = $storeManager;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        $this->driverFile = $driverFile;
        $this->imageUploader = $imageUploader;


    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $imageId = $this->getRequest()->getParam('param_name', 'myCheckbox');
        $data="file";
            echo "<pre>";

        if($imageId==1){
        print_r("false");
            die();

        }
        else{
            print_r("True");
            die();
        }

        try {

            $result = $this->imageUploader->saveFileToTmpDir($imageId);

            print_r($result);
            die();
            $filepath = $result['url'];

            print_r($filepath);
            die();
            $filepath = explode('media', $filepath)[1];
            $path = $this->directoryList->getPath($this->directoryList::MEDIA).$filepath;

            $importProductRawData = $this->csvProcessor->getData($path);

            $count = 0;

            foreach ($importProductRawData as $rowIndex => $dataRow) {
                if ($rowIndex > 0) {
                    $model = $this->custom->create();
                    $model->addData(
                        [
                            'id' => $dataRow[0],
                            'short_description' => $dataRow[1],
                            'title' => $dataRow[2],
                            'description' => $dataRow[3],
                            'author' => $dataRow[4],

                        ]);
                    $model->save();
                    print_r($importProductRawData);
                    die();
                    $count++;
                }
            }


            $this->messageManager->addSuccess(__('Total %1 records added / updated successfully.', $count));

            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('uiexample/index/index');
        }
        catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);

    }



}
