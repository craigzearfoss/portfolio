## AWS Ubuntu Server Setup
- [ ] Prepare your machine instance.
    - From the EC2 dashboard select your EC2 instance click on the "Connect" button at the top of the page.
    - Make sure the "EC2 Instance Connect" tab is selectec and click on the orange "Connect" button at the bottom of the page.
- Run the following commands.
#### Install node
    ```
    $ sudo apt update
    $ sudo apt upgrade
    $ sudo apt install nodejs -y
    $ sudo apt install npm -y
    $ sudo npm install --global yarn
    $ sudo npm i ts-node --g
    $ sudo npm cache clean -f
    $ sudo npm install -g n
    $ sudo n stable

	composer global require laravel/pint
npm init -y
npm create vite@latest
npm run build
npm install bulma


#### Install git.
    $ sudo apt install git
    $ git --version
    $ git config --global user.name "Craig Zearfoss"
    $ git config --global user.email "craigzearfoss@gmail.com"
#### Install miscellaneous tools
    $ sudo apt update
    $ sudo apt install net-tools
    $ sudo apt install whois
    ```
  
#### Install Docker (only if you are using Docker for NGINX or for your app).
    ```
    $ sudo snap install docker
    $ sudo docker version
    ```
  
#### Install Nginx.
    $ sudo apt update
    $ sudo apt install nginx
    $ sudo systemctl status nginx

#### Install MySQL.
    $ sudo apt update
    $ sudo apt install mysql-server
    $ sudo mysql_secure_installation
    $ sudo mysql
    mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'Password.1';
    mysql> CREATE DATABASE test_db;
    mysql> CREATE USER 'testuser'@'localhost' IDENTIFIED BY 'Password.1';
    mysql> GRANT ALL PRIVILEGES ON test_db.* TO 'testuser'@'localhost';
    mysql> FLUSH PRIVILEGES;
    EXIT;  
    ```
#### Install PHP
    $ sudo apt update
    $ sudo apt install php-fpm php-mysql
    $ sudo nano /var/www/info.php
    > ?php
    > phpinfo();
    > ?>
    > remove /var/www/info.php
    > sudo apt install software-properties-common
    > sudo add-apt-repository ppa:ondrej/php
    > sudo apt update
    > sudo apt install php8.5
    > sudo apt install php8.5-cli php8.5-mysql php8.5-curl php8.5-gd php8.5-mbstring php8.5-xml php8.5-fpm -y
    > sudo apt install php-cli unzip -y
    > apt list --upgradable
    > sudo apt upgrade
    > php -v
    # To disply a list of current version and installed models
    > apt list --installed | grep php | cut -d'/' -f1
#### Install composer
    > sudo apt update
    > cd ~
    > curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
    > HASH=`curl -sS https://composer.github.io/installer.sig`
    > php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    > sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
    > composer --version
