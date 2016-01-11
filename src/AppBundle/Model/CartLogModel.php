<?php

namespace AppBundle\Model;

use AppBundle\Entity\CartLog;
use AppBundle\Repository\CartLogRepository;
use AppBundle\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;

class CartLogModel
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var CartLogRepository
     */
    private $cartLogRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * CartLogModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->cartLogRepository = $this->entityManager->getRepository('AppBundle:CartLog');
        $this->productRepository = $this->entityManager->getRepository('AppBundle:Product');
    }

    /**
     * @param integer $productId
     */
    public function addLog($productId)
    {
        $cartLog = new CartLog;
        $cartLog->setSelectionDatetime(new \DateTime);
        $cartLog->setProduct($this->productRepository->find($productId));

        $this->entityManager->persist($cartLog);
        $this->entityManager->flush();
    }
}
