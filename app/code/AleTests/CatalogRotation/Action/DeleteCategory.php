<?php

namespace AleTests\CatalogRotation\Action;

use AleTests\CatalogRotation\Api\JobsApi\Data\JobInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollection;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;


class DeleteCategory
{
    const CONFIGURABLE = 'configurable';
    const ENTITY_TYPE = 'entity_type';
    const ENTITY_ID = 'entity_id';
    const PRODUCT = 'product';
    const REQUEST_PATH = 'request_path';
    const CATEGORY = 'category';
    const TARGET_PATH = 'target_path';

    private ProductCollectionFactory $productCollectionFactory;
    private CategoryCollectionFactory $categoryCollectionFactory;
    private ObtainDataFromProductToBeDeleted $obtainDataFromProductToBeDeleted;
    private UrlRewriteCollectionFactory $urlRewriteCollectionFactory;
    private ProductRepositoryInterface $productRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private StoreManagerInterface $storeManager;

    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory,
        ObtainDataFromProductToBeDeleted $obtainDataFromProductToBeDeleted,
        UrlRewriteCollectionFactory $productUrlRewriteCollectionFactory,
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        StoreManagerInterface $storeManager
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->obtainDataFromProductToBeDeleted = $obtainDataFromProductToBeDeleted;
        $this->urlRewriteCollectionFactory = $productUrlRewriteCollectionFactory;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->storeManager = $storeManager;
    }

    public function deleteCategorySetInJob(JobInterface $job)
    {
        // obtain category model
        /** @var CategoryCollection $categoryCollection */
        $categoryCollection = $this->categoryCollectionFactory
            ->create()
            ->addFilter('entity_id', $job->getCategoryToDelete());
        if ($categoryCollection->getSize() <= 0) return false;
        foreach ($categoryCollection as $category) {
            $categoryToUseAsFilterInProductCollection = $category;
        }

        // obtain collection of products inside category
        // we are sure to have category model as exit condition makes it impossible to have no categories
        /** @var ProductCollection $productCollection */
        $productCollection = $this->productCollectionFactory
            ->create()
            ->addCategoryFilter($categoryToUseAsFilterInProductCollection);

        // add needed data from each product to catalogrotation repository
        // and delete product from collection
        /** @var Product $product */
        foreach ($productCollection as $product) {
            // configurable means it has a url rewrite in this case
            if ($product->getTypeId() == self::CONFIGURABLE) {
                /** @var UrlRewriteCollection $productUrlRewriteCollection */
                $productUrlRewriteCollection = $this->urlRewriteCollectionFactory->create();
                /** @var UrlRewriteCollection $categoryUrlRewriteCollection */
                $categoryUrlRewriteCollection = $this->urlRewriteCollectionFactory->create();
                $targetPath = rtrim(
                    str_replace(
                        $this->storeManager->getStore()->getBaseUrl(),
                        '',
                        $product->getUrlInStore()
                    ),
                    '/ '
                );
                $productUrlRewriteCollection
                    ->addFilter(self::ENTITY_TYPE, self::PRODUCT)
                    ->addFilter(self::ENTITY_ID, $product->getId())
                    ->addFilter(self::TARGET_PATH, $targetPath)
                ;
                $categoryUrlRewriteCollection
                    ->addFilter(self::ENTITY_TYPE, self::CATEGORY)
                    ->addFilter(self::ENTITY_ID, $product->getCategoryIds()[0]);
                $this->obtainDataFromProductToBeDeleted->obtainDataFromProductToBeDeleted(
                    $product,
                    $productUrlRewriteCollection,
                    $categoryUrlRewriteCollection
                );
            }
            $this->productRepository->deleteById($product->getSku());
        }
        // after that, category is empty, we can delete it
        $this->categoryRepository->deleteByIdentifier($job->getCategoryToDelete());
        return true;
    }
}
