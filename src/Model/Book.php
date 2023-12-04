<?php
namespace App\Model;

use App\Service\Config;

class Book
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $author = null;
    private ?string $publishDate = null;
    private ?int $rating = null;
    private ?string $coverImage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Book
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Book
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Book
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): Book
    {
        $this->author = $author;

        return $this;
    }

    public function getPublishDate(): ?string
    {
        return $this->publishDate;
    }

    public function setPublishDate(?string $publishDate): Book
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): Book
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): Book
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public static function fromArray($array): Book
    {
        $book = new self();
        $book->fill($array);

        return $book;
    }

    public function fill($array): Book
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }
        if (isset($array['description'])) {
            $this->setDescription($array['description']);
        }
        if (isset($array['author'])) {
            $this->setAuthor($array['author']);
        }
        if (isset($array['publishDate'])) {
            $this->setPublishDate($array['publishDate']);
        }
        if (isset($array['rating'])) {
            $this->setRating($array['rating']);
        }
        if (isset($array['coverImage'])) {
            $this->setCoverImage($array['coverImage']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM book';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $books = [];
        $booksArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($booksArray as $bookArray) {
            $books[] = self::fromArray($bookArray);
        }

        return $books;
    }

    public static function find($id): ?Book
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM book WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $bookArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$bookArray) {
            return null;
        }
        $book = Book::fromArray($bookArray);

        return $book;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (!$this->getId()) {
            $sql = "INSERT INTO book (title, description, author, publishDate, rating, coverImage) VALUES (:title, :description, :author, :publishDate, :rating, :coverImage)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'author' => $this->getAuthor(),
                'publishDate' => $this->getPublishDate(),
                'rating' => $this->getRating(),
                'coverImage' => $this->getCoverImage(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE book SET title = :title, description = :description, author = :author, publishDate = :publishDate, rating = :rating, coverImage = :coverImage WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':title' => $this->getTitle(),
                ':description' => $this->getDescription(),
                ':author' => $this->getAuthor(),
                ':publishDate' => $this->getPublishDate(),
                ':rating' => $this->getRating(),
                ':coverImage' => $this->getCoverImage(),
                ':id' => $this->getId(),
            ]);
        }
        // Przetwarzanie przesłanego pliku obrazu
        if (isset($_FILES['book']['name']['coverImage']) && $_FILES['book']['error']['coverImage'] == 0) {
            $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR ."img". DIRECTORY_SEPARATOR; // Ustaw ścieżkę do katalogu przechowywania obrazów
            $fileName = basename($_FILES['book']['name']['coverImage']);
            $targetFilePath = $uploadDir . $fileName;

            // Przenieś przesłany plik do katalogu docelowego
            if (move_uploaded_file($_FILES['book']['tmp_name']['coverImage'], $targetFilePath)) {
                // Jeśli plik został przeniesiony, zapisz ścieżkę do pliku w właściwości coverImage
                $this->setCoverImage($targetFilePath);
            }
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM book WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setTitle(null);
        $this->setDescription(null);
        $this->setAuthor(null);
        $this->setPublishDate(null);
        $this->setRating(null);
        $this->setCoverImage(null);
    }
}
