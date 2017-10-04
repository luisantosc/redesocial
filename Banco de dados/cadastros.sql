create schema cadastros default char set utf8;
use cadastros;

create table cadastro (
	id int not null,
    nome varchar (20) not null,
	username varchar(10) not null,
	senha varchar(20) not null,
    email varchar (50) not null,
    sexo varchar (2),
	primary key (username)
);
create table amizade(
	convite int not null,
    convidado int not null,
    status varchar(30) not null,
    primary key(convite, convidado),
    foreign key(convite) references cadastro (id),
	foreign key(convidado) references cadastro (id)
);

insert into cadastro (id,nome,sobrenome,username,senha,email,sexo)
	values (1,'Luís Filipe','Santos','luisf','1234','luisf@gmal.com', 'M');
    
insert into amizade (convite, convidado, status)
	values (1,2,'aguardo');
    
    
insert into amizade (convite, convidado, status)
	values 
    (3,2,'aguardo'),
	(3,1,'aguardo');
    
    
    select * from cadastro;
    select * from amizade;
    show tables;
    
alter table cadastro
	add column sobrenome varchar(20) not null;
    
 delete  from cadastro
where id != 0 and username !='';

