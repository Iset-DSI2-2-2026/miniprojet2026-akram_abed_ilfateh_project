<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/lecture')]
class ReadingListController extends AbstractController
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    #[Route('/ajouter/{id}', name: 'app_reading_add', methods: ['POST'])]
    public function add(int $id, LivreRepository $livreRepository): Response
    {
        // Get current reading list from session
        $readingList = $this->session->get('reading_list', []);
        
        // Add book ID if not already in list
        if (!in_array($id, $readingList)) {
            $readingList[] = $id;
            $this->session->set('reading_list', $readingList);
            $this->addFlash('success', 'Livre ajouté à votre liste de lecture !');
        } else {
            $this->addFlash('warning', 'Ce livre est déjà dans votre liste de lecture.');
        }
        
        return $this->redirectToRoute('app_livre_show', ['id' => $id]);
    }

    #[Route('/retirer/{id}', name: 'app_reading_remove', methods: ['POST'])]
    public function remove(int $id): Response
    {
        $readingList = $this->session->get('reading_list', []);
        
        if (($key = array_search($id, $readingList)) !== false) {
            unset($readingList[$key]);
            $this->session->set('reading_list', array_values($readingList));
            $this->addFlash('success', 'Livre retiré de votre liste de lecture.');
        }
        
        return $this->redirectToRoute('app_reading_list');
    }

    #[Route('/ma-liste', name: 'app_reading_list', methods: ['GET'])]
    public function list(LivreRepository $livreRepository): Response
    {
        $readingList = $this->session->get('reading_list', []);
        $books = [];
        
        if (!empty($readingList)) {
            $books = $livreRepository->findBy(['id' => $readingList]);
            // Sort books by the order in the session list
            usort($books, function ($a, $b) use ($readingList) {
                return array_search($a->getId(), $readingList) - array_search($b->getId(), $readingList);
            });
        }
        
        return $this->render('reading_list/index.html.twig', [
            'books' => $books,
            'count' => count($readingList),
        ]);
    }

    #[Route('/vider', name: 'app_reading_clear', methods: ['POST'])]
    public function clear(): Response
    {
        $this->session->remove('reading_list');
        $this->addFlash('success', 'Votre liste de lecture a été vidée.');
        
        return $this->redirectToRoute('app_reading_list');
    }
}
