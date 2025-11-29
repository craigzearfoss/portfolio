## Setup
```
composer update
```

```
npm install
```

```
npm run build
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
