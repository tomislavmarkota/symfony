<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoviesController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    // First example
    // #[Route('/movies', name: 'app_movies')]
    // public function index(MovieRepository $movieRepository): Response
    // {
    //     $movies = $movieRepository->findAll();

    //     dd($movies);

    //     return $this->render('movies/index.html.twig', );
    // }

      #[Route('/movies', name: 'app_movies')]
    public function index(): Response
    {
        // findAll() - SELECT * from movies;
        // find() - SELECT * from movies WHERE id = 5;
        // findBy() - SELECT * from movies ORDER BY id DESC
        // findOneBy() - SELECT * FROM movies WHERE id = 5 AND title = 'The dark knight' ORDER BY id DESC
        // count() SELECT COUNT() from movies WHERE id = 5


        $repository = $this->em->getRepository(Movie::class);
        // $movies = $repository->findAll();
        // $movies = $repository->find(5);
        // $movies = $repository->findBy([], ['id' => 'DESC']);
        // $movies = $repository->findOneBy(['id' => 5, 'title' => 'The dark knight'], ['id' => 'DESC']);
        // $movies = $repository->count(['id' => 5]);
        $movies = $repository->getClassName();

        //dd($movies);

        return $this->render('movies/index.html.twig', );
    }

 
}
