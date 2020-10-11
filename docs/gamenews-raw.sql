CREATE DATABASE gamenews;
USE gamenews;

CREATE TABLE games
(
	id bigint unsigned auto_increment primary key,
    title varchar(100) not null,
    description varchar(255) not null,
    video_id varchar(255) not null
);