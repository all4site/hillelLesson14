<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class BrandFixtures extends Fixture
{
	/** @var Generator */
	protected $faker;

	public function load(ObjectManager $manager)
	{

		$this->faker = Factory::create();

		for ($i = 0; $i < 2; $i++) {

			$brand = new Brand();
			$brand->setName($this->faker->randomElement(['adidas', 'nike']));
			$brand->setDescription($this->faker->text(100));
			$manager->persist($brand);
		};
		$manager->flush();

	}


}
