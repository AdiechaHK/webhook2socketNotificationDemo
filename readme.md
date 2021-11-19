# Demo

### Laravel server

We need to start laravel app just for frontend

go to `laravel` folder and run the command

```bash
cp .env.example .env
composer install
php artisan serve
```


### Node app

Here the node app will do all the work.

go to `socket_app` folder

and run the following commands

```bash
npm install
node main.js
```

This will start node web server as well as socket server.


### Test the app

__Here considered that both laravel and node server are up and running__

* Step#1: Open laravel home page `http://localhost:8000`
* Step#2: Consider this laravel app is a client page. keep console open for observation
* Step#3: Entery project ID and connect to the project.
* Step#4: Now we will call a URL (webhook) to get data there. 

```bash
curl --location --request POST 'http://localhost:3000/notify/aaa' \
--header 'Content-Type: application/json' \
--data-raw '{"deviceId":12, "url":"https://www.youtube.com/watch?v=PGwXZqviGyg"}'
```