# CampusCal

CampusCal is a calendar management application specifically designed for students and academic institutions. It helps in
managing schedules, events, and tasks effectively.

## Table of Contents

- [About](#about)
- [Installation](#installation)
- [Usage](#usage)

## About

CampusCal provides a user-friendly interface for managing events regarding academic spaces.

## Installation

### Prerequisites

- PHP >= 8.2 and [these PHP extensions](https://laravel.com/docs/11.x/deployment#server-requirements)
- Composer
- Node.js & npm

### Steps

1. Clone the repository:
   ```sh
   git clone https://github.com/sarrietav-dev/campuscal.git
   cd campuscal
   ```
2. Install PHP dependencies:
   ```sh
    composer install
    ```
3. Install JavaScript dependencies:
    ```sh
     npm install
     ```
4. Create a `.env` file by copying the `.env.example` file:
    ```sh
    cp .env.example .env
    ```
5. Generate an application key:
    ```sh
    php artisan key:generate
    ```
6. Run the database migrations:
    ```sh
    php artisan migrate
    ```
7. Seed the database with the roles/permissions and audience data
    ```sh
    php artisan db:seed --class=RolesAndPermissionsSeeder
    php artisan db:seed --class=AudienceSeeder
    ```
## Usage

To start the application, run the following commands:

1. Compile the assets:
   ```sh
   npm run dev
   ```
2. Start the development server:
    ```sh
    php artisan serve
    ```

The application will be available at [http://localhost:8000](http://localhost:8000).

### Testing

To run the tests, execute the following command:

```sh
php artisan test
```

### Seeding

To seed the database with dummy data, run the following command:

```sh
php artisan db:seed
```
