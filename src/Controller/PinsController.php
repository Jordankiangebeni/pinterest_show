<?php

namespace App\Controller;
use App\Entity\Pin;
use App\Form\PinType;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PinsController extends AbstractController
{
    #[Route('/', name: 'app_home', methods:"get|post")]
    public function index(PinRepository $pinRepository):Response
    {
        $pins= $pinRepository->findBy([],["createdAt" =>"DESC"]);

        return $this->render('pins/index.html.twig', compact("pins"));
    }
    #[Route('/pins/create', name: 'app_pins_create')]
    
    public function create(Request $request, EntityManagerInterface $em):Response
    {
        $pin=new Pin;
        $form = $this->createForm(PinType::class,$pin);
             
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em->persist($pin);
            $em->flush();
            $this->addFlash("succes","Pin successfuly created!");

            return $this->redirectToRoute('app_home');

        }
        
        return $this->render("pins/create.html.twig", [

       "Form"=>$form->createView() ]);

    }

    #[Route('/pins/{id<[0-9]+>}', name: 'app_pins_show', methods:"get")]

    public function show(Pin $pin):Response    
    {
       return $this->render("pins/show.html.twig",compact("pin"));


    } 
    
      #[Route('/pins/{id<[0-9]+>}/edit', name: 'app_pins_edit')]
    public function edit(Pin $pin, Request $request, EntityManagerInterface $em):Response
    {
        $form = $this->createForm(PinType::class, $pin);

             $form->handleRequest($request);
             if($form->isSubmitted() && $form->isValid()){

                $em->flush();

                $this->addFlash("succes","Pin successfuly updated!");
    
                return $this->redirectToRoute('app_home');
    
            }
        return $this->render("pins/edit.html.twig",  [
             "pin"=>$pin,
            "Form"=>$form->createView() ]);
        }

        #[Route('/pins/{id<[0-9]+>}/delete', name: 'app_pins_delete',methods:'delete|get')]

    public function delete(Pin $pin, EntityManagerInterface $em):Response 

      {
    
         $em->remove($pin);
         $em->flush();
         $this->addFlash("Notice","Pin successfuly deleted!");
         return $this->redirectToRoute('app_home');

    
   
      
      }

}
