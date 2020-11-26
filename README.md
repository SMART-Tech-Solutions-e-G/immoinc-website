# Immo Inc. Website

A web portal showcasing real estate from the Immo Inc. company.

## Installation

Prerequisites:

-   Docker
-   Docker Compose

### Production

```
docker-compose -f docker-compose.yml up -d --build
```

### Development

Includes phpMyAdmin web interface which can be accessed from: `http://localhost:8000/`
Credentials can be found inside the `docker-compose.yml` file under database › environment

```
docker-compose -f docker-compose.yml -f docker-development.yml up -d --build
```

After installation you can access the app from: `http://localhost:3000/`
