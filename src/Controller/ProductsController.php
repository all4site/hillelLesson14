<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Product;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class ProductsController extends AbstractController
{

	/**
	 * @Route("/", name="home")
	 */
	public function home()
	{
		return $this->redirectToRoute('products');
	}

	/**
	 * @Route("/products", name="products")
	 * @param PaginatorInterface $paginator
	 * @param Request $request
	 * @return Response
	 */
	public function index(PaginatorInterface $paginator, Request $request)
	{

		$products = $this->getDoctrine()->getRepository(Product::class)->findBy([], ['id' => 'DESC']);
		$brand = $this->getDoctrine()->getRepository(Brand::class)->findAll();
		$pagination = $paginator->paginate(
				$products,
				$request->query->getInt('page', 1),
				5
		);
		$pagination->setCustomParameters([
				'align' => 'center',
		]);

		return $this->render('products/index.html.twig', [
				'controller_name' => 'ProductsController',
				'products' => $pagination,
				'brand' => $brand
		]);
	}

	/**
	 * @Route("/create", name="create")
	 */
	public function create()
	{
		return $this->render('products/create.html.twig', [
				'controller_name' => 'ProductsController',
		]);
	}

	/**
	 * @Route("/store", name="store")
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{

		$entityManager = $this->getDoctrine()->getManager();
		$product = new Product();
		$product->setName($request->get('name'))
				->setDescription($request->get('description'))
				->setPrice($request->get('price'));
		$entityManager->persist($product);
		$entityManager->flush();

		return $this->redirectToRoute('products');
	}

	/**
	 * @Route("/edit/{id}", name="edit")
	 * @param int $id
	 * @return Response
	 */
	public function edit(int $id)
	{

		$product = $this->getDoctrine()->getRepository(Product::class)->find($id);
		return $this->render('products/edit.html.twig', [
				'controller_name' => 'ProductsController',
				'product' => $product
		]);
	}

	/**
	 * @Route("/update/{id}", name="update")
	 * @param Request $request
	 * @param int $id
	 * @return RedirectResponse
	 */
	public function update(Request $request, int $id)
	{
		$entityManager = $this->getDoctrine()->getManager();

		$product = $entityManager->getRepository(Product::class)->find($id);


		$product->setName($request->get('name'))
				->setDescription($request->get('description'))
				->setPrice($request->get('price'));

		$entityManager->flush();

		return $this->redirectToRoute('products');
	}

	/**
	 * @Route("/show/{id}", name="show")
	 * @param int $id
	 * @return Response
	 */
	public function show(int $id)
	{
		$product = $this->getDoctrine()->getRepository(Product::class)->find($id);
		return $this->render('products/show.html.twig', [
				'controller_name' => 'ProductsController',
				'product' => $product
		]);
	}

	/**
	 * @Route("/delete/{id}", name="delete")
	 * @param int $id
	 * @return Response
	 */
	public function delete(int $id)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$product = $this->getDoctrine()->getRepository(Product::class)->find($id);
		$entityManager->remove($product);
		$entityManager->flush();
		return $this->redirectToRoute('products');
	}

}