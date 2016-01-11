<?php

namespace AppBundle\DataProvider;

use AppBundle\Repository\ProductRepository;

class ProductDataProvider
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductDataProvider constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return array id => name
     */
    public function fetchProductsNamesByIds()
    {
        $output = [];
        $products = $this->productRepository->findAll();

        foreach ($products as $product) {
            $output[$product->getId()] = $product->getName();
        }

        return $output;
    }
}
