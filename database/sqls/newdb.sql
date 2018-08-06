create table `news`(
	id int(11) NOT NULL auto_increment,
	content varchar(1000) NOT NULL,
    PRIMARY KEY (`ID`) USING BTREE
);

create table `orders`(
	id int(11)  NOT NULL auto_increment,
    client int(11) NOT NULL,
    paytime char(10) NOT NULL,
    paytype varchar(20) NOT NULL,
    phone varchar(15) NOT NULL,
    foods varchar(1000) NOT NULL,
    PRIMARY KEY (`ID`) USING BTREE
);

create table `foods`(
	id int(11) NOT NULL auto_increment,
    name varchar(30) NOT NULL,
    type varchar(15) NULL,
    price double(5,2) NOT NULL,
    pic varchar(100) NULL,
    PRIMARY KEY (`ID`) USING BTREE
);