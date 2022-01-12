<?php

namespace AleTests\CatalogRotation\Api\JobsApi\Data;

interface JobInterface
{
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const DONE = 'done';
    const ERROR = 'error';

    /**
     * @return int
     */
    public function getJobId(): int;

    /**
     * @return int
     */
    public function getCategoryToDelete(): int;

    /**
     * @param int $categoryToDelete
     * @return void
     */
    public function setCategoryToDelete(int $categoryToDelete): void;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void;
}
