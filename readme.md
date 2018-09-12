# About
An online notepad
- Laravel 5.6

# Requirements
- php 5.6 ou higher [tutorial](http://tecadmin.net/install-php5-on-ubuntu/)
- composer [tutorial](https://getcomposer.org/doc/00-intro.md#globally)
- postgres

## Development
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate

## Run
- php artisan serve --port=5000

## Services:

- Create a note with title
```
POST /api/notes/create 
```

payload: {"title":"titulo","content":"conteudo"}

Answer:

1 (id)

- Delete a note
```
DELETE /api/notes/delete/8
```

"Note Deleted"

- List notes
```
GET /api/notes/list
```

[
    {
        "id": 1,
        "title": "titulo",
        "content": "conteudo"
    }
]


