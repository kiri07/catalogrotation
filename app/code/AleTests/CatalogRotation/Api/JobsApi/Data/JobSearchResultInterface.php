<?php

namespace AleTests\CatalogRotation\Api\JobsApi\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface JobSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get items.
     *
     * @return JobInterface[] Array of collection items.
     */
    public function getItems();

    /**
     * Set items.
     *
     * @param JobInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
