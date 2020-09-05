#!/bin/bash

chmod 777 -R /var/www/html/log
chmod +s -R /var/www/html/log

/usr/sbin/apache2ctl -D FOREGROUND
