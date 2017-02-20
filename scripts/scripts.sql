create table subjectunit(
    idno mediumint not null AUTO_INCREMENT,
    code varchar(15) not null,
    description varchar(100) not null,
    unit int not null,
    primary key (idno)
    )