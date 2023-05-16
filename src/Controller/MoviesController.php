<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MoviesController extends AbstractController
{
    // private $em;
    // public function __construct(EntityManagerInterface $em) {
    //     $this->em = $em;
    // }

    // First example
    // #[Route('/movies', name: 'app_movies')]
    // public function index(MovieRepository $movieRepository): Response
    // {
    //     $movies = $movieRepository->findAll();

    //     dd($movies);

    //     return $this->render('movies/index.html.twig', );
    // }
    private $movieRepository;
    private $em;
    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $em) {
        $this->movieRepository = $movieRepository;
        $this->em = $em;
    }

      #[Route('/movies', methods: ['GET'], name: 'movies')]
    public function index(): Response
    {
        // findAll() - SELECT * from movies;
        // find() - SELECT * from movies WHERE id = 5;
        // findBy() - SELECT * from movies ORDER BY id DESC
        // findOneBy() - SELECT * FROM movies WHERE id = 5 AND title = 'The dark knight' ORDER BY id DESC
        // count() SELECT COUNT() from movies WHERE id = 5

        // $repository = $this->em->getRepository(Movie::class);
        // $movies = $repository->findAll();
        // $movies = $repository->find(5);
        // $movies = $repository->findBy([], ['id' => 'DESC']);
        // $movies = $repository->findOneBy(['id' => 5, 'title' => 'The dark knight'], ['id' => 'DESC']);
        // $movies = $repository->count(['id' => 5]);
        // $movies = $repository->getClassName();

        //dd($movies);
        $movies = $this->movieRepository->findAll();
        
        return $this->render('movies/index.html.twig', [
            'movies' => $movies
        ]);
    }

     
    #[Route('/movies/create', name: 'create_movie')]
    public function create(Request $request): Response {
        $movie = new Movie();
        $form = $this->createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $newMovie = $form->getData();

            $imagePath = $form->get('imagePath')->getData();
            if($imagePath){
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();

                try{
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads', 
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }

                $newMovie->setImagePath('/uploads/' . $newFileName);
            }
            $this->em->persist($newMovie);
            $this->em->flush();
            return $this->redirectToRoute('movies');
        }

        // dd($movie);
        return $this->render('movies/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/movies/{id}', methods: ['GET'], name: 'show_movie')]
    public function details($id): Response {
        $movie = $this->movieRepository->find($id);
        // dd($movie);
        return $this->render('movies/show.html.twig', [
            'movie' => $movie
        ]);
    }

   

 
}
