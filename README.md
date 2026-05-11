# BookShelf - Bibliothèque en Ligne

## Installation
1. Clone the repository
2. Run `composer install`
3. Configure database in `.env`
4. Run `php bin/console doctrine:migrations:migrate`
5. Run `php bin/console doctrine:fixtures:load`
6. Start server: `php -S localhost:8000 -t public`

## Test Accounts
- Admin: admin@bookshelf.com / admin123
- Bibliothecaire: biblio@bookshelf.com / biblio123
- User: user@bookshelf.com / user123

## Features
- CRUD operations for books, authors, genres, tags
- User authentication with roles (Admin, Bibliothecaire, User)
- Reading list stored in session
- Search and filter books by title, genre, tag, availability
- API Platform REST API with Swagger documentation
- File upload for book covers
- 30 books loaded via DataFixtures

## API Documentation
- Swagger UI: `/api`

## Technologies
- Symfony 7.4
- Doctrine ORM
- MySQL
- API Platform
- Twig
- Custom CSS
