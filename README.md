### Change Laradock .env
PHP_VERSION=8.0

APP_CODE_PATH_HOST=../project_folder

### Create the .env file in the project's folder
```
cp .env.example .env
```

### Start Docker
```
docker-compose up -d  nginx mysql redis workspace
```

### Backend
```
docker exec -ti laradock_workspace_1 bash
composer install
```

### Frontend (optional). Execute it on your local machine
```
yarn install
yarn prod
```

### Before execute "php artisan" commands go into the BE container
```
docker exec -ti laradock_workspace_1 bash
```

### Generate app key
```
php artisan key:generate
```

### Seeding + Migrations

```
php artisan migrate:fresh --seed
```
Only the first item in the list has images

### Tests
```
php artisan test
```

### Code quality
```
./vendor/bin/phpcs
./vendor/bin/phpstan analyse --memory-limit=2G

yarn lint
```

#### Visit the /api/documentation page to open the Swagger API manager.
