/* mysql -u root licenta < create_db.sql */

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
	body text,
	is_home tinyint unsigned not null default '0'
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

drop table if exists calendar;
create table calendar (
	id_cal int unsigned not null auto_increment,
	primary key (id_cal),
	date_start datetime,
	date_end datetime,
	title varchar(255)
);

drop table if exists schedule;
create table schedule (
	id_sch int unsigned not null auto_increment,
	primary key (id_sch),
	time_start time,
	time_end time,
	weekday int unsigned,
	title varchar(255)
);


/* create groups */

insert into groups values(1,'Admin');
insert into groups values(2,'Teacher');
insert into groups values(3,'Student');


/* create users */

insert into users values(1, 1, null, null, 'admin@example.org',
	'd033e22ae348aeb5660fc2140aec35850c4da997', null);

/* create home page */

insert into pages values(null, 1, '2009-05-01 14:50', 'Welcome',
	'Home page, edit me!', 1);
