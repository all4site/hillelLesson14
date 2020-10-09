<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{
	/**
	 * @Route("/brand/{id}", name="brand")
	 * @param Request $request
	 * @param $id
	 * @return Response
	 */
    public function index(Request $request, $id)
    {
	    $entityManager = $this->getDoctrine()->getManager();
	    $brand = $entityManager->getRepository(Product::class)->findBy([
	    		'brand' => $id
	    ]);

        return $this->render('brand/index.html.twig', [
            'controller_name' => 'BrandController',
	        'brand' => $brand
        ]);
    }
}
