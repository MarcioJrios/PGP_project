DROP DATABASE IF EXISTS id10903184_site_aposta;

CREATE DATABASE id10903184_site_aposta DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE id10903184_site_aposta;

DROP USER IF EXISTS 'adm_site_aposta'@'localhost';

CREATE USER 'adm_site_aposta'@'localhost' IDENTIFIED BY '12345679?'; 

GRANT SELECT, INSERT, UPDATE, DELETE ON id10903184_site_aposta.* TO 'adm_site_aposta'@'localhost';

/*
drop TABLE if exists tipagem;
drop TABLE if exists participantes;
drop TABLE if exists categoria_games;
drop TABLE if exists log_login;
drop TABLE if exists equipes;
drop TABLE if exists apostas;
drop TABLE if exists partidas;
drop TABLE if exists usuarios;
drop TABLE if exists campeonatos;
drop TABLE if exists games;
*/

CREATE TABLE usuarios (
    nome varchar(100) not null,
    nickname varchar(100) not null,
    email varchar(100) not null,
    data_nasc date not null,
    sexo char not null,
    senha varchar(100) not null,
    tipo_usuario INTEGER not null,
    saldo decimal(20,2) not null,
	constraint usuarios primary key(email)
);

CREATE TABLE games (
    id_game INTEGER auto_increment,
    nome varchar(100) not null,
	constraint games primary key(id_game)
);

CREATE TABLE campeonatos (
    id_camp INTEGER auto_increment,
    tipo_camp INTEGER not null,
    nome varchar(100) not null,
    sigla varchar(6) not null,
    horario_inicio date not null,
    horario_termino date not null,
    id_game INTEGER not null,
	constraint campeonatos primary key(id_camp),
    constraint fk_campeonatos_games foreign key (id_game) references games(id_game)
);

CREATE TABLE partidas (
    id_partida INTEGER auto_increment,
    horario_inicio timestamp not null,
    horario_termino timestamp not null,
    id_equipe1 INTEGER not null,
    id_equipe2 INTEGER not null,
    pontos_equipe1 INTEGER,
    pontos_equipe2 INTEGER,
    data_cadastro timestamp not null,
    id_camp INTEGER not null,
	constraint partidas primary key(id_partida)
);

CREATE TABLE equipes (
    id_equipe INTEGER auto_increment,
    nome varchar(100) not null,
    id_game INTEGER not null,
    sigla varchar(3) not null,
	constraint equipes primary key(id_equipe),
    constraint fk_equipes_games foreign key (id_game) references games(id_game)
);

CREATE TABLE apostas (
    id_aposta INTEGER auto_increment,
    valor decimal(20,2) not null,
    email varchar(100) not null,
    id_partida INTEGER not null,
    id_equipe INTEGER not null,
	constraint apostas primary key(id_aposta),
	constraint fk_apostas_usuarios foreign key (email) references usuarios(email),
	constraint fk_apostas_partidas foreign key (id_partida) references partidas(id_partida),
	constraint fk_apostas_equipes foreign key (id_equipe) references equipes(id_equipe)
);

CREATE TABLE log_login (
    id_log INTEGER auto_increment,
    senha_log varchar(100) not null,
    data_access timestamp not null,
    ip_ender varchar(100) not null,
    email_log varchar(100) not null,
	constraint log_login primary key(id_log)
);

CREATE TABLE categoria_games (
    nome varchar(100) not null,
    id_categoria INTEGER auto_increment,
	constraint categoria_games primary key(id_categoria)
);

CREATE TABLE participantes (
    id_equipe INTEGER not null,
    id_camp INTEGER not null,
	constraint fk_participantes_equipes foreign key (id_equipe) references equipes(id_equipe),
	constraint fk_participantes_campeonatos foreign key (id_camp) references campeonatos(id_camp)
);

CREATE TABLE tipagem (
    id_categoria INTEGER not null,
    id_game INTEGER not null,
	constraint fk_tipagem_categoria_games foreign key (id_categoria) references categoria_games(id_categoria),
	constraint fk_tipagem_games foreign key (id_game) references games(id_game)
);

CREATE TRIGGER insere_saldo_usuario BEFORE INSERT
ON usuarios 
FOR EACH ROW 
SET NEW.saldo = 1000;

CREATE TRIGGER insere_data_cadastro_partidas BEFORE INSERT
ON partidas
FOR EACH ROW 
SET NEW.data_cadastro = CURRENT_TIMESTAMP;

insert into usuarios (nome, nickname, email, data_nasc, sexo, senha, tipo_usuario) values
("Admin001","admin001","admin@gmail.com","1999-01-01","m","ff1343e9e5114231f12f7688ccf452ae",0),
("Admin002","admin002","a@b.c","1999-01-01","m","96e79218965eb72c92a549dd5a330112",0),
("teste00","teste00","teste00@gmail.com","1999-01-01","m","d6a705d3fc542ded7c761528e54b3048",0),
("teste01","teste01","teste01@gmail.com","1999-01-01","m","0102e9826d6e14ee5e167f18159aa728",1);

insert into games (nome) values 
("League of Legends"),
("Counter-Strike: Global Offensive"),
("Dota 2"),
("Tom Clancy's Rainbow Six Siege");

insert into equipes (nome, id_game, sigla) values
("Equipe A", 1, "EQA"),
("Equipe B", 1, "EQB"),
("Equipe Y", 2, "EQY"),
("Equipe Z", 2, "EQZ"),
("Pain Gaming", 1, "PNG"),
("INTZ",1,"ITZ");

insert into partidas (horario_inicio, horario_termino, id_equipe1, id_equipe2, id_camp) values
("2019-10-07 13:00", "2019-10-07 14:00", 1, 2, 2),
("2019-10-10 13:00", "2019-10-10 14:00", 3, 4, 1),
("2019-10-09 13:00", "2019-10-09 14:00", 5, 6, 1);

insert into campeonatos (tipo_camp, nome, sigla, horario_inicio, horario_termino, id_game) values 
(3,"Campeonanto Brasileiro de League of Legends","CBLOL","2019-10-08","2019-11-13",1),
(3,"Campeonanto Brasileiro de Conter Strike","CBCS","2019-04-16","2019-04-17",2);

insert into participantes (id_equipe, id_camp) values
(1,1),
(2,1);
