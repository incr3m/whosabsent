alter table account
add column usn varchar(100);

update account
SET
usn = '2016-000'+idno;

alter table account
modify usn varchar(100) not null;