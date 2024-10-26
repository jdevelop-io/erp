# Docker

This directory contains the necessary files to build the Docker images for the project.

## Building the Docker images

To build the Docker images, run the following command:

```bash
docker compose -f compose.dev.yaml -f compose.override.yaml build
```

## Running the Docker containers

To run composer commands, run the following command:

```bash
docker compose -f compose.dev.yaml -f compose.override.yaml run --rm composer
```

To run tests, run the following command:

```bash
docker compose -f compose.dev.yaml -f compose.override.yaml run --rm tests
```

To run phpcs, run the following command:

```bash
docker compose -f compose.dev.yaml -f compose.override.yaml run --rm phpcs
```

To run phpstan, run the following command:

```bash
docker compose -f compose.dev.yaml -f compose.override.yaml run --rm phpstan
```

To run phpmd, run the following command:

```bash
docker compose -f compose.dev.yaml -f compose.override.yaml run --rm phpmd
```
