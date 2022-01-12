<?php

namespace AleTests\CatalogRotation\Model\CatalogRotationModel;

use AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationInterface;
use AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationSearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationSearchResultsInterfaceFactory as SearchResultsFactory;
use AleTests\CatalogRotation\Model\CatalogRotationModel\ResourceModel\Collection\CollectionFactory;
use AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationInterfaceFactory;
use AleTests\CatalogRotation\Model\CatalogRotationModel\ResourceModel\CatalogRotationResourceModel;

class CatalogRotationRepository implements \AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationRepositoryInterface
{

    private CatalogRotationResourceModel $resource;
    private CatalogRotationFactory $catalogRotationFactory;
    private CollectionFactory $collectionFactory;
    private SearchResultsFactory $searchResultsFactory;
    private CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        CatalogRotationResourceModel $resource,
        CatalogRotationFactory $catalogRotationFactory,
        CollectionFactory $collectionFactory,
        SearchResultsFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->catalogRotationFactory = $catalogRotationFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save(CatalogRotationInterface $catalogRotation): CatalogRotationInterface
    {
        try {
            $this->resource->save($catalogRotation);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $catalogRotation;
    }

    public function getById($catalogRotationId): CatalogRotationInterface
    {
        $catalogRotation = $this->catalogRotationFactory->create();
        $this->resource->load($catalogRotation, $catalogRotationId);

        if (!$catalogRotation->getId()) {
            throw new NoSuchEntityException(__('The catalogRotation associated with the "%1" ID doesn\'t exist.', $catalogRotationId));
        }
        return $catalogRotation;
    }

    public function getList(SearchCriteriaInterface $criteria): CatalogRotationSearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /**
         * @var CatalogRotationSearchResultsInterface $searchResults
         */
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(CatalogRotationInterface $catalogRotation): bool
    {
        try {
            $this->resource->delete($catalogRotation);
        } catch (\Exception $exception) {
            throw new NoSuchEntityException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById(int $catalogRotationId): bool
    {
        return $this->delete($this->getById($catalogRotationId));
    }
}
