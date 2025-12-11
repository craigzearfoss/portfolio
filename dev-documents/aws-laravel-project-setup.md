## AWS Laravel Project Setup
- [ ] Clone the repository.
```
@ Create the databases
mysql -u craigzearfoss -
CREATE DATABASE `test_system`;
CREATE DATABASE `test_dictionary`;
CREATE DATABASE `test_portfolio`;
CREATE DATABASE `test_career`;
CREATE DATABASE `test_personal`;

cd /var/www
sudo git clone https://github.com/craigzearfoss/portfolio.git zearfoss.com

sudo chown -R $USER:www-data /var/www/zearfoss.com
sudo find /var/www/zearfoss.com -type d -exec chmod 755 {} \;
sudo find /var/www/zearfoss.com -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/zearfoss.com/storage
sudo chmod -R 775 /var/www/zearfoss.com/bootstrap/cache
sudo chmod -R 775 /var/www/zearfoss.com/logs
chmod +x /var/www/zearfoss.com/tools/update_project.sh

# Create the .env file and update settings for the site.
cd zearfoss.com
cp .env.example .env
# Update the .env to add database credentials and other settings. 
# If this is production then remember to set APP_ENV=production

# Run composer install.
composer install

# Generate an application key.
php artisan key:generate

# Create and populate the project databases.
php artisan migrate

composer install

# If you run into a problem with dependencies you can't resolve you might
# need to run the following command.
composer install --ignore-platform-req=php

composer global require laravel/pint
sudo npm init -y
sudo npm run build
npm install bulma
npm audit fix


```
