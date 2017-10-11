<?php

// src/AppBundle/Controller/ExceptionController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Contentstack\Contentstack;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionController extends Controller {
    public function showExceptionAction()
    {
        return $this->render('TwigBundle::Exception\error404.html.twig');
    }
}