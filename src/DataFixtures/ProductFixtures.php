<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{

    private $faker;

    public function load(ObjectManager $manager)
    {

        $this->faker = Factory::create();

        // Google Pixel - Black
        $product = new Product();
        $product->setName('Google Pixel - Black')
            ->setImage('product-1.png')
            ->setDescription($this->faker->text)
            ->setPrice('182.98');
        $manager->persist($product);

        // Samsung S7
        $product = new Product();
        $product->setName('Samsung S7')
            ->setImage('product-2.png')
            ->setDescription($this->faker->text)
            ->setPrice('74.90');
        $manager->persist($product);

        // HTC 10 - Black
        $product = new Product();
        $product->setName('HTC 10 - Black')
            ->setImage('product-3.png')
            ->setDescription($this->faker->text)
            ->setPrice('130');
        $manager->persist($product);

        // HTC 10 - White
        $product = new Product();
        $product->setName('HTC 10 - White')
            ->setImage('product-4.png')
            ->setDescription($this->faker->text)
            ->setPrice('139.98');
        $manager->persist($product);

        // HTC Desire 626s
        $product = new Product();
        $product->setName('HTC Desire 626s')
            ->setImage('product-5.png')
            ->setDescription($this->faker->text)
            ->setPrice('120.99');
        $manager->persist($product);

        // Vintage Iphone
        $product = new Product();
        $product->setName('Vintage Iphone')
            ->setImage('product-6.png')
            ->setDescription($this->faker->text)
            ->setPrice('96.08');
        $manager->persist($product);

        // iPhone 7
        $product = new Product();
        $product->setName('Iphone 7')
            ->setImage('product-7.png')
            ->setDescription($this->faker->text)
            ->setPrice('299.99');
        $manager->persist($product);

        // Smashed Iphone
        $product = new Product();
        $product->setName('Smashed Iphone')
            ->setImage('product-8.png')
            ->setDescription($this->faker->text)
            ->setPrice('49.99');
        $manager->persist($product);

        $manager->flush();
    }
}
