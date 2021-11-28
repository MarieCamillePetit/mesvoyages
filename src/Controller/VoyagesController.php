<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of VoyagesController
 *
 * @author mc
 */
class VoyagesController extends AbstractController {
/**
 * @Route("/voyages", name="voyages")
 * @return Response
 */    
    public function index(): Response {
        $visite = $this->repository->findAll();
        return $this->render("pages/voyages.html.twig", [
            'visites' => $visite
        ]);
    }
    
    /**
     * 
     * @var VisiteRepository;
     */
    private $repository;
    
    /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository){
        $this->repository = $repository;
    }
    
}
