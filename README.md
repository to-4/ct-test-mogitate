# 確認テスト\_もぎたて

## 環境構築

### Docker ビルド

1. git clone git@github.com:to-4/ct-test-mogitate.git
2. cd ct-test-mogitate
3. Windows(wsl) の場合は、下記を実行
   ```
   printf "UID=%s\n" "$(id -u)" > .env
   ```
   > _※ Mac の場合は省略可_
4. DockerDesktop アプリを立ち上げる
5. docker compose up -d --build

### Laravel 環境構築

1.  docker compose exec php bash
2.  composer install
3.  「.env.example」ファイルをコピーして「.env」ファイルを作成
4.  「.env」ファイルに対して、以下の環境変数を変更
    ```
    DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    + DB_HOST=mysql
    DB_PORT=3306
    - DB_DATABASE=laravel
    - DB_USERNAME=root
    - DB_PASSWORD=
    + DB_DATABASE=laravel_db
    + DB_USERNAME=laravel_user
    + DB_PASSWORD=laravel_pass
    ```
    > _※ 上記の "-" は削除行、"+"は追加行を表します_
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
