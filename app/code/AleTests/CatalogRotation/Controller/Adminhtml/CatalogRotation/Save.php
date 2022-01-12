<?php

namespace AleTests\CatalogRotation\Controller\Adminhtml\CatalogRotation;

class Save extends \Magento\Backend\App\Action
{
    protected $customFactory;

    protected $adapterFactory;

    protected $uploader;

    public function __construct(

        \Magento\Backend\App\Action\Context $context,

        \AleTests\CatalogRotation\Model\JobsModel\JobFactory $customFactory

    ) {

        parent::__construct($context);

        $this->customFactory = $customFactory;

    }

    public function execute()

    {

        $data = $this->getRequest()->getPostValue();

        try {
            $model = $this->customFactory->create();
            $model->addData([
                "category_to_delete" => $data['category_to_delete'],
                "status" => 'pending'
            ]);
            $saveData = $model->save();
            if($saveData){
                $this->messageManager->addSuccess( __('Insert data Successfully !') );
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('*/*/index');

    }
}
