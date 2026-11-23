<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Category;
use App\Entity\Movie;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i =0; $i<5; $i++){
            $category = new Category();
            $category->setNom($faker->word());
            $manager->persist($category);

        }

        for($i=0; $i<30; $i++){
            $movie = new Movie();
            $movie->setTitre($faker->sentence(3));
            $movie->setSynopsis($faker->words(3, true));
            $movie->setDuree($faker->numberBetween(60, 180));
            $movie->setDateSortie($faker->dateTimeBetween('-30 years', 'now'));
            $movie->setNote($faker->randomFloat(1, 0, 5));
            $movie->setAffiche($faker->imageUrl(200, 300, 'movies', true));
            // $category = $manager->getRepository(Category::class)->findOneBy(['id' => $faker->numberBetween(1, 5)]);
            $movie->setCategory($category);
            $manager->persist($movie);
        }


        $manager->flush();
    }
}
