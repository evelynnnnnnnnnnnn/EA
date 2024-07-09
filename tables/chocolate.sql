create table chocolate (
                                  id INTEGER NOT NULL auto_increment PRIMARY KEY,
                                  name VARCHAR(50),
                                  weight INT(6),
                                  factory_id INT(10),
                                  country_id INT(10)
);

insert into chocolate (id, name, weight, factory_id, country_id) values (1, 'Марс', '75', 284, 287);
insert into chocolate (id, name, weight, factory_id, country_id) values (2, 'Бобаевский 75%', '125', 283, 286);
insert into chocolate (id, name, weight, factory_id, country_id) values (3, 'Милки вей', '85', 281, 288);

drop table chocolate (
                           id INTEGER NOT NULL auto_increment PRIMARY KEY,
                           name VARCHAR(50),
                           weight INT(6),
                           factory_id TINYINT(4),
                           country_id TINYINT(4)
);