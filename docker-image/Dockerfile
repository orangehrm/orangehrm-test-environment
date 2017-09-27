FROM orangehrm/orangehrm-environment-images:prod-5.6-centos

MAINTAINER orangehrm
LABEL authors = "Ridwan Shariffdeen <ridwan@orangehrmlive.com>, Chamin Wickramarathne  <chamin@orangehrmlive.com>, Thulana Kannangara <thulana@orangehrm.us.com>"

# install dependent software
RUN yum -y install \
    bzip2 \
    netcat-openbsd \
    && yum -y update bash \
    && rm -rf /var/cache/yum/* \
    && yum clean all

# Enable and configure xdebug
RUN pecl install xdebug && \
  pecl install mongo && \
  pecl install pecl.php.net/xhprof-0.9.4


# Our user in the container
USER root

#add vhost config
COPY config/apache2-sites/orangehrm.conf /etc/httpd/sites-available/orangehrm.conf
COPY config/apache2-sites/000-default.conf /etc/httpd/sites-available/000-default.conf
COPY config/cert/orangehrm.crt /etc/apache2/cert/orangehrm.crt
COPY config/cert/orangehrm.key /etc/apache2/cert/orangehrm.key
RUN rm /etc/httpd/sites-enabled/orangehrm.conf
RUN ln -s /etc/httpd/sites-available/orangehrm.conf /etc/httpd/sites-enabled/orangehrm.conf
RUN ln -s /etc/httpd/sites-available/000-default.conf /etc/httpd/sites-enabled/000-default.conf

# set working dir as the installer directory
WORKDIR /var/www/html/installer/

# copy configuration files
COPY config/mysql-client/my.cnf /etc/mysql/my.cnf
COPY config/php.ini /etc/php.ini
RUN echo "zend_extension=/usr/lib64/php/modules/xdebug.so" >>/etc/php.ini
COPY config/db-check.sh /var/www/db-check.sh
COPY phpunit-5.7.21.phar /usr/bin/phpunit
RUN  chmod +x /usr/bin/phpunit
#CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
