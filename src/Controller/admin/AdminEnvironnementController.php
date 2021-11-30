<?php
namespace App\Controller\admin;

use App\Entity\Environnement;
use App\Repository\EnvironnementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AdminEnvironnementController
 * @author mc
 */
class AdminEnvironnementController extends AbstractController {

    /**
     *
     * @var EnvironnementRepository 
     */
    private $repository;

    /**
     *
     * @var EntityManagerInterface 
     */
    private $om;

    /**
     * 
     * @param EnvironnementRepository $repository
     * @param EntityManagerInterface $om
     */
    function __construct(EnvironnementRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }
    /**
     * @Route("/admin/environnements", name="admin.environnements")
     * @return Response
     */   
    public function index(): Response{
        $environnements = $this->repository->findAll();
        return $this->render("admin/admin.environnements.html.twig",[
            'environnements' => $environnements
        ]);
    }
        /**
     * @Route("/admin/environnement/suppr/{id}", name="admin.environnement.suppr")
     * @param Environnement $environnement
     * @return Response
     */
    public function suppr(Environnement $environnement): Response{
        $this->om->remove($environnement);
        $this->om->flush();
        return $this->redirectToRoute('admin.environnements');
    } 
    /**
     * @Route("/admin/environnement/ajout", name="admin.environnement.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response {
        $nomEnvironnement = $request->get("nom");
        $environnement = new Environnement();
        $environnement->setNom($nomEnvironnement);
        $this->om->persist($environnement);
        $this->om->flush();
        return $this->redirectToRoute("admin.environnements");
    }

}