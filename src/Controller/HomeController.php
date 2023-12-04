<?php
namespace App\Controller;

use App\Model\Post;
use App\Model\Book;
use App\Service\Router;
use App\Service\Templating;

class HomeController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $posts = Post::findAll();
        $books = Book::findAll();

        $html = $templating->render('home/index.html.php', [
            'posts' => $posts,
            'books' => $books,
            'router' => $router,
        ]);

        return $html;
    }
}
