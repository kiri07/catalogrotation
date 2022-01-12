<?php

namespace AleTests\CatalogRotation\Model\CatalogRotationModel;

use AleTests\CatalogRotation\Model\CatalogRotationModel\ResourceModel\CatalogRotationResourceModel;

class CatalogRotation extends \Magento\Framework\Model\AbstractExtensibleModel implements \AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationInterface
{
    const DATA_ID = 'data_id';
    const RELATED_CATEGORY_ID = 'related_category_id';
    const BRAND_ID = 'brand_id';
    const OLD_URL = 'old_url';
    const REDIRECTION_URL = 'redirection_url';
    const STORE_ID = 'store_id';

    public function _construct()
    {
        $this->_init(CatalogRotationResourceModel::class);
    }

    /**
     * @inheritDoc
     */
    public function getDataId(): int
    {
        return $this->getData(self::DATA_ID);
    }

    /**
     * @inheritDoc
     */
    public function getRelatedCategoryId(): int
    {
        return $this->getData(self::RELATED_CATEGORY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setRelatedCategoryId(int $relatedCategoryId)
    {
        $this->setData(self::RELATED_CATEGORY_ID, $relatedCategoryId);
    }

    /**
     * @inheritDoc
     */
    public function getBrandId(): int
    {
        return $this->getData(self::BRAND_ID);
    }

    /**
     * @inheritDoc
     */
    public function setBrandId(int $brandId)
    {
        $this->setData(self::BRAND_ID, $brandId);
    }

    /**
     * @inheritDoc
     */
    public function getOldUrl(): string
    {
        return $this->getData(self::OLD_URL);
    }

    /**
     * @inheritDoc
     */
    public function setOldUrl(string $oldUrl)
    {
        $this->setData(self::OLD_URL, $oldUrl);
    }

    /**
     * @return string
     */
    public function getRedirectionUrl(): string
    {
        return $this->getData(self::REDIRECTION_URL);
    }

    /**
     * @param string $redirectionUrl
     */
    public function setRedirectionUrl(string $redirectionUrl)
    {
        $this->setData(self::REDIRECTION_URL, $redirectionUrl);
    }

    /**
     * @return int
     */
    public function getStoreId(): int
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @param int $storeId
     */
    public function setStoreId(int $storeId)
    {
        $this->setData(self::STORE_ID, $storeId);
    }
}
