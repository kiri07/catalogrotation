<?php

namespace AleTests\CatalogRotation\Action;

use AleTests\CatalogRotation\Api\JobsApi\Data\JobInterface;
use AleTests\CatalogRotation\Api\JobsApi\Data\JobRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class ExtractJobsFromJobAdminGrid
{
    const STATUS_COLUMN_NAME = 'status';

    private JobRepositoryInterface $jobRepository;

    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        JobRepositoryInterface $jobRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->jobRepository = $jobRepository;
    }

    /**
     * @return JobInterface|null
     */
    public function extractFirstPendingJobFromJobAdminGrid(): ?JobInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(self::STATUS_COLUMN_NAME,JobInterface::PENDING)
            ->create();
        $job = $this->jobRepository->getList($searchCriteria)->getItems();
        foreach ($job as $value) {
            return $value;
        }
        return null;
    }

    public function areThereJobsCurrentlyProcessed(): bool
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter(self::STATUS_COLUMN_NAME,JobInterface::PROCESSING)
            ->create();
        $processingJobsCount = $this->jobRepository->getList($searchCriteria)->getTotalCount();
        return $processingJobsCount != 0;
    }
}
