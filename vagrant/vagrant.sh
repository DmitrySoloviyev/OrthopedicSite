#!/bin/bash

CURRENT_DIR=$(pwd)

exiterr() {
    if [ "$1" -gt 0 ]; then
        if [ ! -z "$2" ]; then
            echo $2
        fi
        exit $1
    fi
}

##
# Установочные функции
##
# функция проверки, установлен ли пакет
installed() {
    if [ -z "$2" ]; then #если второй параметр $2 пустой
        if [ -f "/var/www/vagrant/var/installed-$1" ]; then
            return 0 # если есть файл, пакет установлен, выходим и возвращаем 0
        fi
        return 1 # файл не существует, пакет не установлен, выходим и возвращаем 1
    fi

    touch /var/www/vagrant/var/installed-$1 # создаем файл
}

# функция установки ПО
install() {
  installed $1
  if [ "$?" -gt 0 ]; then
    sudo apt-get install -q -y $1 || exiterr $? "$1 installation failed"
    installed $1 ok
  fi
}

install-phpunit() {
    installed phpunit
    if [ "$?" -gt 0 ]; then
        pear channel-discover pear.phpunit.de
        pear channel-discover components.ez.no
        pear channel-discover pear.symfony-project.com
        pear channel-discover pear.symfony.com
        pear update-channels
        pear install --alldeps phpunit/PHPUnit-3.7.32
        pear install --alldeps phpunit/DbUnit
        pear install --alldeps phpunit/PHPUnit_Story
        pear install --alldeps phpunit/PHPUnit_Selenium
        installed phpunit ok
    fi
}

install-composer() {
  if [ ! -f /var/www/composer.phar ]; then
    cd /var/www/
    curl -sS https://getcomposer.org/installer | php || exiterr $? "Failed to install the composer"
    cd $CURRENT_DIR
    installed composer ok
  fi
}


##
# Конфигурационные функции
##
configured() {
    if [ -z "$2" ]; then
        if [ -f /var/www/vagrant/var/configured-$1 ]; then
            return 0;
        fi
        return 1;
    fi

    touch /var/www/vagrant/var/configured-$1
}

configure-php() {
    configured php55
    if [ "$?" -gt 0 ]; then
        sudo cp /var/www/vagrant/php.ini /etc/php5/apache2/php.ini
        configured php55 ok
    fi
}

configure-mysql() {
    configured mysql
    if [ "$?" -gt 0 ]; then
        sudo cp /var/www/vagrant/my.cnf /etc/mysql/my.cnf
        configured mysql ok
    fi
}

configure-locale() {
    configured locale
    if [ "$?" -gt 0 ]; then
        echo "Europe/Moscow" | sudo tee /etc/timezone
        Europe/Moscow
        sudo dpkg-reconfigure --frontend noninteractive tzdata
        configured locale ok
    fi
}

configure-mod-rewrite() {
    configured mod-rewrite
    if [ "$?" -gt 0 ]; then
        sudo service apache2 stop
        sudo cp /var/www/vagrant/apache2.conf /etc/apache2/apache2.conf
        sudo cp /var/www/vagrant/000-default.conf /etc/apache2/sites-enabled/000-default.conf
        sudo service apache2 start
        configured mod-rewrite ok
    fi
}


##
# Прочие функции
##
load-migrations() {
    php /var/www/protected/yiic migrate || exiterr $? "Failed to load migrations!"
}

load-migrations-test() {
    php /var/www/protected/yiic migrate --connectionID=db_test || exiterr $? "Failed to load migrations!"
}

created() {
    if [ -z "$2" ]; then
        if [ -f /var/www/vagrant/var/created-$1 ]; then
            return 0;
        fi
        return 1;
    fi

    touch /var/www/vagrant/var/created-$1
}

create-db() {
    created db
    if [ "$?" -gt 0 ]; then
        mysqladmin -uroot -p1111 CREATE ortho_db
        created db ok
    fi
}

create-db-test() {
    created db_test
    if [ "$?" -gt 0 ]; then
        mysqladmin -uroot -p1111 CREATE ortho_db_test
        created db_test ok
    fi
}


### Выполнение ###
sudo apt-get update
configure-locale
install virtualbox-guest-utils
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password 1111'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 1111'
install mysql-server
install mysql-client
install apache2
install php5-curl
install php5
install php-pear
install php5-mysql
install php5-json
install php5-gd
install php-apc
#install-composer
#update-composer
install php5-xdebug
install apache2-utils
install-phpunit
install redis-server
install php5-redis

configure-mysql
configure-php
configure-mod-rewrite

create-db
create-db-test
load-migrations
load-migrations-test

sudo service apache2 restart && echo -e "\napache is ready!"
sudo service mysql restart && echo "mysql is ready!"

exit 0
