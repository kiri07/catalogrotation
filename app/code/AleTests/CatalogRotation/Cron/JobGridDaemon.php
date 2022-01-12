<?php

namespace AleTests\CatalogRotation\Cron;

use AleTests\CatalogRotation\Action\ExtractJobsFromJobAdminGrid;
use AleTests\CatalogRotation\Action\ProcessJob;
use Psr\Log\LoggerInterface;
use AleTests\CatalogRotation\Action\DeleteCategory;

class JobGridDaemon
{
    private ExtractJobsFromJobAdminGrid $extractFirstPendingJobFromJobAdminGrid;
    private LoggerInterface $logger;
    private ProcessJob $processJob;
    private DeleteCategory $deleteCategory;

    public function __construct(
        ExtractJobsFromJobAdminGrid $extractFirstPendingJobFromJobAdminGrid,
        LoggerInterface $logger,
        ProcessJob $processJob,
        DeleteCategory $deleteCategory
    )
    {
        $this->extractFirstPendingJobFromJobAdminGrid = $extractFirstPendingJobFromJobAdminGrid;
        $this->logger = $logger;
        $this->processJob = $processJob;
        $this->deleteCategory = $deleteCategory;
    }

    public function execute(): bool {
        $job = $this->extractFirstPendingJobFromJobAdminGrid->extractFirstPendingJobFromJobAdminGrid();
        $areThereJobsCurrentlyBeingProcessed = $this->extractFirstPendingJobFromJobAdminGrid
            ->areThereJobsCurrentlyProcessed();
        if (!$job || $areThereJobsCurrentlyBeingProcessed) {
            return false;
        }
        $this->logger->info(
            'beginning deletion of category ' . $job->getCategoryToDelete() . '.'
        );
        $this->processJob->setJobToProcessingStatus($job);
        $this->deleteCategory->deleteCategorySetInJob($job);
        $this->processJob->setJobToDoneStatus($job);
        return true;

    }
}
