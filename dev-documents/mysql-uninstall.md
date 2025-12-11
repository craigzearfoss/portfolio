## Uninstall Mysql
```
# 1. Stop the MySQL service
sudo systemctl stop mysql

# 2. Purge all MySQL packages (use 'mysql*' for older/variations)
sudo apt purge mysql-server mysql-client mysql-common mysql-server-core-* mysql-client-core-*

# 3. Remove configuration and data directories
sudo rm -rf /etc/mysql /var/lib/mysql /var/log/mysql

# 4. Clean up unnecessary packages and cache
sudo apt autoremove
sudo apt autoclean

# (Optional) Remove the MySQL user and group if they still exist
sudo deluser --remove-home mysql
sudo delgroup mysql
```
