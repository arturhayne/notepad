# About
An online notepad using DDD, Hexagonal Arch., CQRS, Doctrine, PDO
- Laravel 5.6

# Requirements
- php 5.6 ou higher [tutorial](http://tecadmin.net/install-php5-on-ubuntu/)
- composer [tutorial](https://getcomposer.org/doc/00-intro.md#globally)
- database: [postgres](https://www.postgresql.org/download/) or [MySQL](https://www.mysql.com/downloads/)

## Development
- cp .env.example .env
- composer install
- php artisan key:generate

## Database
It is necessary to especify the projection database in .env (pgsql_projection or mysql_projection) or for another type in config\database.php. Projection connection is made with PDO.
After all configuration:
- php artisan migrate

## Projections Command
Scheduling the projection command (ProjectNotepadCommand) with crontab
- #crotab -e
 ```
 * * * * * cd /[project-path-change-me-please]/notepad/ && php artisan schedule:run >> /dev/null 2>&1
 ```

The command output will be in .eventsOutput in project folder

## Run
- php artisan serve --port=5000

## Services:

- Create user
```
POST http://localhost:8000/api/users/create 
```

payload: {"name":"name","email":"teste@teste.com"}

Answer:
{
    "id": "77d6ddad-0f6b-4378-9e03-03d4e36f181a"
}

- Create Notepad
```
POST http://localhost:8000/api/notepad/create
```

payload: {"name":"notepad name", "userId":"77d6ddad-0f6b-4378-9e03-03d4e36f181a"}

Answer:
{
    "id": "2a21ae57-6115-4ed4-8df2-2404187b4dab"
}

- Create Note

```
POST http://localhost:8000/api/notes/create
```

payload: {"title":"title name", "content":"content", "notepadId":"2a21ae57-6115-4ed4-8df2-2404187b4dab"}

Answer:
{
    "id": "0b5ac7f3-2991-4463-b5d7-80ef3c49caa1"
}

- Amount of notes per user

```
GET http://localhost:8000/api/user/qtNotes/b5724410-4caa-4607-aaa4-f81b58e0513c
```

Answer:
{
    "qtd": 3
}

- Notes from User

```
GET http://localhost:8000/api/user/notesFromUser/b5724410-4caa-4607-aaa4-f81b58e0513c
```

Answer:
[
    {
        "id": 4,
        "user_id": "b5724410-4caa-4607-aaa4-f81b58e0513c",
        "note_id": "42c3835e-b8c1-4d7c-aea7-d8eda16f5e1c",
        "notepad_id": "17cba867-fcb4-484d-9898-dbb3e10475b2",
        "title": "título2",
        "content": "testing creating note"
    },
    {
        "id": 5,
        "user_id": "b5724410-4caa-4607-aaa4-f81b58e0513c",
        "note_id": "51dec6b7-ec4e-482b-98c0-5543c6568459",
        "notepad_id": "17cba867-fcb4-484d-9898-dbb3e10475b2",
        "title": "título2",
        "content": "testing creating note"
    },
    {
        "id": 6,
        "user_id": "b5724410-4caa-4607-aaa4-f81b58e0513c",
        "note_id": "b04fe7ec-9b8f-42ca-a2d3-4ec91fd049ad",
        "notepad_id": "17cba867-fcb4-484d-9898-dbb3e10475b2",
        "title": "título2",
        "content": "testing creating note"
    }
]