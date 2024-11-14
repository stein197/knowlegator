# Database
The project uses [SQLite](https://www.sqlite.org/). There are two databases:
- `/database/database.sqlite`: main production database
- `/database/database.testing.sqlite`: database for testing

## Models
- [`/app/Models/EType`](/app/Models/EType.php): entity type. Table: `etypes`
- [`/app/Models/Tag`](/app/Models/Tag.php): can have only one user. Table: `tags`
- [`/app/Models/User`](/app/Models/User.php): can have many tags. Table: `users`
