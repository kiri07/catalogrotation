<?php

namespace AleTests\CatalogRotation\Model\JobsModel;

use AleTests\CatalogRotation\Model\JobsModel\ResourceModel\JobResourceModel;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use AleTests\CatalogRotation\Api\JobsApi\Data\JobInterface;

class Job extends AbstractModel implements JobInterface
{
    public function _construct()
    {
        $this->_init(JobResourceModel::class);
    }

    public function getJobId(): int
    {
        return $this->getData('job_id');
    }

    public function getCategoryToDelete(): int
    {
        return $this->getData('category_to_delete');
    }

    public function setCategoryToDelete(int $categoryToDelete): void
    {
        $this->setData('category_to_delete', $categoryToDelete);
    }

    public function getStatus(): string
    {
        return $this->getData('status');
    }

    public function setStatus(string $status): void
    {
        $this->setData('status', $status);
    }
}
