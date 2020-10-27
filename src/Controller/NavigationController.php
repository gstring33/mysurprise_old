<?php

namespace App\Controller;

use App\Service\ListManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends AbstractController
{
    /** @var ListManager */
    private $listManager;

    /**
     * NavigationController constructor.
     * @param ListManager $listManager
     */
    public function __construct(ListManager $listManager)
    {
        $this->listManager = $listManager;
    }

    public function navigation(): Response
    {
        $username = $this->getUser()->getUsername();
        $isAllowedToManageList = $this->listManager->isAllowedToManageList($username);

        return $this->render('common/nav.html.twig', [
            'isAllowedToManageList' => $isAllowedToManageList,
        ]);
    }
}
