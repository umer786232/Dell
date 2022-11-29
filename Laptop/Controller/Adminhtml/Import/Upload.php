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


class Upload extends \Magento\Backend\App\Action
{
    /**
     * Image uploader
     *
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Upload constructor.
     *
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        DirectoryList $directoryList,
        \Magento\Framework\File\Csv $csvProcessor,
        \Dell\Laptop\Model\CustomFactory $custom,
        \Magento\Framework\App\ResourceConnection $resource,
        ImageUploader $imageUploader,
        array $data = array()
    ) {
        $this->_custom = $custom;
        parent::__construct($context);
        $this->csvProcessor = $csvProcessor;
        $this->resourceCon = $resource->getConnection();
        $this->directoryList = $directoryList;
        $this->imageUploader = $imageUploader;
    }
    public function getCollection(){

        return $this->_custom->create()->getCollection();

    }
    /**
     * Upload file controller action
     *
     * @return ResultInterface
     */
    public function execute()
    {
       $imageId = $this->_request->getParam('param_name');
        $getdata=$this->getCollection()->getData();
        //echo"<pre>";



        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
//            print_r($result);
//            die();
            $filePath = $result['url'];
            $filePath = explode('media', $filePath)[1];

            // http://bm.co.pk/media/codextblog/tmp/feature/test_19.csv

            $path = $this->directoryList->getPath($this->directoryList::MEDIA).$filePath;

            $importProductRawData =(array)$this->csvProcessor->getData($path);
            $model = $this->_custom->create();
            $count = 0;
            foreach ($importProductRawData as $rowIndex => $dataRow)
            {
                if($rowIndex > 0) {
                    $x=0;
                    foreach ($getdata as $value) {
                        $y = $value;
//
//                    print_r($y);
//                    die("!!");
                        if ($y['author'] == $dataRow[4] && $y['description'] == $dataRow[3]) {
                            $x++;
                        }
                    }



                    if($x==0)
                    {
                        $model->setData(
                            [

                                'title' => $dataRow[1],
                                'short_description' => $dataRow[2],
                                'description' => $dataRow[3],
                                'author' => $dataRow[4],

                            ]);

                        $saveData = $model->save();

//
                    }


                }
            }
            if($x==0) {
                if ($saveData) {

                    $this->messageManager->addSuccess(__('Insert data Successfully !'));

                }
            }
            else{
                $this->messageManager->addSuccess( __('Data already exist !') );

            }


        } catch (Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
