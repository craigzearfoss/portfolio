## Setup

```
cd /path/to/your/project
php artisan key:generate
```

Make the databases
------------------
it's recommended that you add a prefix to all of the tables to distinguish them from other databases, like test_system, test_dictionary, etc.
```
system
dictionary
career
personal
portfolio
```

Copy .env.sample to .env and edit settings
------------------------------------------
- Set the APP_URL.
- Add credentials for all of the databases.

Set file and directory permissions
----------------------------------
```
sudo chown -R $USER:www-data /path/to/your/project
sudo find /path/to/your/project -type d -exec chmod 755 {} \;
sudo find /path/to/your/project -type f -exec chmod 644 {} \;
sudo chmod -R 775 /path/to/your/project/storage
sudo chmod -R 775 /path/to/your/project/bootstrap/cache
```

Run setup commands
------------------------
```
composer update
npm install
npm run build
npm install bulma
```

Populate the database
---------------------
Run Laravel migrations. _(You will be prompted for passwords for the root admin and the default admin_).
```
php artisan migrate
```

If you want to import sample admins, run the following console command.
```
php artisan app:init-sample-admin all
```

Copy asset files
----------------
- Copy images from the /source_files/images directory to /public/images.
```
php artisan app:copy-source-images
```


composer require toin0u/geocoder-laravel
