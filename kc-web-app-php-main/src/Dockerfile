# Base stage
FROM debian:12.4-slim AS base

LABEL version="1.0"
LABEL description="Imagen Apache sobre Bookworn"
LABEL vendor="Firewall Force"

COPY docker/* /root/

RUN useradd -s /bin/bash keepcoding

#---------------------------------------------------------------------------

# APACHE Stage
FROM base AS apache

RUN apt-get -y update && apt-get -y install apache2 && a2enmod rewrite

COPY --from=base /root/apache2.conf /etc/apache2/
COPY --from=base /root/000-default.conf /etc/apache2/sites-available/

#---------------------------------------------------------------------------

# PHP Stage
FROM apache AS php

RUN apt-get -y update && apt-get -y install php && \
    apt-get -y install php-xmlrpc php-curl php-gd && \
    apt-get -y install php-cli php-mysql && \
    apt-get -y install php-zip php-common

#---------------------------------------------------------------------------

# FINAL Stage
FROM php AS final

WORKDIR /var/www/html

COPY --from=base /etc/passwd /etc/passwd
COPY --from=base /root/start.sh /usr/local/bin/start.sh

RUN apt-get -y install mariadb-client nano dos2unix && \
    rm -rf /var/www/html/index.html && \
    dos2unix /usr/local/bin/start.sh && \
    chmod +x /usr/local/bin/start.sh

COPY ./index.php /var/www/html/
COPY ./metrics.php /var/www/html/
COPY ./img /var/www/html/img
COPY ./lib /var/www/html/lib

# CMD que Ejecuta el script de inicio
CMD ["/bin/bash", "-c", "/usr/local/bin/start.sh"]
