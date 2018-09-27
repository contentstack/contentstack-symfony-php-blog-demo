<?php

// src/AppBundle/Controller/BlogController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Contentstack\Contentstack;
require_once dirname(__DIR__, 2).'/contentstack-php/src/index.php';

class BlogController extends Controller
{
    /**
     * Matches /blog exactly
     *
     * @Route("/blog", name="blog_list", requirements={"page": "\d+"})
     */
    public function postlistAction()
    {
        $stack = Contentstack::Stack('---Enter API Key---', '---Enter Access Token---', '---Enter published environment name---');
            try {
                $header = $stack->ContentType('header')->Query()->toJSON()->find();
                $results = $stack->ContentType('posts')->Query()->toJSON()->includeReference(array('author'))->descending('date')->find();
                $footers = $stack->ContentType('footer')->Query()->toJSON()->find();
            } catch(Exception $e) {
                echo "Message : ".$e->getMessage(); // returns message -> API -> error_message
                echo "Code : ".$e->getCode(); // returns number -> API -> error_code
                echo "Errors : ".print_r($e->getErrors()); // returns array -> API -> errors
            }

            return $this->render('blog/blog.html.twig', array(
                'results' => $results[0],
                'header' => $header[0][0],
                'footer' => $footers[0][0]
            ));

    }


     /**
     * Matches /blog/*
     *
     * @Route("/blog/{uid}", name="blog_show")
     */
    public function postshowAction($uid)
    {
        // $slug will equal the dynamic part of the URL
        // e.g. at /blog/yay-routing, then $slug='yay-routing'

        $stack = Contentstack::Stack('---Enter API Key---', '---Enter Access Token---', '---Enter published environment name---');
        try {
            $header = $stack->ContentType('header')->Query()->toJSON()->find();
            $postdetails = $stack->ContentType('posts')->Query()->toJSON()->includeReference(array('author'))->where('uid', $uid)->find();
            $footers = $stack->ContentType('footer')->Query()->toJSON()->find();
        } catch(Exception $e) {
            echo "Message : ".$e->getMessage(); // returns message -> API -> error_message
            echo "Code : ".$e->getCode(); // returns number -> API -> error_code
            echo "Errors : ".print_r($e->getErrors()); // returns array -> API -> errors
        }

        return $this->render('blog/post.html.twig', array(
            'uid' => $postdetails[0][0],
            'header' => $header[0][0],
            'footer' => $footers[0][0]
            ));

    }

}
