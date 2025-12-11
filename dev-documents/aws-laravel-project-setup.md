## AWS Laravel Project Setup
- [ ] Clone the repository.
```
@ Create the databases
mysql -u craigzearfoss -
CREATE DATABASE `system`;
CREATE DATABASE `dictionary`;
CREATE DATABASE `portfolio`;
CREATE DATABASE `career`;
CREATE DATABASE `personal`;

cd /var/www
sudo git clone https://github.com/craigzearfoss/portfolio.git zearfoss.com

sudo chown -R $USER:www-data /var/www/zearfoss.com
sudo find /var/www/zearfoss.com -type d -exec chmod 755 {} \;
sudo find /var/www/zearfoss.com -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/zearfoss.com/storage
sudo chmod -R 775 /var/www/zearfoss.com/bootstrap/cache

composer update

php artisan key:generate



```
