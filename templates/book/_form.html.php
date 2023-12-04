<?php
/** @var $book ?\App\Model\Book */
?>
<div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="book[title]" value="<?= $book ? $book->getTitle() : '' ?>">
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="book[description]"><?= $book ? $book->getDescription() : '' ?></textarea>
</div>
<div class="form-group">
    <label for="author">Author</label>
    <input type="text" id="author" name="book[author]" value="<?= $book ? $book->getAuthor() : '' ?>">
</div>
<div class="form-group">
    <label for="publishDate">Publish Date</label>
    <input type="date" id="publishDate" name="book[publishDate]" value="<?= $book ? $book->getPublishDate() : '' ?>">
</div>
<div class="form-group">
    <label for="rating">Rating</label>
    <input type="number" id="rating" name="book[rating]" value="<?= $book ? $book->getRating() : '' ?>" min="1" max="5">
</div>
<div class="form-group">
    <label for="coverImage">Cover Image</label>
    <input type="file" id="coverImage" name="book[coverImage]">
    <?php if ($book && $book->getCoverImage()): ?>
        <img src="<?= htmlspecialchars($book->getCoverImage()) ?>" alt="Cover Image" height="100px">
    <?php endif; ?>
</div>
<div class="form-group">
    <label></label>
    <input type="submit" value="Submit">
</div>
