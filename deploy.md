#Deploy document MediaMarkt wedstrijd

get git project
> git clone https://github.com/TVke/competition.git

install laravel dependencies
>composer install

setup .env file
>php artisan key:generate

setup database
>php artisan migrate --seed
