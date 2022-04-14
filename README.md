# Laravel: News Application

## Project Specifications

**Read-Only Files**
- tests/*

**Environment**  

- PHP version: 7.4
- Laravel version: 
- Default Port: 8000

**Commands**
- run: 
```bash
yes | php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000
```
- install: 
```bash
composer install
```
- test: 
```bash
yes | php artisan migrate:refresh && ./vendor/bin/phpunit tests --log-junit junit.xml
```
    
## Question description

In this challenge, your task is to implement a simple REST API to manage a collection of news articles.

Each article has the following structure:

- `id`: The unique ID of the article. (Integer)
- `title`: The title of the article. (String)
- `content`: The content of the article. (String)
- `author`: Name of the author of the article. (String)
- `category`: The category of the article. (String)
- `published_at`: The publishing date of the article. (Date)

### Example of an article JSON object:
```
{
    "id": 1,
    "title": "New photography exhibition",
    "content": "In a new exhibition at the Royal Botanic Garden Edinburgh, famous photographer explores the astonishing diversity of nature.",
    "author": "Oscar Davies",
    "category": "Nature",
    "published_at": "2020-02-10"
}
```

## Requirements:

You are provided with the implementation of the Article model. The REST service must expose the `/articles` endpoint, which allows for managing the collection of articles in the following way:

`POST /articles`:

- Validates the following conditions:
    - title is provided
    - length of title is less than 30 characters long
    - content is provided
    - author is provided
    - category is provided
    - published_at is provided
- If any of the above requirements fail, the server should return the response code 400. Otherwise, in the case of a successful request, the server should return the response code 201 and the article information in JSON format.
- expects a JSON article object without an id property as a body payload.
- adds the given article object to the collection of articles and assigns a unique integer id to it. The first created article must have id 1, the second one 2, and so on.
- the response code is 201, and the response body is the created article object.

`GET /articles`:

- returns JSON of a collection of all articles, ordered by id in increasing order
- returns response code 200

`GET /articles/<id>`:

- returns an article with the given id
- if the matching article exists, the response code is 200 and the response body is the matching article object
- if there is no article with the given id in the collection, the response code is 404

`PUT request to /articles/:id`:

-   Update a particular article object which has the given id
-   expects a JSON object of article events for a successful 200 response
-   if there is no article with the given id in the collection, the response code is 404

`DELETE request to /articles/:id`:

-   Delete a particular article object which has the given id
-   expects successful 200 response message
-   if there is no article with the given id in the collection, the response code is 404
