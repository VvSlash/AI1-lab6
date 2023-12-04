<?php
/** @var \App\Model\Post[] $posts */
/** @var \App\Model\Book[] $books */
/** @var \App\Service\Router $router */

$title = 'Home';
$bodyClass = 'home';

ob_start(); ?>
    <h1>Welcome to Custom Framework</h1>

    <section class="column">
        <h1>Posts</h1>
        <a href="<?= $router->generatePath('post-create') ?>">Create new Post</a>
        <ul class="index-list">
            <?php foreach ($posts as $post): ?>
                <li>
                    <h3><?= htmlspecialchars($post->getSubject()) ?></h3>
                    <ul class="action-list">
                        <li><a href="<?= $router->generatePath('post-show', ['id' => $post->getId()]) ?>">Details</a></li>
                        <li><a href="<?= $router->generatePath('post-edit', ['id' => $post->getId()]) ?>">Edit</a></li>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="column">
        <h1>Books</h1>
        <a href="<?= $router->generatePath('book-create') ?>">Create new Book</a>
        <ul class="index-list">
            <?php foreach ($books as $book): ?>
                <li>
                    <h3><?= htmlspecialchars($book->getTitle()) ?></h3>
                    <ul class="action-list">
                        <li><a href="<?= $router->generatePath('book-show', ['id' => $book->getId()]) ?>">Details</a></li>
                        <li><a href="<?= $router->generatePath('book-edit', ['id' => $book->getId()]) ?>">Edit</a></li>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php $main = ob_get_clean();
include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';
