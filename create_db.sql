/* mysql -u root licenta < create_db.sql */

create table users (
	id_user int not null auto_increment,
	primary key (id_user),
	first_name varchar(40),
	fam_name varchar(40),
	pass varchar(40),
	email varchar(40),
	group_ varchar(20)
);

create table topics (
	id_topic int not null auto_increment,
	primary key (id_topic),
	id_user int,
	foreign key (id_user) references users(id_user),
	date_ datetime,
	title varchar(80)
);

create table posts (
	id_post int not null auto_increment,
	primary key (id_post),
	id_topic int,
	foreign key (id_topic) references topics(id_topic),
	id_user int,
	foreign key (id_user) references users(id_user),
	date_ datetime,
	body varchar(5000)
);

create table pages (
	id_page int not null auto_increment,
	primary key (id_page),
	id_user int,
	foreign key (id_user) references users(id_user),
	date_ datetime,
	title varchar(80),
	body varchar(5000)
);

create table files (
	id_file int not null auto_increment,
	primary key (id_file),
	id_user int,
	foreign key (id_user) references users(id_user),
	date_ datetime,
	title varchar(80),
	filename varchar(60)
);

create table calendar (
	id_cal int not null auto_increment,
	primary key (id_cal),
	id_user int,
	foreign key (id_user) references users(id_user),
	start_date datetime,
	end_date datetime,
	title varchar(80)
);

create table schedule (
	id_sch int not null auto_increment,
	primary key (id_sch),
	id_user int,
	foreign key (id_user) references users(id_user),
	start_time time,
	end_time time,
	weekday int,
	title varchar(80)
);
