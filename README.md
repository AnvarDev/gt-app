## Deploy Instructions

To run the application download [Docker](https://www.docker.com). For the locally deploy was used the version **26.0.2** and all the configuration is already done and is in the **docker-compose.yml**. To deploy the application, clone the repository and in the directory **gt-app** run the command:

```
docker compose up
```

After running the command above Docker will install all necessary packages and after installation and startup, you will see the message in the console: on a green background:

`Application starts with the environment: local`

**Note: If you can't deploy it locally, then it's possible to check it out online here:**

http://gt-app-3312f3761c9e.herokuapp.com


## API documentation

API documentation generated in Postman. It contains Environment (Heroku), tutorials, code and responses examples. Import all collections to your Postman and run the requests in a specified order to test the functionality of API.

https://documenter.getpostman.com/view/8520996/2sA3BrZAWG


## Tests
The system automatically creates a user for manually tests, there's the credentials:

```
login: user@global-tickets.com
password: 1234567a
```

To test all requests/endpoints with different scenarios, you should at first get into the container by the command:

```
docker exec -it app-service bash
```

In the container copy/paste the phpunit run:
```
./vendor/bin/phpunit
```
