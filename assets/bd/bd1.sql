DROP DATABASE IF EXISTS spa02;

CREATE DATABASE spa02;

USE spa02;

CREATE TABLE
    IF NOT EXISTS curso (
        IDCURSO INT AUTO_INCREMENT PRIMARY KEY,
        NOME VARCHAR(100) NOT NULL UNIQUE
    ) ENGINE = INNODB DEFAULT CHARSET = utf8mb4;

CREATE TABLE
    IF NOT EXISTS aluno (
        IDALUNO INT AUTO_INCREMENT PRIMARY KEY,
        NOME VARCHAR(100) NOT NULL,
        IDCURSO INT,
        FOREIGN KEY (IDCURSO) REFERENCES curso (IDCURSO)
    ) ENGINE = INNODB DEFAULT CHARSET = utf8mb4;

INSERT INTO
    curso (NOME)
VALUES
    ('Desenvolvimento de Sistemas'),
    ('Redes de Computadores'),
    ('Eletrônica');

INSERT INTO
    aluno (NOME, IDCURSO)
VALUES
    ('João Silva', 1),
    ('Maria Santos', 1),
    ('Pedro Oliveira', 2),
    ('Ana Costa', 3);