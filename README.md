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

### Start the development server
```
php bin/console server:run
```

## cURL requests
#### Authentication
```
curl -X POST http://localhost:8000/api/login_check -d '{"username": "tester@gmail.com", "password": "a"}'
```
You will have a response of the form {token: ...}.
Copy the token and run:
```
TOKEN=<paste-your-token-here>
```
#### Ads Requests
Create a new ad
```
curl -X POST http://localhost:8000/api/ads \
-d '{"title": "My job", "content": "My description", "category": "job", "contractType": "CDI", "salary": 45000}' \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```

Get the ads
```
curl -X GET http://localhost:8000/api/ads \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```
