<?php

namespace AppBundle\Controller;

use AppBundle\Services\PortfolioItemService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        /**
         * @var PortfolioItemService $portfolioItemService
         */
        $portfolioItemService = $this->get('app.portfolio_item.service');

        return $this->render('AppBundle:Homepage:index.html.twig', array('items'=>$portfolioItemService->getHomepageItems()));
    }
}
