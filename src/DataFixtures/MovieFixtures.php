<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('The dark knight');
        $movie->setReleaseYear(2008);
        $movie->setDescription('This is the desc of the Dark Knight');
        $movie->setImagePath('https://cdn.pixabay.com/photo/2023/01/06/02/01/ai-generated-7700259_960_720.jpg');

        //Add data to pivot table
        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_2'));

        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2->setTitle('Avengers: Endgame');
        $movie2->setReleaseYear(2019);
        $movie2->setDescription('This is the desc of the Avengers: Endgame');
        $movie2->setImagePath('https://cdn.pixabay.com/photo/2021/11/12/14/33/captain-america-6789190_960_720.jpg');

          //Add data to pivot table
          $movie2->addActor($this->getReference('actor_3'));
          $movie2->addActor($this->getReference('actor_4'));

        $manager->persist($movie2);

        # this method allows to both queries be perfomed at the same time
        $manager->flush();
    }
}
