### Yêu cầu

1. [Git](https://git-scm.com/downloads)
2. PHP >= 7.1.3
3. [Node LTS](https://nodejs.org/)
4. [Composer](https://getcomposer.org/)
5. [Yarn](https://yarnpkg.com/en/docs/install) 

### Cài đặt

#### Bước 1

1. Clone source từ gitlab, cài đặt thư viện.

```
git clone http://username:password@gitlab.cloudteam.vn/path/source.git
cd source
composer install --optimize-autoloader --no-dev
```

#### Bước 2

1. Tạo database DB_NAME.

1. Copy file .env từ env/.env.prod
```
cp env/.env.prod .env
```

1. Tạo app key
```
php artisan key:generate
```

1. Cập nhật database
```
DB_DATABASE=DB_NAME
DB_USERNAME=root
DB_PASSWORD=
```

1. Chạy lệnh migrate và seed database.
```
php artisan migrate:fresh --seed | yarn run mfs
```

## Optimization

```bash
php artisan config:cache
php artisan route:cache
```