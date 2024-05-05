<?php

namespace App\Controller;

use App\Entity\ServiceType;
use App\Form\ServiceFormTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceTypeController extends AbstractController
{
    /**
     * @Route("/{_locale}/service-type", name="app_servicetype_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $serviceTypes = $entityManager->getRepository(ServiceType::class)->findAll();

        return $this->render('service_type/index.html.twig', [
            'serviceTypes' => $serviceTypes,
        ]);
    }

    /**
     * @Route("/{_locale}/service-type/new", name="app_servicetype_new", methods={"GET"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serviceType = new ServiceType();

        $form = $this->createForm(ServiceFormTypeType::class, $serviceType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($serviceType);
            $entityManager->flush();

            return $this->redirectToRoute('app_servicetype_index');
        }

        return $this->render('service_type/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{_locale}/service-type/{id}/edit', name: 'app_servicetype_edit', requirements: ['id' => '\d+'])]

    public function edit(Request $request, ServiceType $serviceType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceFormTypeType::class, $serviceType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_servicetype_index');
        }

        return $this->render('service_type/edit.html.twig', [
            'form' => $form->createView(),
            'serviceType' => $serviceType,
        ]);
    }

    #[Route('/{_locale}/service-type/{id}/delete', name: 'app_servicetype_delete', requirements: ['id' => '\d+'])]
    public function delete(ServiceType $serviceType, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($serviceType);
        $entityManager->flush();

        return $this->redirectToRoute('app_servicetype_index');
    }
}
