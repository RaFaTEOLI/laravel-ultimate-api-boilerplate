# rafateoli/backend



## Local Development

This project uses
[Laravel Sail](https://laravel.com/docs/sail) to manage
its local development stack. For more detailed usage instructions take a look at
the [official documentation](https://laravel.com/docs/sail).

### Links

-   **Your Application** http://localhost
-   **Preview Emails via Mailhog** http://localhost:8025
-   **MeiliSearch Administration Panel** http://localhost:7700
-   **API Endpoints** http://localhost/api
-   **API Documentation** http://localhost/api/documentation

### Start the development server

```shell
./vendor/bin/sail up
```

You can also use the `-d` option, to start the server in
the background if you do not care about the logs or still want to use your
terminal for other things.

### Build frontend assets

```shell
./vendor/bin/sail npm watch
```

### Run Tests

```shell
./vendor/bin/sail test
```
