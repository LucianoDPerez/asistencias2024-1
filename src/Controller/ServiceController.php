<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\ServiceType;
use App\Entity\TechnicalReport;
use App\Form\ServiceFilterFormType;
use App\Form\ServicesFormType;
use App\Form\TechnicalReportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ServiceController extends AbstractController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    /**
     * @Route("/{_locale}/service", name="app_service_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request): Response

    {
        $serviceTypes = $entityManager
            ->getRepository(ServiceType::class)
            ->findAll();

        $searchForm = $this->createForm(ServiceFilterFormType::class, null, [
            'service_types' => $serviceTypes,
        ]);

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData();

            $queryBuilder = $entityManager
                ->getRepository(Service::class)
                ->createQueryBuilder('s');

            if ($data['serviceType']) {
                $queryBuilder
                    ->andWhere('s.serviceType = :serviceType')
                    ->setParameter('serviceType', $data['serviceType']);
            }

            if ($data['dateStart'] || $data['dateEnd']) {
                $queryBuilder
                    ->andWhere('s.assignedDate BETWEEN :dateStart AND :dateEnd')
                    ->setParameter('dateStart', $data['dateStart']->format('Y-m-d'))
                    ->setParameter('dateEnd', $data['dateEnd']->format('Y-m-d') . ' 23:59:59');
            }

            $services = $queryBuilder->getQuery()->getResult();

            return $this->render('service/_table.html.twig', [
                'services' => $services,
            ]);
        } else {
            $services = $entityManager
                ->getRepository(Service::class)
                ->findAll();
        }

        return $this->render('service/index.html.twig', [
            'services' => $services,
            'form' => $searchForm->createView(),
        ]);

    }

    /**
     * @Route("/{_locale}/service/{id}/show", name="app_service_show", methods={"GET"})
     */
    public function show(EntityManagerInterface $entityManager, Request $request, Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }
    /**
     * @Route("/{_locale}/service/new", name="app_service_new", methods={"GET"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new service();

        $form = $this->createForm(ServicesFormType::class, $service, ['translator' => $this->translator]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_service_index');
        }

        return $this->render('service/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{_locale}/service/{id}/edit', name: 'app_service_edit', requirements: ['id' => '\d+'])]

    public function edit(Request $request, Serviceervice $service, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_service_index');
        }

        return $this->render('service/edit.html.twig', [
            'form' => $form->createView(),
            'service' => $service,
        ]);
    }

    #[Route('/{_locale}/service/{id}/delete', name: 'app_service_delete', requirements: ['id' => '\d+'])]
    public function delete(Service $service, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($service);
        $entityManager->flush();

        return $this->redirectToRoute('app_service_index');
    }
}
