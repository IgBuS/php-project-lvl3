create table if not exists urls
(
  id bigserial primary key,
  name varchar(255),
  created_at timestamp(255),
  updated_at timestamp(255)
);