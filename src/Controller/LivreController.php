<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Tag;
use App\Form\LivreType;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use App\Repository\TagRepository;
use App\Service\EmailService;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/livre')]
class LivreController extends AbstractController
{
    #[Route('/', name: 'app_livre_index', methods: ['GET'])]
    public function index(
        LivreRepository $livreRepository,
        PaginatorInterface $paginator,
        Request $request,
        GenreRepository $genreRepository,
        TagRepository $tagRepository
    ): Response {
        $titre = $request->query->get('titre');
        $genreId = $request->query->get('genre');
        $tagId = $request->query->get('tag');
        $disponible = $request->query->get('disponible');
        
        $genre = $genreId ? $genreRepository->find($genreId) : null;
        $tag = $tagId ? $tagRepository->find($tagId) : null;
        $disponibleBool = ($disponible === '1' ? true : ($disponible === '0' ? false : null));
        
        $books = $livreRepository->findByFilters($titre, $genre, $disponibleBool, $tag);
        
        $livres = $paginator->paginate(
            $books,
            $request->query->getInt('page', 1),
            10
        );
        
        $genres = $genreRepository->findAll();
        $tags = $tagRepository->findAll();
        
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
            'genres' => $genres,
            'tags' => $tags,
        ]);
    }

    #[Route('/new', name: 'app_livre_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_BIBLIOTHECAIRE')]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader = null, EmailService $emailService = null): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile && $fileUploader) {
                $imageName = $fileUploader->upload($imageFile);
                $livre->setImageName($imageName);
            }
            
            $livre->setAjoutePar($this->getUser());
            $entityManager->persist($livre);
            $entityManager->flush();
            
            // Send email notification
            if ($emailService) {
                try {
                    $emailService->sendNewBookNotification($livre, $this->getUser());
                    $this->addFlash('success', 'Livre créé avec succès et email envoyé !');
                } catch (\Exception $e) {
                    $this->addFlash('warning', 'Livre créé mais email non envoyé: ' . $e->getMessage());
                }
            } else {
                $this->addFlash('success', 'Livre créé avec succès !');
            }
            
            return $this->redirectToRoute('app_livre_index');
        }

        return $this->render('livre/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_livre_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_BIBLIOTHECAIRE')]
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && $livre->getAjoutePar() !== $this->getUser()) {
            $this->addFlash('danger', 'Vous ne pouvez modifier que vos propres livres.');
            return $this->redirectToRoute('app_livre_index');
        }

        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                if ($livre->getImageName()) {
                    $fileUploader->remove($livre->getImageName());
                }
                $imageName = $fileUploader->upload($imageFile);
                $livre->setImageName($imageName);
            }
            
            $entityManager->flush();
            $this->addFlash('success', 'Livre modifié avec succès !');
            return $this->redirectToRoute('app_livre_index');
        }

        return $this->render('livre/edit.html.twig', [
            'form' => $form,
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}', name: 'app_livre_delete', methods: ['POST'])]
    #[IsGranted('ROLE_BIBLIOTHECAIRE')]
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && $livre->getAjoutePar() !== $this->getUser()) {
            $this->addFlash('danger', 'Vous ne pouvez supprimer que vos propres livres.');
            return $this->redirectToRoute('app_livre_index');
        }

        if ($this->isCsrfTokenValid('delete' . $livre->getId(), $request->request->get('_token'))) {
            if ($livre->getImageName()) {
                $fileUploader->remove($livre->getImageName());
            }
            $entityManager->remove($livre);
            $entityManager->flush();
            $this->addFlash('success', 'Livre supprimé avec succès !');
        }

        return $this->redirectToRoute('app_livre_index');
    }
}
