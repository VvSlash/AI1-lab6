<?php
/** @var \App\Model\Book $book */
/** @var \App\Service\Router $router */

$title = htmlspecialchars($book->getTitle()) . " ({$book->getId()})";
$bodyClass = 'show';

ob_start(); ?>
    <h1><?= htmlspecialchars($book->getTitle()) ?></h1>
    <article>
        <p><strong>Author:</strong> <?= htmlspecialchars($book->getAuthor()) ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
        <p><strong>Publish Date:</strong> <?= htmlspecialchars($book->getPublishDate()) ?></p>
        <p><strong>Rating:</strong> <?= htmlspecialchars($book->getRating()) ?>/5</p>
        <?php if ($book && $book->getCoverImage()): ?>
            <img src="<?= $book->getCoverImage() ?>" alt="Cover Image" height="100px">
        <?php endif; ?>
    </article>
    <ul class="action-list">
        <li><a href="<?= $router->generatePath('book-index') ?>">Back to list</a></li>
        <li><a href="<?= $router->generatePath('book-edit', ['id' => $book->getId()]) ?>">Edit</a></li>
    </ul>
<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
