<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BookShelfExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('time_ago', [$this, 'timeAgo']),
            new TwigFilter('reading_time', [$this, 'readingTime']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('book_status_badge', [$this, 'bookStatusBadge'], ['is_safe' => ['html']]),
        ];
    }

    public function timeAgo(\DateTimeInterface $date): string
    {
        $now = new \DateTime();
        $diff = $now->diff($date);

        if ($diff->y > 0) {
            return 'il y a ' . $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
        }
        if ($diff->m > 0) {
            return 'il y a ' . $diff->m . ' mois';
        }
        if ($diff->d > 0) {
            return 'il y a ' . $diff->d . ' jour' . ($diff->d > 1 ? 's' : '');
        }
        if ($diff->h > 0) {
            return 'il y a ' . $diff->h . ' heure' . ($diff->h > 1 ? 's' : '');
        }
        if ($diff->i > 0) {
            return 'il y a ' . $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
        }
        return 'à l\'instant';
    }

    public function readingTime(int $nbPages): string
    {
        $hours = floor($nbPages / 30);
        $minutes = round(($nbPages % 30) / 30 * 60);
        
        if ($hours === 0) {
            return $minutes . ' min de lecture';
        }
        
        $result = $hours . 'h';
        if ($minutes > 0) {
            $result .= sprintf('%02d', $minutes);
        }
        return $result . ' de lecture';
    }

    public function bookStatusBadge(bool $disponible): string
    {
        if ($disponible) {
            return '<span class="badge badge-success" style="background: #28a745; color: white; padding: 5px 12px; border-radius: 15px;"><i class="bi bi-check-circle"></i> Disponible</span>';
        }
        
        return '<span class="badge badge-danger" style="background: #dc3545; color: white; padding: 5px 12px; border-radius: 15px;"><i class="bi bi-x-circle"></i> Indisponible</span>';
    }
}
