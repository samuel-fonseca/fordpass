# FordPass Access

This is a simple Lumen web app to send basic commands and fetch the current status to your Ford vehicle with Sync 3 enabled.

## Local development

To get started you need to be familiar with [Lumen micro-framework](https://lumen.laravel.com/docs/9.x). Once the repo has been cloned, make sure to install all depedencies.

```terminal
$ composer install
```

Once installed create a `database.sqlite` file:

```terminal
$ touch database/database.sqlite
```

Finally run the migrations:

```terminal
$ php artisan migrate
```

Finally you can serve the app locally using PHP.

```terminal
$ php -S localhost:8000 -t public
```

### Supported Actions & Vehicle Information

Currently these are the supported actions:

- `start`
- `stop`
- `lock`
- `unlock`

Vehicle information actions:

- `status`
- `details`
- `capabilities`

### Endpoints

To access these actions/vehicle info via your browser you can visit:

`GET /api/vehicle/{vin}/{command}`

The endpoint will return a `json` response of your request.

### Console

The commands can also be invoked through the Artisan console:

```terminal
$ php artisan vehicle:control {command}
```

You may also get the status of your car.

```terminal
$ php artisan vehicle:status {--fresh}
```

## Deployment

In case you'd like to have this up in the cloud, to keep this simple, I have chosen to deploy to AWS Lambda. Before launching read the documentation on how to use [Bref](https://bref.sh/) and [serverless](https://www.serverless.com/).

Follow the instructions on bref's getting started tutorial to launch to your own instance of AWS Lambda. Once you have gotten all of your setup ready to be deployed you can use an internal artisan command to deploy:

```terminal
$ php artisan deploy
```

The deploy command will run a production composer install and deploy to AWS with `serverless deploy`. The application updates Lumen's config for database, cache, session, and logging when launched.
