<?php

namespace AleTests\CatalogRotation\Model\JobsModel;

use AleTests\CatalogRotation\Api\JobsApi\Data\JobRepositoryInterface;
use AleTests\CatalogRotation\Api\JobsApi\Data\JobSearchResultInterface;
use AleTests\CatalogRotation\Model\JobsModel\ResourceModel\JobResourceModel;
use AleTests\CatalogRotation\Api\JobsApi\Data\JobInterfaceFactory as JobFactory;
use AleTests\CatalogRotation\Api\JobsApi\Data\JobInterface;
use AleTests\CatalogRotation\Model\JobsModel\ResourceModel\Collection\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use AleTests\CatalogRotation\Api\JobsApi\Data\JobSearchResultInterfaceFactory as SearchResultsFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class JobRepository implements JobRepositoryInterface
{
    private JobResourceModel $resource;
    private JobFactory $jobFactory;
    private CollectionFactory $collectionFactory;
    private SearchResultsFactory $searchResultsFactory;
    private CollectionProcessorInterface $collectionProcessor;

    public function __construct(
        JobResourceModel $resource,
        JobFactory $jobFactory,
        CollectionFactory $collectionFactory,
        SearchResultsFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->jobFactory = $jobFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save(JobInterface $job): JobInterface
    {
        try {
            $this->resource->save($job);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $job;
    }

    public function getById($jobId): JobInterface
    {
        $job = $this->jobFactory->create();
        $this->resource->load($job, $jobId);

        if (!$job->getId()) {
            throw new NoSuchEntityException(__('The job associated with the "%1" ID doesn\'t exist.', $jobId));
        }
        return $job;
    }

    public function getList(SearchCriteriaInterface $criteria): JobSearchResultInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /**
         * @var JobSearchResultInterface $searchResults
         */
        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(JobInterface $job): bool
    {
        try {
            $this->resource->delete($job);
        } catch (\Exception $exception) {
            throw new NoSuchEntityException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById(int $jobId): bool
    {
        return $this->delete($this->getById($jobId));
    }
}
