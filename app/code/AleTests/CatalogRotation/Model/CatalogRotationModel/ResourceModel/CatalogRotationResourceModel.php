<?php

namespace AleTests\CatalogRotation\Model\CatalogRotationModel\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CatalogRotationResourceModel extends AbstractDb
{
    const MAINTABLE = 'catalog_rotation_old_products_data';
    const IDFIELDNAME = 'data_id';

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(self::MAINTABLE, self::IDFIELDNAME);
    }
}
