
sudo mkdir -p storage/app
sudo mkdir -p storage/framework/cache/data
sudo mkdir -p storage/logs
sudo mkdir -p storage/media-library
sudo mkdir -p storage/media
sudo mkdir -p storage/temp-uploads
sudo mkdir -p storage/uploads

sudo mkdir -p public

sudo chmod -R 777 storage/
sudo chmod -R 777 public/

#install composer update/new packages
composer install

#compile frontend resources
yarn run prod

#set update file executable
chmod 777 update.sh

#clear app cache
php artisan permission:cache-reset
php artisan route:clear
