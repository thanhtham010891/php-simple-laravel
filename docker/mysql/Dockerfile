FROM mysql:5.7

COPY ./my.cnf /etc/mysql/my.cnf
ADD scripts.sql /docker-entrypoint-initdb.d/scripts.sql
RUN chmod -R 775 /docker-entrypoint-initdb.d
