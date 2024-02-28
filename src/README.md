# Atte
勤怠管理システム

![スクリーンショット 2024-02-28 18 59 33](https://github.com/Guttyan/attendance-system/assets/141023258/00757a4c-19af-497a-b343-af2235a219a2)

## 作成した目的
勤怠管理アプリを作成し、自己のLaravelの技能を磨くため。

## アプリケーションURL
http://18.181.191.125/

## 機能一覧
ユーザー新規登録  
新規登録時メール確認機能  
ログイン、ログアウト  
出勤、退勤、休憩時間の記録  
日付切り替え時、出勤中ユーザー出退勤処理  
日付別勤怠一覧表示  
ユーザー別勤怠一覧表示  

## 使用技術（実行環境）
Laravel Framework 8.83.27  
PHP 8.3.0  
MySQL 8.0.26  
MailHog  

## テーブル設計
![スクリーンショット 2024-02-28 19 21 40](https://github.com/Guttyan/attendance-system/assets/141023258/289e6fa6-3a25-4146-973b-95033fba7054)

## ER図
![index drawio](https://github.com/Guttyan/attendance-system/assets/141023258/033bf51c-8320-4be8-87ee-e3c488c8338c)

# 環境構築
Dockerビルド  
git clone https://github.com/Guttyan/attendance-system.git  
cd attendance-system  
docker-compose up -d --build  

Laravel環境構築  
docker-compose exec php bash  
composer install  
cp .env.examlple .env　環境変数を変更  
Mailhog環境変数  
MAIL_HOST=mail  
MAIL_FROM_ADDRESS=your-email@example.com  
MAIL_FROM_NAME="${APP_NAME}"を変更  
php artisan key:generate  
php artisan migrate  
php artisan db:seed  
composer require swiftmailer/swiftmailer  

スケジュールの設定  
apt-get update  
apt-get install nano  
sudo apt-get install cron  
crontab -e  
59 23 * * * PATH=/usr/local/bin/php:/usr/bin:/bin /usr/local/bin/php /var/www/artisan attendance:process >> /var/www/storage/logs/laravel.log 2>&1　を記述  
service cron start  
sudo dpkg-reconfigure tzdata　対話方式に従ってAsia/Tokyoに設定  