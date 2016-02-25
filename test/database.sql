GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root';

CREATE TABLE cad_company (
  idcompany int primary key AUTO_INCREMENT,
  name text not null
);

CREATE TABLE cad_user (
  iduser int primary key AUTO_INCREMENT,
  idcompany int,
  username text not null,
  password text not null
);