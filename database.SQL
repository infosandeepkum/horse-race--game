-- database_setup.sql
-- Run this once to set up the horse_race database and table.

CREATE DATABASE IF NOT EXISTS horse_race;
USE horse_race;

CREATE TABLE IF NOT EXISTS winners (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(50)  NOT NULL,
    race_time  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
);
