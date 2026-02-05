#!/bin/bash
# Make sure the file permissions on this script are correct by executing:
#     chmod +x update_permissions.sh

echo -e "Updating file permissions...\n"

# Get the project directory
CURRENT_DIR=$(pwd)
char="/"
PROJECT_DIR="${CURRENT_DIR%/*}"

# Update file permission
echo -e "\nUpdating file permissions..."
echo -e "sudo chown -R $USER:www-data $PROJECT_DIR"
sudo chown -R $USER:www-data $PROJECT_DIR
echo -e "sudo find $PROJECT_DIR -type d -exec chmod 755 {} \\;"
sudo find /var/www/zearfoss.com -type d -exec chmod 755 {} \;
echo -e "$PROJECT_DIR -type f -exec chmod 644 {} \\;"
sudo find $PROJECT_DIR -type f -exec chmod 644 {} \;
echo -e "sudo chmod -R 775 $PROJECT_DIR/storage"
sudo chmod -R 775 $PROJECT_DIR/storage
echo -e "sudo chmod -R 775 $PROJECT_DIR/bootstrap/cache"
sudo chmod -R 775 $PROJECT_DIR/bootstrap/cache
echo -e "sudo chmod -R 775 $PROJECT_DIR/logs"
sudo chmod -R 775 $PROJECT_DIR/logs
echo -e "sudo chmod -R 775 $PROJECT_DIR/public/images"
sudo chmod -R 775 $PROJECT_DIR/public/images
echo -e "sudo chmod -R 775 $PROJECT_DIR/public/portfolio"
sudo chmod -R 775 $PROJECT_DIR/public/portfolio
echo -e "chmod +x tools/update_permissions.sh\n"
sudo chmod +x $PROJECT_DIR/tools/update_permissions.sh
echo -e "chmod +x $PROJECT_DIR/tools/update_project.sh\n"
sudo chmod +x tools/update_project.sh
