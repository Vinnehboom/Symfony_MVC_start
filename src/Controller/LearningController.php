<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LearningController extends AbstractController
{
    private string $name = 'Unknown';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @Route("/", name="learning")
     */
    public function showMyName(string $name = 'Unknown')
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $session = new Session();
        }
        return $this->render('learning/index.html.twig', ['name' => $name]);
    }

    /**
     * @Route("/about-becode", name="aboutMe")
     */
    public function aboutMe(Session $session)
    {
        if ($session->get('name') == null) {
            return $this->showMyName();

        } else
        {
            $name = $session->get('name');
        }
        return $this->render('learning/aboutMe.html.twig',
        ['name' => $name]);
    }

    /**
     * @Route("/change-name", name="ChangeName", methods={"POST"})
     * @param Request $request
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function changeMyName(Request $request, Session $session){
        $session->set('name', $request->get('name'));
        return $this->showMyName($session->get('name'));}
}
