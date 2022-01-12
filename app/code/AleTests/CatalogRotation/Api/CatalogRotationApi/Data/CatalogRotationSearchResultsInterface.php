<?php

namespace AleTests\CatalogRotation\Api\CatalogRotationApi\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CatalogRotationSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return CatalogRotationInterface[] Array of collection items.
     */
    public function getItems();

    /**
     * Set items.
     *
     * @param CatalogRotationInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
