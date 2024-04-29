<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientImportType;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/{_locale}/client/test", name="app_client_importcsv", methods={"GET"})
     */
    public function importCsv(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();

            if (!$file) {
                return $this->json(['error' => 'No file provided'], 400);
            }

            $csv = Reader::createFromPath($file->getRealPath(), 'r');

            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();

            foreach ($records as $record) {
                $client = new Client();

                $client->setName($record['name']);
                $client->setAddress($record['address']);
                $client->setPhone($record['phone']);
                $client->setService($record['service']);
                $client->setIp($record['ip']);
                $client->setCreatedAt(new \DateTime());
                $client->setUpdatedAt(new \DateTime());

                $entityManager->persist($client);
            }

            $entityManager->flush();

            $response = [
                'message' => 'Imported successfully',
            ];

            return $this->render('client/import.html.twig', [
                'form' => $form->createView(),
                'response' => $response,
            ]);
        }

        return $this->render('client/import.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{_locale}/client", name="app_client_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $clients = $entityManager->getRepository(Client::class)->findAll();

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    /**
     * @Route("/{_locale}/client/new", name="app_client_new", methods={"GET"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index');
        }

        return $this->render('client/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{_locale}/client/{id}/edit', name: 'app_client_edit', requirements: ['id' => '\d+'])]

    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index');
        }

        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }

    #[Route('/{_locale}/client/{id}/delete', name: 'app_client_delete', requirements: ['id' => '\d+'])]
    public function delete(Client $client, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($client);
        $entityManager->flush();

        return $this->redirectToRoute('app_client_index');
    }
}