# Le Bon Coin

## Installation

### Prerequisite

You need to have **Docker** and **Docker Compose** installed on your machine.

### Install dependencies

This project use Composer, run:
```
composer install
```

### Launch the containers

This application is dockerized and the MySQL, Nginx and PHP containers are managed by **Docker Compose**.
In order to launch this application, you only need to go at the root of the project and run:
```
sudo docker-compose up --build
``` 

### Good to know

There are several things to know here that I have made to facilitate the deployment for the test:
* A script is executed in the MySQL container every time it is launched, erasing all the data in the database to fill it with fixtures. Thanks to this, you don't have to create the database, run the migrations and load the fixtures by yourself, but this script is not suitable in a real-life application.
* The front-end was made with Angular and I've compiled it in /public/assets. In a real-life application it would have been better to have a separate container running the Angular app, but it was easier to send you a single project. Therefore the separation between the API and the front-end is here managed by Nginx depending on the url with which we request the application.

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

Get an ad
```
curl -X GET http://localhost:8000/api/ads/1 \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```

Update an ad
```
curl -X PUT http://localhost:8000/api/ads/1 \
-d '{"title": "My updated ad", "content": "Updated description"}' \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```

Delete an ad
```
curl -X DELETE http://localhost:8000/api/ads/1 \
-H "Authorization: Bearer $TOKEN" -H "Content-Type: application/json"
```