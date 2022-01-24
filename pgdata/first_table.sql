#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
create table if not exists urls
(
  id bigserial primary key,
  name varchar(255),
  created_at timestamp(255),
  updated_at timestamp(255)
);
EOSQL