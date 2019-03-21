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

Load the fixtures that create the predefined categories:
```
php bin/console doctrine:fixtures:load
```

### Start the development server
```
php bin/console server:run
```

## Application UML

![uml](https://raw.githubusercontent.com/GregRbs92/LeBonCoin/master/uml.png)

## cURL requests
#### Authentication

> The authentication is based on JWT

Create a new user:
```
curl -X POST http://localhost:8000/api/register -d '{"firstName": "John", "lastName": "Doe", "email": "tester@gmail.com", "password": "a"}' \
-H "Content-Type: application/json"
```

Get the connection token with the following command:
```
curl -X POST http://localhost:8000/api/login_check -d '{"username": "tester@gmail.com", "password": "a"}'
```
You will have a response of the form {token: ...}.
Copy the token and run:
```
TOKEN=<paste-your-token-here>
```
#### Ads Requests
Create a new job ad
```
curl -X POST http://localhost:8000/api/ads \
-d '{"title": "My new job", "content": "My description", "category": "job", "contractType": "CDI", "salary": 45000}' \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```

Create a new vehicle ad
```
curl -X POST http://localhost:8000/api/ads \
-d '{"title": "My new vehicle", "content": "My description", "category": "vehicle", "fuelType": "gas", "price": 35000}' \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```

Create a new property ad
```
curl -X POST http://localhost:8000/api/ads \
-d '{"title": "My new property", "content": "My description", "category": "property", "surface": 130, "price": 500000}' \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```

Create a new other ad
```
curl -X POST http://localhost:8000/api/ads \
-d '{"title": "My new ad", "content": "My description", "category": "anything"}' \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```

Get the ads
```
curl -X GET http://localhost:8000/api/ads \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```
