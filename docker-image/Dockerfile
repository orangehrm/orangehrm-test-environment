FROM orangehrm/orangehrm-environment-images:prod-7.0

MAINTAINER orangehrm
LABEL authors = "OrangeHRM TechOps <techops@orangehrm.com>"

# install dependent software
RUN yum install -y gcc-c++ make
RUN curl -sL https://rpm.nodesource.com/setup_6.x | bash -

RUN touch /etc/yum.repos.d/wandisco-svn.repo
RUN echo $'[WandiscoSVN] \nname=Wandisco SVN Repo \nbaseurl=http://opensource.wandisco.com/centos/7/svn-1.9/RPMS/$basearch/ \nenabled=1 \ngpgcheck=0 ' > /etc/yum.repos.d/wandisco-svn.repo

#installing nodejs
RUN yum -y install \
    bzip2 \
    git \
    nmap \
    nodejs \
    sendmail \
    subversion mod_dav_svn \
    vim \
    && yum -y update bash \
    && rm -rf /var/cache/yum/* \
    && yum clean all
# Our user in the container
USER root
# set working dir as the installer directory
WORKDIR /var/www/html/installer/

#install bower and gulp
RUN npm install bower gulp nodemon node-sass pm2 -g

install php-ast module
RUN pecl install ast
RUN echo "extension=/usr/lib64/php/modules/ast.so" >> /etc/php.ini

install php-stats module
RUN pecl install stats-2.0.3
RUN echo "extension=stats.so" >> /etc/php.ini


# temporary switch on the "allow_url_fopen" to install composer and phan
RUN sed -i 's:^allow_url_fopen = Off$:allow_url_fopen = On:g' /etc/php.ini

# installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#add vhost config
COPY config/apache2-sites/orangehrm.conf /etc/httpd/sites-available/orangehrm.conf
COPY config/apache2-sites/000-default.conf /etc/httpd/sites-available/000-default.conf
COPY config/cert/orangehrm.crt /etc/apache2/cert/orangehrm.crt
COPY config/cert/orangehrm.key /etc/apache2/cert/orangehrm.key
RUN rm /etc/httpd/sites-enabled/orangehrm.conf
RUN ln -s /etc/httpd/sites-available/orangehrm.conf /etc/httpd/sites-enabled/orangehrm.conf
RUN ln -s /etc/httpd/sites-available/000-default.conf /etc/httpd/sites-enabled/000-default.conf

# copy configuration files
COPY config/mysql-client/my.cnf /etc/mysql/my.cnf
COPY config/mysql-client/conf.d /etc/mysql/conf.d
COPY config/db-check.sh /var/www/db-check.sh
COPY phpunit-5.7.21.phar /usr/bin/phpunit
COPY phpunit-3.7.28.phar /usr/bin/phpunit3
RUN  chmod +x /usr/bin/phpunit
#CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

# installing phan
RUN cd /var/lib && composer require --dev phan/phan
RUN ln -s /var/lib/vendor/bin/phan /usr/bin/phan

# switch off allow_url_fopen
RUN sed -i 's:^allow_url_fopen = On$:allow_url_fopen = Off:g' /etc/php.ini

# enable and configure xdebug
RUN pecl install Xdebug

#installing nc command
RUN yum install -y nmap-ncat
