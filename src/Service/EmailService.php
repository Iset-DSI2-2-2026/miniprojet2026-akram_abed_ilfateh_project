<?php

namespace App\Service;

use App\Entity\Livre;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendNewBookNotification(Livre $livre, User $ajoutePar): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@bookshelf.com', 'BookShelf'))
            ->to(new Address('admin@bookshelf.com', 'Admin BookShelf'))
            ->subject('📗 Nouveau livre ajouté : ' . $livre->getTitre())
            ->htmlTemplate('emails/nouveau_livre.html.twig')
            ->context([
                'livre' => $livre,
                'ajoutePar' => $ajoutePar,
            ]);

        $this->mailer->send($email);
    }
}
