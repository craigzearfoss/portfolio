#!/bin/bash
# Make sure the file permissions on this script are correct by executing:
#     chmod +x export_databases.sh

mysqldump -u root -p --databases test_system test_dictionary test_portfolio test_personal test_career  --single-transaction --routines --triggers > C:\Users\craig\Temp\all_databases_backup.sql
