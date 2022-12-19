git clone https://github.com/hilcrhymer78787/todo.git



【フロントエンド】

cd todo/vue

cp .env.example .env

npm install

npm run serve



【バックエンド】

cd todo

docker-compose up -d --build

docker-compose exec app bash

cp .env.example .env

composer install

php artisan key:generate

php artisan migrate:refresh --seed



【ローカル環境APIのURL】
http://localhost:8001