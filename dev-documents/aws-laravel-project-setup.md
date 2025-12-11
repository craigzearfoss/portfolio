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

cd demo.zearfoss.com
cp .env.example .env
# Update the .env to add database credential and other settings. 
# If this is production then remember to set APP_ENV=production

composer install

php artisan key:generate
php artisan migrate

composer install

composer global require laravel/pint
npm init -y
npm run build
npm install bulma
npm audit fix


```
