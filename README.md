# アプリケーション名

contact-form

## 環境構築

Dockerビルド
・git clone git@github.com:yuki-nakagawa-1021/contact-form.git
・docker-compose up -d --build

### Laravel環境構築

・docker-compose exec php bush
・composer install
・cp .env.example.env
・php artisan key:generate
・php artisan migrate
・php artisan db:seed

## 開発環境

・お問い合わせ画面：http://localhost/
・ユーザー登録：http://localhost/register
・phpMyAdmin：http://localhost:8080/

##　使用技術（実行環境）
・PHP 8.2.30
・Laravel 8.83.29
・mysql 8.0.26
・nginx 1.21.1

##　ER図

##　URL
開発環境：http://localhost/
