<?php

namespace AleTests\CatalogRotation\Action;

use AleTests\CatalogRotation\Api\JobsApi\Data\JobInterface;
use AleTests\CatalogRotation\Api\JobsApi\Data\JobRepositoryInterface;

class ProcessJob
{
    private JobRepositoryInterface $jobRepository;

    public function __construct(
        JobRepositoryInterface $jobRepository
    )
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * @param JobInterface $job
     * @return void
     */
    public function setJobToProcessingStatus(JobInterface $job): void
    {
        $job->setStatus(JobInterface::PROCESSING);
        $this->jobRepository->save($job);
    }

    /**
     * @param JobInterface $job
     * @return void
     */
    public function setJobToDoneStatus(JobInterface $job): void
    {
        $job->setStatus(JobInterface::DONE);
        $this->jobRepository->save($job);
    }

    /**
     * @param JobInterface $job
     * @return void
     */
    public function setJobToErrorStatus(JobInterface $job): void
    {
        $job->setStatus(JobInterface::ERROR);
        $this->jobRepository->save($job);
    }
}
