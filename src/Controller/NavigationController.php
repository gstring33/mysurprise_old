<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavigationController extends AbstractController
{
    public function navigation(): Response
    {
        return $this->render('common/nav.html.twig', []);
    }
}
