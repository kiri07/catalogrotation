<?php

namespace AleTests\CatalogRotation\Api\CatalogRotationApi\Data;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CatalogRotationRepositoryInterface
{
    /**
     * @param CatalogRotationInterface $catalogRotation
     * @return CatalogRotationInterface
     */
    public function save(CatalogRotationInterface $catalogRotation): CatalogRotationInterface;

    /**
     * @param int $catalogRotationId
     * @return CatalogRotationInterface
     */
    public function getById(int $catalogRotationId): CatalogRotationInterface;

    /**
     * @param SearchCriteriaInterface $criteria
     * @return CatalogRotationSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria): CatalogRotationSearchResultsInterface;

    /**
     * @param CatalogRotationInterface $catalogRotation
     * @return bool
     */
    public function delete(CatalogRotationInterface $catalogRotation): bool;
}
