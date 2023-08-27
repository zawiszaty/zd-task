# How to run
1. ```cp .env.example .env```
2. ``docker-compose up -d``
3. ``docker-compose exec -T laravel.test composer install``
4. ``docker-compose exec -T laravel.test sh  wait-for-mysql-then-run.sh``
5. ``docker-compose exec laravel.test php artisan test``
6. Api is available on ``http://localhost/api``
7. Queue workers automatically start in ``laravel.worker`` container, check logs ``docker-compose logs -f laravel.woker``
