# FordPass Access

This is a simple Lumen web app to send basic commands and fetch the current status to your Ford vehicle with Sync 3.

## Local development

To get started you need to be familiar with [Lumen micro-framework](https://lumen.laravel.com/docs/9.x). Once the repo has been cloned, make sure to install all depedencies.

```terminal
$ php -S localhost:8000 -t public
```

### Supported Actions

Currently these are the supported actions:

- `start`
- `stop`
- `lock`
- `unlock`
- `status`

### Endpoints

To access these actions via your browser you can visit:

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

Follow the instructions on bref's getting started tutorial to launch to your own instance of AWS Lambda.

The application updates Lumen's config for database, cache, session, and logging when launched.
