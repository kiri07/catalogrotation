<?php

namespace AleTests\CatalogRotation\Action;

use Magento\Catalog\Model\Product;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollection;
use AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationInterface;
use AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationInterfaceFactory;
use AleTests\CatalogRotation\Api\CatalogRotationApi\Data\CatalogRotationRepositoryInterface;
use Magento\UrlRewrite\Model\UrlRewrite;

class ObtainDataFromProductToBeDeleted
{
    const ENTITY_TYPE = 'entity_type';
    const ENTITY_ID = 'entity_id';
    const PRODUCT = 'product';
    const REQUEST_PATH = 'request_path';

    private CatalogRotationRepositoryInterface $catalogRotationRepository;
    private CatalogRotationInterfaceFactory $catalogRotationFactory;

    public function __construct(
        CatalogRotationRepositoryInterface $catalogRotationRepository,
        CatalogRotationInterfaceFactory $catalogRotationFactory
    )
    {
        $this->catalogRotationRepository = $catalogRotationRepository;
        $this->catalogRotationFactory = $catalogRotationFactory;
    }

    public function obtainDataFromProductToBeDeleted(
        Product $product,
        UrlRewriteCollection $productUrlRewriteCollection,
        UrlRewriteCollection $categoryUrlRewriteCollection
    )
    {
        /** @var UrlRewrite $productUrlRewrite */
        foreach ($productUrlRewriteCollection as $productUrlRewrite) {
            $oldUrl = $productUrlRewrite->getData(self::REQUEST_PATH);
            /** @var UrlRewrite $categoryUrlRewrite */
            foreach ($categoryUrlRewriteCollection as $categoryUrlRewrite) {
                /** @var CatalogRotationInterface $catalogRotationData */
                $catalogRotationData = $this->catalogRotationFactory->create();
                $catalogRotationData->setOldUrl($oldUrl);
                $catalogRotationData->setRelatedCategoryId($product->getCategoryIds()[0]);
                $catalogRotationData->setRedirectionUrl($categoryUrlRewrite->getData(self::REQUEST_PATH));
                $catalogRotationData->setStoreId($categoryUrlRewrite->getStoreId());
                $this->catalogRotationRepository->save($catalogRotationData);
            }
        }
    }
}
