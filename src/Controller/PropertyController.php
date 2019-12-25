<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/property")
 */
class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="property_index", methods={"GET"})
     */
    public function index(PropertyRepository $propertyRepository,Request $request ,
    PaginatorInterface  $paginator): Response
    {
        $propertySearch=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);
        $appointments = $paginator->paginate(
            // Doctrine Query, not results
            $propertyRepository->findAllVisible($propertySearch),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            7
        );
        return $this->render('property/index.html.twig', [
            'properties' => $appointments,
            'form'=>$form->createView()
        ]);
    }

     /**
     * @Route("/all", name="property_all", methods={"GET"})
     */
    public function all(PropertyRepository $propertyRepository,Request $request ,
    PaginatorInterface  $paginator): Response
    {
        $propertySearch=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class);
        $form->handleRequest($request); 
        $appointments = $paginator->paginate(
            // Doctrine Query, not results
            $propertyRepository->findAll(),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            8
        );
    
        return $this->render('property/index.html.twig', [
            'properties' => $appointments,
            'form'=>$form->createView()
           
        ]);
    }
    
     /**
     * @Route("/last", name="property_last", methods={"GET"})
     */
    public function last(PropertyRepository $propertyRepository,Request $request ,
    PaginatorInterface  $paginator): Response
    { 
        $propertySearch=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class);
        $form->handleRequest($request);
        $appointments = $paginator->paginate(
            // Doctrine Query, not results
            $propertyRepository->findLatest(),
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            6
        );
        return $this->render('property/index.html.twig', [
            'properties' => $appointments,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/new", name="property_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="property_show", methods={"GET"})
     */
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="property_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Property $property): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="property_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Property $property): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_index');
    }
}
