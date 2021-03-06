# mediasanctuary.org

Website for The Sanctuary For Independent Media

## Basics

This repository is designed to be checked out in the `wp-content` directory. The site themes and plugins are managed here.

## Developer dependencies

* [node.js](https://nodejs.org/) v14
* [Docker Desktop](https://www.docker.com/products/docker-desktop)

## How to run locally

Start the Docker containers:

```
./bin/start
```

## Continuous depoyment

Commits to the `main` branch end up getting deployed to `https://dev.mediasanctuary.org/` using GitHub Actions.
