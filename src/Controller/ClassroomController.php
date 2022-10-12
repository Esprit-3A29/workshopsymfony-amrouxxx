<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('/addClassroom', name: 'add_Classroom')]
    public function addClassroom(Request $request, ManagerRegistry $doctrine) {
        // empty function as for now
        $classroom = new Classroom();
        $em = $doctrine->getManager();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $em = $doctrine->getManager();
            $em->persist($classroom);
            $em->flush();

            return $this->redirectToRoute('list_classrooms');
        }


        return $this->renderForm('classroom/addClassroom.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/listClassrooms', name: 'list_classrooms')]
    public function listClassroom(ClassroomRepository $repository)
    {
        $classrooms= $repository->findAll();
        // $students= $this->getDoctrine()->getRepository(StudentRepository::class)->findAll();
        return $this->render("classroom/listClassrooms.html.twig",array("tabClassrooms"=>$classrooms));
    }

    #[Route('/updateFormClassroom/{id}', name: 'updateClassroom')]
    public function  updateClassroom($id,ClassroomRepository $repository,ManagerRegistry $doctrine,Request $request)
    {
        $classroom= $repository->find($id);
        $form= $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_classrooms");
        }
        return $this->renderForm("classroom/updateClassroom.html.twig",array("formClassroom"=>$form));
    }

    #[Route('/removeFormClassroom/{id}', name: 'removeClassroom')]

    public function removeClassroom(ManagerRegistry $doctrine,$id,ClassroomRepository $repository)
    {
        $classroom= $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($classroom);
        $em->flush();
        return  $this->redirectToRoute("list_classrooms");
    }
}
