#load ssh key
eval $(ssh-agent)
ssh-add ~/.ssh/bitbucket

#revert edits
git checkout .

#download update
git pull origin master

#install composer update/new packages
composer install

#compile frontend resources
yarn run prod

#set update file executable
chmod 777 update.sh

#run migrations
php artisan migrate

#clear app cache
php artisan cache:clear
php artisan permission:cache-reset
php artisan route:clear
#php artisan route:cache


