/*
This is the default db scheme. This file should run first.
You can add other sql files after it.
*/

/* create tables */

drop table if exists groups;
create table groups (
	id_group int unsigned not null auto_increment,
	primary key (id_group),
	title varchar(255)
);

drop table if exists users;
create table users (
	id_user int unsigned not null auto_increment,
	primary key (id_user),
	id_group int unsigned not null,
	foreign key (id_group) references groups(id_group),
	first_name varchar(255),
	fam_name varchar(255),
	email varchar(255),
	pass varchar(255),
	about text
);

drop table if exists topics;
create table topics (
	id_topic int unsigned not null auto_increment,
	primary key (id_topic),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_modified datetime,
	title varchar(255)
);

drop table if exists posts;
create table posts (
	id_post int unsigned not null auto_increment,
	primary key (id_post),
	id_topic int unsigned not null,
	foreign key (id_topic) references topics(id_topic),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_created datetime,
	body text
);

drop table if exists pages;
create table pages (
	id_page int unsigned not null auto_increment,
	primary key (id_page),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_modified datetime,
	title varchar(255),
	body text
);

drop table if exists files;
create table files (
	id_file int unsigned not null auto_increment,
	primary key (id_file),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_modified datetime,
	title varchar(255),
	filename varchar(255)
);

drop table if exists calendars;
create table calendars (
	id_calendar int unsigned not null auto_increment,
	primary key (id_calendar),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_start datetime,
	date_end datetime,
	title varchar(255)
);

drop table if exists schedules;
create table schedules (
	id_schedule int unsigned not null auto_increment,
	primary key (id_schedule),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	time_start time,
	time_end time,
	weekday int unsigned,
	title varchar(255)
);


/* create groups */

insert into groups values(1,'Admin');
insert into groups values(2,'Teacher');
insert into groups values(3,'Student');


/* The admin user is created during install. */


/* create home page */

insert into pages values(null, 1, NOW(), 'Welcome',
	'Home page, edit me!');
