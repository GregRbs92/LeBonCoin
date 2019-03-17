# Le Bon Coin

## Installation

### Configure the database
Create a `.env.local` file and set the appropriate URL
to your MySQL database as follow:
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```

Create the database and the appropriate schema by
running the following commands in the project's root:
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
