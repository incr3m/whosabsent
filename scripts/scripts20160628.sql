create table accountlog
(
    idno mediumint not null AUTO_INCREMENT,
    accountid int not null,
    logdate timestamp not null,
    remarks varchar(300) ,
    sectionid int not null,
    subjectid int not null,
    primary key (idno)
);

alter table accountlog
add column status varchar(100);
