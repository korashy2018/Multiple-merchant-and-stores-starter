## About the app

Multi-vendor ecommerce app with multiple guards admins , merchants and customers that uses JWT tokens for authentication
and authorization.
Each Merchant can have multiple stores with products for each ; the customer can place order from multiple merchants and
multiple stores of that merchant.

steps to install

    composer install

    cp .env.example .env

    php artisan key:generate 
    
    php artisan jwt:secret

    php artisan migrate

    
