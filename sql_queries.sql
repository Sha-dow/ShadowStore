###############################################
###--------------------------------------------
###		SQL-queries for Assignment 2		
###		Hannu Ranta	2013					
###		All rights reserved					
###--------------------------------------------
###############################################

#Creates users-table
#Primary key: uid
create table users (
	uid int not null auto_increment,
	firstname varchar(100) not null,
	lastname varchar(100) not null,
	email varchar(255) not null,
	phone varchar(30) not null,
	address varchar(500) not null,
	username varchar(100) not null unique,
	password varchar(64) not null,
	salt varchar(3) not null,
	role varchar(1) not null,

	primary key(uid)
)engine=innodb;

#Creates products-table
#Primary key: pid
create table products (
	pid int not null auto_increment,
	price decimal(10,2) not null,
	name varchar(100) not null,
	description varchar(1000) not null,
	image varchar(200) not null,
	category varchar(100) not null,

	primary key(pid)
)engine=innodb;

#Creates cart-table
#Primary key: cid
#Foreign keys: users(uid)
create table cart (
	cid int not null auto_increment,
	uid int not null,
	orderdate datetime,
	deladdress varchar(500),
	status varchar(100) not null,

	primary key(cid),

	foreign key(uid) references users(uid) 
	on update cascade on delete cascade
)engine=innodb;

#Creates cart_items-table
#Primary key: iid
#Foreign keys: cart(cid), products(pid)
create table cart_items (
	iid int not null auto_increment,
	cid int not null,
	pid int not null,
	price decimal(10,2) not null,
	amount int not null,

	primary key(iid),

	foreign key(cid) references cart(cid)
	on update cascade on delete cascade
)engine=innodb;