create table post
(
    id      integer not null
        constraint post_pk
            primary key autoincrement,
    subject text not null,
    content text not null
);
CREATE TABLE book (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT,
    author TEXT NOT NULL,
    publishDate DATE,
    rating INTEGER CHECK(rating >= 1 AND rating <= 5),
    coverImage TEXT
);
