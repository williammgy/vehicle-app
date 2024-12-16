# Arengi

## Project

This full website application contains 150 vehicles with the following fields:

- id (uuid)
- label
- brand
- seats_amount
- color (optional)
- type (relation)

A type is only defined by an automatically incremented numeric ID and a label.

It is possible to:

- list all vehicles:
  - filters: brand, type and seats amount
- create a vehicle
- update a vehicle
- delete a vehicle

The GVWR (Gross Vehicle Weight Rating) is required if the vehicle is a utility type.

## Environment

- PHP8.2
- Symfony 6.4
- MySQL8 (CLI only)
- Apache
- Composer
- Docker

## Architecture

- MVC

## Setup

At the root of the project:

1. Create the `.env` file based on the `.env.example` model
2. Run the project with the `docker-compose up --build -d` command
3. Connect to the 'app' container by running `docker exec -it app bash`
4. Launch the `composer install` command to install dependencies
5. Do `bin/init-db` to set the migration and load fixtures

URL: `http://localhost:8080`

## Users

|Email|Password|Role|
|:-------:|:-------:|:-----:|
|`admin@arengi.com`|`arengi`|`ROLE_ADMIN`

## Commands

- Connect to the 'app' container:
  
```docker exec -it app bash```

- Connect to the 'db' container:

```docker exec -it db mysql -u user -p```

- Clean the database and restore the fixtures:

```bin/init-db```

## Bundles / Dependencies

- The regular Symfony bundles