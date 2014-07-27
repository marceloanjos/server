#! /bin/bash

if [[ EUID -ne 0 ]]; then
   echo "*** Attempting to run as root ***" 1>&2
   sudo $BASH_SOURCE
   exit 0
fi

SETUPPATH=$(dirname $0) 

echo "Setting owner for $USER"
#chown $USER:www-data $SETUPPATH -R

echo "Setting permissions"
chmod ugo+rw $SETUPPATH -R

#switch to the directory if we are not already there
cd $SETUPPATH

echo "Import MySQL"
mysql -u root -p < Restore.sql

echo "Remeber to modify the mysql password in file:"
echo $SETUPPATH/protected/config/main.php
echo "'password' => 'password',"
