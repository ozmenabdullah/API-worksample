# API-worksample

Datasource created using mysql located in API folder as is named api.sql.

Login to admin interface using credentials:
username: oddhill
password: apisample

Create, edit, delete not enabled.

Additional ways to get data from API

Available uri queries:
List all authors: ?list=authors
List all books: ?list=books
List all genres: ?list=genres
List specific author by ID = ?list=authors&id=[ID]
List specific book by ID = ?list=books&id=[ID]
List specific genre by ID = ?list=genres&id=[ID]
List all authors for a specifik book = ?list=books&show=authors&id=[ID]
List all books for a specifik author = ?list=authors&show=books&id=[ID]
List all genres for a specifik book = ?list=books&show=genres&id=[ID]
