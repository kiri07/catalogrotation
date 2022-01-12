<?php

namespace AleTests\CatalogRotation\Api\JobsApi\Data;

use Magento\Framework\Api\SearchCriteriaInterface;

interface JobRepositoryInterface
{
    /**
     * @param JobInterface $job
     * @return JobInterface
     */
    public function save(JobInterface $job): JobInterface;

    /**
     * @param int $jobId
     * @return JobInterface
     */
    public function getById(int $jobId): JobInterface;

    /**
     * @param SearchCriteriaInterface $criteria
     * @return JobSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $criteria): JobSearchResultInterface;

    /**
     * @param JobInterface $job
     * @return bool
     */
    public function delete(JobInterface $job): bool;
}
