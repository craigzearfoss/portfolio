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
    > sudo apt install php-fpm php-mysql
    > sudo nano /var/www/info.php
    > ?php
    > phpinfo();
    > ?>
    > remove /var/www/info.php
    > sudo apt install software-properties-common
    > sudo add-apt-repository ppa:ondrej/php
    > sudo apt update
    > sudo apt install php8.3
    > sudo apt install php8.3-cli php8.3-mysql php8.3-fpm php8.3-gd php8.3-mbstring php8.3-xml php8.3-curl
    > sudo apt install php-fpm php-mysql php-cli -y
    > sudo apt-get install php-xml unzip curl
    > apt list --upgradable
    > sudo apt upgrade
    > php -v
#### Install composer
    > sudo apt update
    > sudo apt install php-cli unzip curl
    > cd ~
    > curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
    > HASH=`curl -sS https://composer.github.io/installer.sig`
    > php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    > sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
    > composer --version


????????????????????????????

To set the default php version
- sudo update-alternatives --set php /usr/bin/php<version>


### Install other tools
> #sudo apt install certbot python3-certbot-nginx -y
> 
> #sudo certbot --nginx -d craigzearfoss_domain.com




> sudo mkdir /var/www/projectLEMP
sudo chown -R $USER:$USER /var/www/projectLEMP


sudo mkdir /var/www/craigzearfoss.com
sudo chown -R $USER:$USER /var/www/your_domain
sudo nano /etc/nginx/sites-available/your_domain

server {
listen 80;
server_name your_domain www.your_domain;
root /var/www/your_domain;

    index index.html index.htm index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
     }

    location ~ /\.ht {
        deny all;
    }

}

sudo ln -s /etc/nginx/sites-available/your_domain /etc/nginx/sites-enabled/
sudo unlink /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx

nano /var/www/your_domain/index.html


cloning github repo
sudo git clone https://github.com/craigzearfoss/portfolio.git demo.craigzearfoss.com
sudo chown -R ubuntu:ubuntu demo.craigzearfoss.com/

composer require laravel/pint ^1.13

composer update

cd your-app
sudo apt install npm
sudoi npm install
sudo npm run build
sudo npm install bulma

sudo nano /etc/nginx/sites-available/your-app.conf
server {
listen 80;
listen [::]:80;
server_name craigzearfoss.com;
root /var/www/your-app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php-fpm.sock; # Adjust if your PHP-FPM socket path is different
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }


    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_pag

}


sudo rm /etc/nginx/sites-enabled/default




sudo ln -s /etc/nginx/sites-available/your-app.conf /etc/nginx/sites-enabled/
sudo systemctl restart nginx
sudo /etc/init.d/nginx restart

.conf file with cert
--------------------------
server {
server_name craigzearfoss.com;
root /var/www/craigzearfoss.com/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php-fpm.sock; # Adjust if your PHP-FPM socket path is different
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    listen [::]:443 ssl ipv6only=on; # managed by Certbot
    listen 443 ssl; # managed by Certbot
    ssl_certificate /etc/letsencrypt/live/craigzearfoss.com/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/craigzearfoss.com/privkey.pem; # managed by Certbot
    include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot

}

server {
if ($host = craigzearfoss.com) {
return 301 https://$host$request_uri;
} # managed by Certbot


    listen 80;
    listen [::]:80;
    server_name craigzearfoss.com;

    return 404; # managed by Certbot
}







server {
listen 80;
server_name your-domain.com; # Replace with your domain or EC2 public IP
root /var/www/html/your-app/public; # Path to your Laravel public directory

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock; # Adjust PHP version if needed
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;
}


------------------------------------
        server {
            listen 80;
            server_name craigzearfoss.com www.craigzeafoss.com;

            return 301 https://$server_name$request_uri;
        }

        server {
            listen 443 ssl;
            server_name craigzearfoss.com www.craigzearfoss.com;

            ssl_certificate /etc/nginx/ssl/certificate.crt; # Path to your SSL certificate
            ssl_certificate_key /etc/nginx/ssl/private.key; # Path to your SSL private key
            ssl_protocols TLSv1.2 TLSv1.3;
            ssl_ciphers HIGH:!aNULL:!MD5;

            location / {
                # Your application's root directory or proxy pass configuration
                root /var/www/caigzearfoss.com/public;
                index index.html index.htm;

                # Or, if proxying to an application:
                # proxy_pass http://localhost:PORT_OF_YOUR_APP;
                # proxy_set_header Host $host;
                # proxy_set_header X-Real-IP $remote_addr;
                # proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                # proxy_set_header X-Forwarded-Proto $scheme;
            }
        }


sudo ln -s /etc/nginx/sites-available/your-app.conf /etc/nginx/sites-enabled/
sudo systemctl restart nginx



ssh -i ~/Downloads/craigzearfoss_key.pem ubuntu@3.143.143.208
scp -i ~/Downloads/craigzearfoss_key.pem _.craigzearfoss.com/private.key  ubuntu@3.143.143.208:/tmp/private.key





chmod 400 craigzearfoss_key.pem
ssh -i ~/Downloads/craigzearfoss_key.pem ubuntu@44.201.172.35

# Update packages
sudo apt update -y

# Install Nginx
sudo apt install nginx -y

# Start and enable Nginx
sudo systemctl start nginx
sudo systemctl enable nginx

#Install MySQL/MariaDB
sudo apt install mysql-server -y

#Start and enable the database service.

#Run the secure installation script to set a root password and secure the installation:
sudo mysql_secure_installation

#Start and enable PHP-FPM ????
sudo systemctl start php-fpm
sudo systemctl enable php-fpm

---------------------------------------------------------------
#Install git
sudo apt update
sudo apt install git
git --version
git config --global user.name "Craig Zearfoss"
git config --global user.email "craigzearfoss@gmail.com"

---------------------------------------------------------------

---------------------------------------------------------------
#Install Node.js
sudo apt update
sudo apt install nodejs
node -v
sudo apt install npm

#Install NOde Version Manager (NVM)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
reopen you cmd terminal
nvm install 20
nvm use 20
node -v
npm -v

---------------------------------------------------------------
#In project directory
https://github.com/craigzearfoss/portfolio.git craigzearfoss.com
composer update
# might require:
	sudo apt install php-mbstring
	sudo apt install php-xml
	composer global require laravel/pint
npm init -y
npm create vite@latest
npm run build
npm install bulma


#To restart php
sudo systemctl restart php8.3-fpm.service











sudo ufw app list
sudo ufw allow 'Nginx HTTP'
sudo service ufw start
systemctl daemon-reload
ufw status


systemctl status nginx
curl -4 icanhazip.com



sudo chown -R $USER:www-data /var/www/craigzearfoss.com
sudo find /var/www/craigzearfoss.com -type d -exec chmod 755 {} \;
sudo find /var/www/craigzearfoss.com -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/craigzearfoss.com/storage
sudo chmod -R 775 /var/www/craigzearfoss.com/bootstrap/cache
