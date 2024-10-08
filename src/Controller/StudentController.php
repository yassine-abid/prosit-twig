<?php

namespace App\Controller;

use App\Entity\Student; // Import your Student entity
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

   

    #[Route('/student/add', name: 'add_student')]
    public function addStudent(Request $request, EntityManagerInterface $entityManager, StudentRepository $studentRepository): Response
    {
        $student = new Student();

        
        $form = $this->createFormBuilder($student)
            ->add('cin', TextType::class)
            ->add('nom', TextType::class)
            ->add('email', TextType::class)
            
            ->getForm();

        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager->persist($student);
            $entityManager->flush();

            
            return $this->redirectToRoute('add_student');
        }

        
        $students = $studentRepository->findAll();

        
        return $this->render('student/student.html.twig', [
            'form' => $form->createView(),
            'students' => $students, 
        ]);
    }
}
