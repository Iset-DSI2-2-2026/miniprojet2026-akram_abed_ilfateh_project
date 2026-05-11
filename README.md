# BookShelf - Bibliothèque en Ligne

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure database
4. Import database: `mysql -u root -p < bookshelf_database.sql`
5. Start server: `php -S localhost:8000 -t public`

## Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@bookshelf.com | admin123 |
| Bibliothecaire | biblio@bookshelf.com | biblio123 |
| User | user@bookshelf.com | user123 |

## Features Implemented

### Part 1 - Database & Entities
- 5 authors, 6 genres, 8 tags, 30 books
- Relationships: OneToMany (Auteur→Livre, Genre→Livre), ManyToMany (Livre↔Tag)
- Validation constraints (NotBlank, Length, Range, Isbn)

### Part 2 - CRUD & Templates
- Complete CRUD for Livre (Create, Read, Update, Delete)
- Simplified CRUD for Auteur, Genre, Tag
- Custom CSS design (no Bootstrap)
- Flash messages and CSRF protection

### Part 3 - Security & Authentication
- User registration and login/logout
- Role hierarchy (ROLE_USER, ROLE_BIBLIOTHECAIRE, ROLE_ADMIN)
- `#[IsGranted]` on controllers
- Conditional button display with `is_granted()`
- Users can only edit/delete their own books

### Part 4 - API Platform
- REST API for books with Swagger UI at `/api`
- Serialization groups (`livre:read`, `livre:write`)
- Pagination (10 items per page)

### Part 5 - Session & QueryBuilder
- Reading list stored in session (add/remove/clear)
- Search by title (partial match)
- Filter by genre, tag, and availability
- Pagination with filters preserved

### Part 6 - Email & Events
- Email notification when new book is added (Mailtrap ready)
- Email template `emails/nouveau_livre.html.twig`
- Event Subscriber adds `X-BookShelf-Version: 1.0` header

### Part 7 - File Upload
- Upload book cover images (JPEG, PNG, WEBP, max 2MB)
- Thumbnails in book list
- Full images in book detail
- Automatic deletion when book is deleted

### Part 8 - DataFixtures & Pagination
- 30 realistic books generated with FakerPHP
- Pagination: 10 books per page, 5 authors per page
- Sortable columns and page navigation

### Part 9 - Twig Extension & Console Command
- `time_ago` filter: "il y a 3 jours"
- `reading_time` filter: "2h30 de lecture"
- `book_status_badge` function: colored availability badge
- Console command: `php bin/console app:bookshelf:stats`
- Options: `--detail` (books by genre), `--format=json`

### Part 10 - Tests
- Unit tests for BibliothequeStats service
- Functional tests for LivreController
- API tests for `/api/livres` endpoints

## API Documentation

Swagger UI available at: `/api`

## Console Commands

```bash
# Display library statistics
php bin/console app:bookshelf:stats

# Show details (books by genre)
php bin/console app:bookshelf:stats --detail

# JSON output
php bin/console app:bookshelf:stats --format=json
Technologies

    Symfony 7.4

    Doctrine ORM

    MySQL

    API Platform

    Twig

    PHPUnit

    FakerPHP

    Custom CSS

Project Structure
Book_shelf/
├── src/
│   ├── Controller/      # All controllers (Livre, Auteur, Genre, Tag, User, Security, ReadingList)
│   ├── Entity/          # Database entities (Livre, Auteur, Genre, Tag, User)
│   ├── Service/         # FileUploader, EmailService, BibliothequeStats
│   ├── Twig/            # BookShelfExtension (time_ago, reading_time, book_status_badge)
│   ├── Command/         # BookShelfStatsCommand
│   └── DataFixtures/    # 30 books with Faker
├── templates/           # Twig templates
├── public/css/          # Custom styles
├── tests/               # Unit, functional, and API tests
└── config/              # Symfony configuration
Database

The database contains:

    30 books with realistic titles, summaries, ISBNs, and publication dates

    5 authors (Hugo, Dumas, Orwell, Rowling, Christie)

    6 genres (Roman, Science-Fiction, Policier, Fantasy, Biographie, Histoire)

    8 tags (Bestseller, Classique, Coup de cœur, Nouveau, Prix littéraire, Film adapté, Collection, Édition limitée)

    3 test users with different roles