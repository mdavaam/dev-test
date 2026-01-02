Overview
This project is a simple Product CRUD application built for the Antariks technical test.
It focuses on clean code, proper validation, basic security, and a pleasant user experience without unnecessary complexity.

Features
Full CRUD for products (Product, Amount, Qty)
Single-page product list with modal-based Create & Edit
Responsive and clean UI
Server-side validation and basic security practices

How to Run
- git clone https://github.com/mdavaam/dev-test.git
- cd dev-test
- composer install
- php artisan key:generate
- touch database/database.sqlite
- change DB_DATABASE to database/database.sqlite
- php artisan migrate
- php artisan serve

