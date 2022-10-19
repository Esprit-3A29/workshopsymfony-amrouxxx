<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    #[Route('/formations', name: 'app_formation')]
    public function formations(){
         $var1= '3A29';
         $var2= 'i23';
          $formations = array(
             array('ref' => 'form147', 'Titre' => 'Formation Symfony
4','Description'=>'pratique',
                 'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
                 'nb_participants'=>19) ,
             array('ref'=>'form177','Titre'=>'Formation SOA' ,
                 'Description'=>'theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
                 'nb_participants'=>0),
             array('ref'=>'form178','Titre'=>'Formation Angular' ,
                 'Description'=>'theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
                 'nb_participants'=>12));
        return $this->render("club/list.html.twig",array("c1"=>$var1,"c2"=>$var2,'tab_formations'=>$formations));
    }

    #[Route('/reservation', name: 'app_reservation')]
    public function reservation(){
        return new  Response("La formation selectionnée est la suivante: ".$_GET['formation'].'.');
    }

    #[Route('/clubs', name: 'app_club')]
    public function listClub(ClubRepository $repository) {
        return $this->render("club/listClub.html.twig",array("tabClub"=>$repository->findAll()));
    }

    #[Route('/addClub', name: 'app_addclub')]
    public function addClub(Request $request, ManagerRegistry $doctrine) {
        // empty function as for now
        $club = new Club();
        $em = $doctrine->getManager();
        $form = $this->createForm(ClubType::class, $club);
        if ($form->isSubmitted())
        {

        }


        return $this->renderForm('club/addClub.html.twig', [
            'form' => $form,
        ]);
    }
}