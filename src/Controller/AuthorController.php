<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AuthorType;  
use App\Entity\Author;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/author/show /{name}', name: 'show_Author')]
    public function showAuthor(string $name): Response
    {
        
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/author/list', name: 'author_list')]
    public function listAuthors(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),

        );
        return $this->render('author/list.html.twig', ['authors' => $authors]);
    }

    #[Route('/author/showdetails/{id}', name: 'author_details')]
    public function authorDetails(int $id): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg', 'username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),

        );
        $author = $authors[$id];
        return $this->render('author/showAuthor.html.twig', ['author' => $author]);

} 
 #[Route('/author/listAuthors', name: 'author_list')]
 public function test(AuthorRepository $authorRepository): Response {
    $authors=$authorRepository->findAll();
    return $this->render('author/authorlist.html.twig',['authors'=>$authors,]);
 }
 
 #[Route('/author/delete/{id}', name: 'author_delete')]
public function delete(int $id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager):Response {
    $author = $authorRepository->find($id);

    if ($author) {
        $entityManager->remove($author);
        $entityManager->flush();
    }

    return $this->redirectToRoute('author_list');
}
#[Route('/author/update/{id}',name:'author_update')]
public function update (int $id, Request $request, AuthorRepository $authorRepository, EntityManagerInterface $entityManager):Response {
    $author = $authorRepository->find($id);
    if ($author) {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('author_list');
        } 
        return $this->render('author/update.html.twig', ['form' => $form->createView(),
        'author' => $author,
        ]);


    }
    return $this->redirectToRoute('author_list');

}
#[Route('/author/create', name: 'author_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('author_list');
        } 
        return $this->render('author/create.html.twig', ['form' => $form->createView(),
        ]);
    }
}
