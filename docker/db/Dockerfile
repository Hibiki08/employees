FROM --platform=linux/x86_64 mysql:8.0.23

COPY ./db-dumps/db-dump.sql /tmp/db-dump.sql
COPY ./dev-ops/db-dump.sh /tmp/db-dump.sh

RUN mysql_config_editor -v set --socket=/run/mysqld/mysqld.sock
RUN /bin/bash -c /tmp/db-dump.sh \
    && echo 'Dump was created' >> ~/.bashrc