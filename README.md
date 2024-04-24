## Deploy Instructions

To run the application download [Docker](https://www.docker.com). For the locally deploy was used version 26.0.2 and all the configuration is already done and is in the **docker-compose.yml**. To deploy the application, clone the repository and in the directory **gt-app** run the command:

```
docker compose up
```

After running the command above Docker will install all necessary packages and after installation and startup, you will see the message in the console: on a green background:

`Application starts with the environment: local`

## Tests
To test manually, you can use an already automatically created user:

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
