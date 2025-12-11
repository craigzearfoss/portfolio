#!/bin/bash
# Make sure the file permissions on this script are correct  by executing:
#     chmod +x update_project.sh
echo -e "Updating the project...\n"

# Get the project directory
current_dir=$(pwd)
char="/"
project_dir="${current_dir%/*}"
echo -e "Project directory: $project_dir\n"
cd $project_dir

echo -e "\nPulling latest changes from the git repository..\n"
echo -e "git stash\n"
git stash
echo -e "git fetch\n"
git fetch
echo -e "git pull\n"
git pull

echo -e "\nUpdating file permissions...\n"
echo -e "sudo chown -R $USER:www-data /var/www/zearfoss.com\n"
sudo chown -R $USER:www-data /var/www/zearfoss.com
echo -e "sudo find /var/www/zearfoss.com -type d -exec chmod 755 {} \\;\n"
sudo find /var/www/zearfoss.com -type d -exec chmod 755 {} \;
echo -e "sudo find /var/www/zearfoss.com -type f -exec chmod 644 {} \\;\n"
sudo find /var/www/zearfoss.com -type f -exec chmod 644 {} \;
echo -e "sudo chmod -R 775 /var/www/zearfoss.com/storage\n"
sudo chmod -R 775 /var/www/zearfoss.com/storage
echo -e "sudo chmod -R 775 /var/www/zearfoss.com/bootstrap/cache\n"
sudo chmod -R 775 /var/www/zearfoss.com/bootstrap/cache

