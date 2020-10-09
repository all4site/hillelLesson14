<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Brand;
use App\Repository\BrandRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
	/** @var Generator */
	protected $faker;

	/**
	 * @var BrandRepository
	 */
	private $brand;

	public function __construct(BrandRepository $brandRepository)
	{
		$this->brand = $brandRepository;

	}

	public function load(ObjectManager $manager)
	{

		$this->faker = Factory::create();
		for ($i = 0; $i < 20; $i++) {

			$brandid = $this->brand->findOneBy(['id' => $this->faker->randomElement(['1', '2'])]);
			$product = new Product();
			$product->setName($this->faker->firstName);
			$product->setDescription($this->faker->text(100));
			$product->setPrice($this->faker->randomFloat(2, 50, 1000));
			$product->setBrand($brandid);
			$manager->persist($product);
		};


		$manager->flush();
	}

	public function getDependencies()
	{
		return [
				BrandFixtures::class,
		];
	}
}
