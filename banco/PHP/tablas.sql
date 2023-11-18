CREATE TABLE usr (
  phone VARCHAR(10)  NOT NULL  ,
  name VARCHAR(30)  NOT NULL  ,
  cash INTEGER UNSIGNED  NULL    ,
PRIMARY KEY(phone));



CREATE TABLE movements (
  id INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  usr_phone VARCHAR(10)  NOT NULL  ,
  date VARCHAR(100)  NOT NULL  ,
  report VARCHAR(200)  NOT NULL    ,
PRIMARY KEY(id)  ,
INDEX movements_FKIndex1(usr_phone),
  FOREIGN KEY(usr_phone)
    REFERENCES usr(phone)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);



CREATE TABLE account (
  id INTEGER UNSIGNED  NOT NULL   AUTO_INCREMENT,
  usr_phone VARCHAR(10)  NOT NULL  ,
  psswd VARCHAR(20)  NOT NULL    ,
PRIMARY KEY(id)  ,
INDEX account_FKIndex1(usr_phone),
  FOREIGN KEY(usr_phone)
    REFERENCES usr(phone)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION);




