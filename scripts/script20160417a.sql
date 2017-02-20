update text_params
SET
value = 'ACTIVE//INACTIVE'
where code = 'stdstatus';


alter table account
add column dateadded timestamp DEFAULT CURRENT_TIMESTAMP;

alter table account
add column roles varchar(300);

create table accountphoto(
    idno mediumint not null AUTO_INCREMENT,
    accountidno mediumint not null,
    fileindex mediumint not null,
    filename varchar(1000) not null,
    description varchar(100) not null,
    isprimary varchar(30) not null,
    primary key (idno)
    )