#!/bin/bash
# Make sure the file permissions on this script are correct by executing:
#     chmod +x update_project.sh

CONFIG_FILES=(".env" "composer.json" "composer.lock" "package.json" "package-lock.json")

echo -e "Updating the project...\n"

# Get the project directory
CURRENT_DIR=$(pwd)
char="/"
PROJECT_DIR="${CURRENT_DIR%/*}"

# create a backup directory for the current configuration files
CURRENT_DATE=$(date +"%Y%m%d-%H%M%S")
CURRENT_DATE="${CURRENT_DATE// /_}"
CURRENT_DATE="${CURRENT_DATE//:/}"
BACKUPS_DIR="$PROJECT_DIR/logs/backups/$CURRENT_DATE"

if [ ! -d "$BACKUPS_DIR" ]; then
    mkdir -p $BACKUPS_DIR
fi
if [ ! -d "$BACKUPS_DIR" ]; then
    echo "Backups directory $BACKUPS_DIR could not be created."
    exit
fi

echo "Project directory: $PROJECT_DIR"
echo -e "Backups directory: $BACKUPS_DIR\n"

# Backup configuration files
for FILE in "${CONFIG_FILES[@]}"; do
    if [ -f "$PROJECT_DIR/$FILE" ]; then
        echo "cp $PROJECT_DIR/$FILE $BACKUPS_DIR/$FILE"
        cp "$PROJECT_DIR/$FILE" "$BACKUPS_DIR/$FILE"
    else
        echo -e "$PROJECT_DIR/$FILE not be found."
    fi
done

# Pull repository
cd $PROJECT_DIR
echo -e "\nPulling latest changes from the git repository.."

echo -e "git stash -m\"update_project_$CURRENT_DATE\""
git stash -m "update_project_$CURRENT_DATE"
echo -e "git fetch"
git fetch
echo -e "git pull"
git pull

# Update file permission
./update_permissions.sh

# Run composer install
echo -e "\nRunning composer install..."
composer install

echo -e "\nphp artisan optimize"
php artisan optimize
