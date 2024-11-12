# Database
The project uses [SQLite](https://www.sqlite.org/). There are two databases:
- `/database/database.sqlite`: main production database
- `/database/database.testing.sqlite`: database for testing

## Models
- [`/app/Models/Tag`](/app/Models/Tag): can have only one user. Table: `tags`
- [`/app/Models/User`](/app/Models/User): can have many tags. Table: `users`
