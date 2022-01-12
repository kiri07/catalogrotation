<?php

namespace AleTests\CatalogRotation\Model\JobsModel\ResourceModel;

class JobResourceModel extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init('catalog_rotation_old_jobs', 'job_id');
    }
}
