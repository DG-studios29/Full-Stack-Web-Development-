USE laravel;
GO

CREATE TABLE blog_posts (
id INT IDENTITY(1,1) PRIMARY KEY,
title TEXT,
content TEXT,
created DATE DEFAULT GETDATE()
);
GO

INSERT INTO blog_posts (title, content) VALUES ('Hello World', 'This is my first post!');
INSERT INTO blog_posts (title, content) VALUES ('Learning with Hyperion', 'I have started learning software engineering with Hyperion Development, and I must say it is an absolute blast!');
INSERT INTO blog_posts (title, content) VALUES ('Coding is tricky', 'Major setback today. Accidentally dropped a production database. Definitely making backups from now on.');
INSERT INTO blog_posts (title, content) VALUES ('The more you know', 'Today I learned that the term "cookie" (in web browsers) is originally from a Unix manual in 1979!');
GO

