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
    data_nasc timestamp not null,
    sexo char not null,
    senha varchar(100) not null,
    tipo_usuario INTEGER not null,
    saldo decimal(20,2) not null,
	constraint usuarios primary key(email)
);

CREATE TABLE campeonatos (
    id_camp INTEGER auto_increment,
    tipo_camp INTEGER not null,
    nome varchar(100) not null,
    sigla varchar(3) not null,
    horario_inicio timestamp not null,
    horario_termino timestamp not null,
	constraint campeonatos primary key(id_camp)
);

CREATE TABLE partidas (
    id_partida INTEGER auto_increment,
    horario_inicio timestamp not null,
    horario_termino timestamp not null,
    id_equipe1 INTEGER not null,
    id_equipe2 INTEGER not null,
    pontos_equipe1 INTEGER not null,
    pontos_equipe2 INTEGER not null,
    data_cadastro timestamp not null,
    id_campeonato INTEGER not null,
    id_camp INTEGER not null,
	constraint partidas primary key(id_partida),
    constraint fk_partidas_campeonatos foreign key (id_camp) references campeonatos(id_camp)
);

CREATE TABLE apostas (
    id_aposta INTEGER auto_increment,
    valor decimal(20,2) not null,
    email varchar(100) not null,
    id_partida INTEGER not null,
	constraint apostas primary key(id_aposta),
	constraint fk_apostas_usuarios foreign key (email) references usuarios(email),
	constraint fk_apostas_partidas foreign key (id_partida) references partidas(id_partida)
);

CREATE TABLE games (
    id_game INTEGER auto_increment,
    nome varchar(100) not null,
	constraint games primary key(id_game)
);

CREATE TABLE equipes (
    id_equipe INTEGER auto_increment,
    nome varchar(100) not null,
    id_game INTEGER not null,
    sigla varchar(3) not null,
	constraint equipes primary key(id_equipe),
    constraint fk_equipes_games foreign key (id_game) references games(id_game)
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
SET NEW.saldo = 0;

CREATE TRIGGER insere_data_acesso_log BEFORE INSERT
ON log_login
FOR EACH ROW 
SET NEW.data_access = CURRENT_TIMESTAMP;

CREATE TRIGGER insere_data_cadastro_partidas BEFORE INSERT
ON partidas
FOR EACH ROW 
SET NEW.data_cadastro = CURRENT_TIMESTAMP;

insert into usuarios (nome, nickname, email, data_nasc, sexo, senha, tipo_usuario) values
("Admin001","admin001","admin@gmail.com","1999-01-01","m","ff1343e9e5114231f12f7688ccf452ae",0);

insert into games (nome) values 
("League of Legends"),
("Counter-Strike: Global Offensive"),
("Dota 2"),
("Tom Clancy's Rainbow Six Siege");