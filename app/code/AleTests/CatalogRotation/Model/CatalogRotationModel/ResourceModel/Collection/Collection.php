<?php

namespace AleTests\CatalogRotation\Model\CatalogRotationModel\ResourceModel\Collection;

use AleTests\CatalogRotation\Model\CatalogRotationModel\CatalogRotation;
use AleTests\CatalogRotation\Model\CatalogRotationModel\ResourceModel\CatalogRotationResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init(CatalogRotation::class, CatalogRotationResourceModel::class);
    }
}
