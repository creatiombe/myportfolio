<?php

namespace AppBundle\Services;

use AppBundle\Repository\PortfolioItemRepository;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PortfolioItemService
{

    /**
     * @var PortfolioItemRepository
     */
    private $repository;

    public function __construct(PortfolioItemRepository $porfolioItemRepo)
    {
        $this->repository = $porfolioItemRepo;
    }

    public function getHomepageItems()
    {
        $qb = $this->repository->createQueryBuilder('p');

        return $qb->getQuery()->execute();
    }

}