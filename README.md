# laravel-docker-template

# 確認テスト\_お問い合わせフォーム

## 環境構築

### Docker ビルド

1. git clone git@github.com:to-4/ct-test-contact-form.git
2. cd ct-test-contact-form
3. printf "UID=%s\nGID=%s\n" "$(id -u)" "$(id -g)" > .env
4. DockerDesktop アプリを立ち上げる
5. docker compose up -d --build

### Laravel 環境構築

1.  docker compose exec php bash
2.  composer install
3.  「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.env ファイルを作成
4.  「.env」に以下の環境変数を変更
    ```
    DB_HOST=mysql
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    DB_PASSWORD=laravel_pass
    ```
5.  アプリケーションキーの作成
    ```
    php artisan key:generate
    ```
6.  マイグレーションの実行
    ```
    php artisan migrate
    ```
7.  シーディングの実行
    ```
    php artisan db:seed
    ```

## 使用技術

- PHP 8.3
- Laravel 8.8
- MySQL 8.4

## ER 図

![ER図](./images/ER-core_v1.svg)

## URL

- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
