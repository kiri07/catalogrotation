<?php


namespace AleTests\CatalogRotation\Plugin;

use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Url;
use AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class RedirectToCategory
{
    private ResultFactory $resultFactory;
    private Url $url;
    private StoreManagerInterface $storeManager;
    private CatalogRotationRepositoryInterface $catalogRotationRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        ResultFactory $resultFactory,
        Url $url,
        StoreManagerInterface $storeManager,
        CatalogRotationRepositoryInterface $catalogRotationRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->resultFactory = $resultFactory;
        $this->url = $url;
        $this->storeManager = $storeManager;
        $this->catalogRotationRepository = $catalogRotationRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    // subject is required, and callable proceed gets next method
    public function aroundExecute($subject, callable $proceed) {
        $currentStore = $this->storeManager->getStore();
        $array = explode("/", $this->url->getCurrentUrl());
        $requestedPath = end($array);
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('old_url', $requestedPath)
            ->addFilter('store_id', $currentStore->getId())
            ->create();
        $oldProductData = $this->catalogRotationRepository->getList($searchCriteria)->getItems();
        if (!$oldProductData) return $proceed();
        $data = reset($oldProductData);
        $resultInterface = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        // storeManager->baseUrl returns index (magneto.test, no indication of store)
        return $resultInterface->setUrl(
            $currentStore->getBaseUrl() .
            $data->getRedirectionUrl()
        );
    }
}
