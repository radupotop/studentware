/* mysql -u root licenta < create_db.sql */

/* create tables */

create table groups (
	id_group int unsigned not null auto_increment,
	primary key (id_group),
	title varchar(255)
);

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

create table topics (
	id_topic int unsigned not null auto_increment,
	primary key (id_topic),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_modified datetime,
	title varchar(255)
);

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

create table pages (
	id_page int unsigned not null auto_increment,
	primary key (id_page),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_modified datetime,
	title varchar(255),
	body text
);

create table files (
	id_file int unsigned not null auto_increment,
	primary key (id_file),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_modified datetime,
	title varchar(255),
	filename varchar(255)
);

create table calendar (
	id_cal int unsigned not null auto_increment,
	primary key (id_cal),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	date_start datetime,
	date_end datetime,
	title varchar(255)
);

create table schedule (
	id_sch int unsigned not null auto_increment,
	primary key (id_sch),
	id_user int unsigned,
	foreign key (id_user) references users(id_user),
	time_start time,
	time_end time,
	weekday int unsigned,
	title varchar(255)
);


/* create groups */

insert into groups values(1,'special');
insert into groups values(2,'admin');
insert into groups values(3,'teacher');
insert into groups values(4,'student');


/* create users */

insert into users values(null, 1, null, null, null, null, null);
insert into users values(null, 2, null, null, 'admin', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', null);
