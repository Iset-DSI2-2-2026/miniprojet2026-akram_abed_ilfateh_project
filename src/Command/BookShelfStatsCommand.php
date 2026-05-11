<?php

namespace App\Command;

use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:bookshelf:stats',
    description: 'Affiche les statistiques de la bibliothèque BookShelf',
)]
class BookShelfStatsCommand extends Command
{
    public function __construct(
        private LivreRepository $livreRepository,
        private AuteurRepository $auteurRepository,
        private GenreRepository $genreRepository,
        private TagRepository $tagRepository,
        private UserRepository $userRepository
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('detail', null, InputOption::VALUE_NONE, 'Afficher les détails par genre')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'Format de sortie (table ou json)', 'table');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $detail = $input->getOption('detail');
        $format = $input->getOption('format');

        $totalLivres = $this->livreRepository->count([]);
        $livresDisponibles = $this->livreRepository->count(['disponible' => true]);
        $livresIndisponibles = $totalLivres - $livresDisponibles;
        $totalAuteurs = $this->auteurRepository->count([]);
        $totalGenres = $this->genreRepository->count([]);
        $totalTags = $this->tagRepository->count([]);
        $totalUsers = $this->userRepository->count([]);

        $allBooks = $this->livreRepository->findAll();
        $totalPages = array_sum(array_map(fn($book) => $book->getNbPages(), $allBooks));
        $totalReadingHours = round($totalPages / 30, 2);

        $booksByGenre = [];
        foreach ($this->genreRepository->findAll() as $genre) {
            $booksByGenre[$genre->getNom()] = $this->livreRepository->count(['genre' => $genre]);
        }
        arsort($booksByGenre);

        if ($format === 'json') {
            $data = [
                'total_livres' => $totalLivres,
                'livres_disponibles' => $livresDisponibles,
                'livres_indisponibles' => $livresIndisponibles,
                'total_auteurs' => $totalAuteurs,
                'total_genres' => $totalGenres,
                'total_tags' => $totalTags,
                'total_users' => $totalUsers,
                'total_pages' => $totalPages,
                'temps_lecture_heures' => $totalReadingHours,
                'livres_par_genre' => $booksByGenre,
            ];
            $io->write(json_encode($data, JSON_PRETTY_PRINT));
            return Command::SUCCESS;
        }

        $io->title('📚 BookShelf - Statistiques de la bibliothèque');
        
        $io->section('📊 Vue d\'ensemble');
        $io->table(
            ['Métrique', 'Valeur'],
            [
                ['📖 Nombre total de livres', $totalLivres],
                ['✅ Livres disponibles', $livresDisponibles],
                ['❌ Livres indisponibles', $livresIndisponibles],
                ['👤 Nombre d\'auteurs', $totalAuteurs],
                ['🏷️ Nombre de genres', $totalGenres],
                ['🔖 Nombre de tags', $totalTags],
                ['👥 Nombre d\'utilisateurs', $totalUsers],
                ['📄 Nombre total de pages', number_format($totalPages, 0, ',', ' ')],
                ['⏱️ Temps de lecture total', $totalReadingHours . ' heures'],
            ]
        );

        if ($detail) {
            $io->section('📚 Livres par genre');
            $genreData = [];
            foreach ($booksByGenre as $genre => $count) {
                $genreData[] = [$genre, $count];
            }
            $io->table(['Genre', 'Nombre de livres'], $genreData);

            $topGenres = array_slice($booksByGenre, 0, 3, true);
            $io->success('🏆 Top 3 des genres les plus populaires :');
            foreach ($topGenres as $genre => $count) {
                $io->writeln("   • {$genre}: {$count} livre(s)");
            }
        }

        $io->success('Statistiques récupérées avec succès !');
        return Command::SUCCESS;
    }
}
