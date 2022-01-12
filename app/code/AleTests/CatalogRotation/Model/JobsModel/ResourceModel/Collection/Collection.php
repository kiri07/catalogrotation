<?php

namespace AleTests\CatalogRotation\Model\JobsModel\ResourceModel\Collection;

use Magento\Framework\DB\Select;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AleTests\CatalogRotation\Model\JobsModel\Job as JobModel;
use AleTests\CatalogRotation\Model\JobsModel\ResourceModel\JobResourceModel;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            JobModel::class,
            JobResourceModel::class
        );
    }
}
