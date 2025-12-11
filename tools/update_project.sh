#!/bin/bash
# Make sure the file permissions on this script are correct  by executing:
#     chmod +x update_repo.sh
echo -e "Updating the project...\n"

# Get the project directory
current_dir=$(pwd)
char="/"
project_dir="${current_dir%/*}"
echo -e "Project directory: $project_dir\n"
cd $project_dir

echo "\nPulling latest changes from the git repository..\n"
git stash
git fetch
git pull

echo -e "\nUpdating file permissions...\n"
sudo chown -R $USER:www-data /var/www/zearfoss.com
sudo find /var/www/zearfoss.com -type d -exec chmod 755 {} \;
sudo find /var/www/zearfoss.com -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/zearfoss.com/storage
sudo chmod -R 775 /var/www/zearfoss.com/bootstrap/cache
