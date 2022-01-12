<?php

namespace AleTests\CatalogRotation\Api\CatalogRotationApi\Data;

interface CatalogRotationInterface
{
    /**
     * @return int
     */
    public function getDataId(): int;

    /**
     * @return int
     */
    public function getRelatedCategoryId(): int;

    /**
     * @param int $relatedCategoryId
     * @return void
     */
    public function setRelatedCategoryId(int $relatedCategoryId);

    /**
     * @return int
     */
    public function getBrandId(): int;

    /**
     * @param int $brandId
     * @return void
     */
    public function setBrandId(int $brandId);

    /**
     * @return int
     */
    public function getStoreId(): int;

    /**
     * @param int $storeId
     * @return void
     */
    public function setStoreId(int $storeId);

    /**
     * @return string
     */
    public function getOldUrl(): string;

    /**
     * @param string $oldUrl
     * @return void
     */
    public function setOldUrl(string $oldUrl);

    /**
     * @return string
     */
    public function getRedirectionUrl(): string;

    /**
     * @param string $redirectionUrl
     * @return void
     */
    public function setRedirectionUrl(string $redirectionUrl);
}
