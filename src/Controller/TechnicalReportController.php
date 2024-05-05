<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\TechnicalReport;
use App\Form\TechnicalReportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class TechnicalReportController extends AbstractController
{

    #[Route('/{_locale}/technical-report', name: 'app_technicalreport_index')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $techReports = $entityManager->getRepository(TechnicalReport::class)->findAll();

        return $this->render('technical_report/index.html.twig', [
            'techReports' => $techReports,
        ]);
    }

    #[Route('/{_locale}/technical-report/{id}/new', name: 'app_technicalreport_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserInterface $currentUser, Service $service): Response
    {
        $techReport = new TechnicalReport();

        $form = $this->createForm(TechnicalReportType::class, $techReport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $techReport->setService($service);
            $techReport->setUser($currentUser);

            $entityManager->persist($techReport);
            $entityManager->flush();

            $service->setStatus('Completed');
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_service_index');
        }

        return $this->render('technical_report/new.html.twig', [
            'form' => $form->createView(),
            'service' => $service
        ]);
    }

    #[Route('/{_locale}/technical-report/{id}/edit', name: 'app_technicalreport_edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, TechnicalReport $techReport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TechnicalReportType::class, $techReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_technicalreport_index');
        }

        return $this->render('technical_report/edit.html.twig', [
            'form' => $form->createView(),
            'techReport' => $techReport,
        ]);
    }

    #[Route('/{_locale}/technical-report/{id}/delete', name: 'app_technicalreport_delete', requirements: ['id' => '\d+'])]
    public function delete(TechnicalReport $techReport, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($techReport);
        $entityManager->flush();

        return $this->redirectToRoute('app_technicalreport_edit');
    }
}
