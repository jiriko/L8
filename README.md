
## Installation

- cp env.example to .env
- update .env
- composer install
- php artisan key:generate
- php artisan migrate
- yarn install
- yarn dev or yarn prod
- php artisan serve 


## Running Tests

- update phpunit.xml if not using :memory: as DB_CONNECTION
- php artisan test --group=tasks
- php artisan test --group=numbers
