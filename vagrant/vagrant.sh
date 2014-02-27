#!/bin/bash

install() {
  installed $1
  if [ "$?" -gt 0 ]; then
    apt-get install -q -y $1
  fi
}

#sudo apt-get update && sudo apt-get dist-upgrade
#install update-manager
#sudo apt-get install virtualbox-guest-utils

#sudo apt-get install python-software-properties
#sudo add-apt-repository ppa:ondrej/php5-oldstable
#sudo apt-get update && sudo apt-get install php5

#
#ln -s /etc/php5/apache2/php.ini /var/www/vagrant/php.ini
#
install apache2
install php5
install mysql-server
install php5-mysql
install php5-json

exit 0
