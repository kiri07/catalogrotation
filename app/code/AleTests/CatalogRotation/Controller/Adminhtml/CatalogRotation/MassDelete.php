<?php

namespace AleTests\CatalogRotation\Controller\Adminhtml\CatalogRotation;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use AleTests\CatalogRotation\Model\JobsModel\ResourceModel\Collection\CollectionFactory as JobCollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    private Filter $filter;
    private JobCollectionFactory $jobCollectionFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        JobCollectionFactory $jobCollectionFactory
    )
    {
        $this->filter = $filter;
        $this->jobCollectionFactory = $jobCollectionFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->jobCollectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
