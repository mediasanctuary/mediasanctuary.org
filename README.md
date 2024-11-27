# mediasanctuary.org

Website for The Sanctuary For Independent Media

## Basics

This is a WordPress site, the theme `mediasanctuary` and the plugins it depends on are managed here.

## Developer dependencies

* [node.js](https://nodejs.org/) v22
* [Docker Desktop](https://www.docker.com/products/docker-desktop)

## How to run locally

Start the Docker containers and the asset watcher:

```
./bin/start
```

Once it's running, load the website at [localhost:8080](http://localhost:8080/).

Exiting the `start` script (ctrl-C) stops the containers.

## Syncing content

Before you can sync content from `dev.mediasanctuary.org` to your local dev site, you will need to make sure your public SSH key is setup on the `devmediasan` account. Then you can use the following command:

```
./bin/sync
```

That script does the following:

1. Export the database
2. Replace URLs in the SQL file
3. Edit the SQL to remove all the WordPress user accounts and revision posts
4. Edit the SQL to a new WordPress account `dev` with password `dev`
5. Import that SQL file into your local database
6. rsync the uploads directory

After you finish, your local environment should look pretty much the same as dev.mediasanctuary.org, but you should login with username/password: `dev`/`dev`.

## Care and maintenance

Rebuild the container if necessary:

```
docker compose build
```

Tail the logs:

```
docker compose logs -f web
```

Login to a shell on the web server container:

```
docker compose exec web bash
```

## About the image

The `Dockerfile` uses the official `wordpress` image, which in turn is built off of `php`. The `web` container uses Debian-style package management. We don't modify it very much, just installing some tools like [WP-CLI](https://wp-cli.org/).

There won't be any database tables setup first time you run the container, but you can install the site by visiting [localhost:8080](http://localhost:8080/).

You can connect to the MySQL database on port 3307.

## Updating plugins

We use WP-CLI to keep the plugin files up-to-date, and commit the changes to source control. Note that updates to the [Advanced Custom Fields](https://www.advancedcustomfields.com/) plugin require that you [configure it](http://localhost:8080/wp-admin/edit.php?post_type=acf-field-group&page=acf-settings-updates) with a license key.

How to upgrade the plugins:

```
docker compose exec web wp plugin upgrade --all
```

## Updating WordPress core

To update your local WordPress dev instance:

```
docker compose exec web wp core upgrade
```

Updating WordPress on the dev or prod servers requires that you SSH in and run `wp core upgrade` on the server.

## Installing new plugins

Plugin files are stored in source control. The way to install a new one is to install it locally, commit the files, then update the servers.

```
docker compose exec web wp plugin install [new plugin]
```

## Continuous integration

We use [GitHub Actions](https://github.com/mediasanctuary/mediasanctuary.org/actions) to deploy updates to the servers.

* Commits to the `main` branch end up getting deployed to `https://dev.mediasanctuary.org/`
* Commits to the `production` branch end up getting deployed to `https://www.mediasanctuary.org/`
