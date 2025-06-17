create database InfoJP

use InfoJP

create table usuarios (
	cd_usuario int not null auto_increment primary key,
	ds_usuario varchar(255) not null,
	ds_cpf varchar (11) not null,
	ds_email varchar (100) not null,
	ds_celular varchar (15),
	ds_endereco varchar (100),
	ds_senha varchar (100) not null,
	ds_nascimento varchar (8),
	ds_situacao char not null
);

create table produtos (
	cd_produto int not null auto_increment primary key,
	ds_produto varchar(255) not null,
	cd_categoria int,
	qt_estoque float not null,
	vl_compra float not null,
	vl_venda float not null,
	ds_unidade varchar(5),
	ds_situacao char not null
);

create table servicos (
	cd_servico int not null auto_increment primary key,
	ds_servico varchar(255) not null,
	vl_hora float not null,
	vl_minimo  float not null,
	tp_tipo varchar(100),
    ds_situacao char not null
);

create table categorias (
	cd_categoria int not null auto_increment primary key,
	ds_categoria varchar(100) not null
);

create table veiculos (
	cd_veiculo int not null auto_increment primary key, 
	ds_placa int not null,
	ds_tipo varchar (100) not null,
	ds_cor varchar (50) not null,
	ds_situacao char not null
);

create table clientes (
	cd_cliente int not null auto_increment primary key, 
    ds_nome varchar(255) not null,
    ds_cpf_cnpj varchar (14),
    ds_tel varchar(20),
    ds_cep varchar (8) not null,
    ds_uf varchar (2) not null,
    ds_municipio varchar (200) not null,
    ds_logradouro varchar (100) not null,
    tp_tipo char not null
);

create table vendedores (
	cd_vendedor int not null auto_increment primary key, 
    ds_nome varchar(255) not null
);

create table vendas (
	cd_venda int not null auto_increment primary key, 
    dt_emissao varchar (8) not null,
    vl_frete float not null,
    vl_total float not null,
	ds_situacao varchar (50) not null, 
    cd_vendedor int,
    cd_veiculo int,
    cd_usuario int,
    cd_cliente int
);

create table ite_vendas (
	cd_itevendas int not null auto_increment primary key, 
    ds_produto varchar(255) not null,
    vl_uni float not null,
    qt_venda float not null,
    vl_desc float not null,
    vl_total float not null,
    cd_venda int not null,
    cd_produto int not null, 
    cd_vendedor int
);

create table ser_vendas (
	cd_servenda int not null auto_increment primary key, 
    ds_servico varchar(255) not null,
    vl_hora float not null,
    qt_hora float not null,
    vl_desc float not null,
    vl_total float not null,
    cd_venda int not null,
    cd_servico int not null
);

create table contas_receber (
	cd_receber int not null auto_increment primary key, 
    dt_emissao varchar (8) not null,
    dt_pagamento varchar (8) not null,
    num_doc varchar (100),
    vl_total float not null,
	cd_cliente int,
    cd_venda int
);

create table compras (
	cd_compra int not null auto_increment primary key, 
    dt_emissao varchar (8) not null,
    dt_entrada varchar (8) not null,
    vl_total float not null,
    vl_frete float not null,
    cd_cliente int not null,
    cd_veiculo int
);


create table ite_compras (
	cd_itecompra int not null auto_increment primary key, 
	ds_produto varchar(255) not null,
    vl_uni float not null,
    qt_compra float not null,
    vl_desc float not null,
    vl_total float not null,
    cd_produto int not null,
    cd_compra int not null
);


create table contas_pagar (
	cd_pagar int not null auto_increment primary key, 
    dt_emissao varchar (8) not null,
    dt_pagamento varchar (8) not null,
    num_doc varchar (100),
    vl_total float not null,
	cd_cliente int,
    cd_compra int
);

create table livro_caixa (
	cd_caixa int not null auto_increment primary key,
    dt_entrada varchar (8) not null,
    tipo char not null,
    valor float not null,
    cd_venda int,
    cd_conta_receber int,
    cd_conta_pagar int
);

create table pagamentos (
	cd_pag int not null auto_increment primary key,
    ds_pag varchar (100)
);

create table pag_vendas (
	cd_pagvenda int not null auto_increment primary key,
    cd_venda int not null,
	cd_pagamento int not null
);

create table pag_compras (
	cd_pagcompra int not null auto_increment primary key,
    cd_compra int not null,
    cd_pagamento int not null
);

-- Foreign key -- 
alter table ser_vendas
add constraint FK_SER_VENDAS_VENDAS
foreign key (cd_venda)
references vendas (cd_venda);

alter table ser_vendas
add constraint FK_SER_VENDAS_SERVICOS
foreign key (cd_servico)
references servicos (cd_servico);

alter table vendas
add constraint FK_VENDAS_USUARIOS
foreign key (cd_usuario)
references usuarios (cd_usuario);

alter table vendas
add constraint FK_VENDAS_CLIENTES
foreign key (cd_cliente)
references clientes (cd_cliente);

alter table vendas
add constraint FK_VENDAS_VEICULOS
foreign key (cd_veiculo)
references veiculos (cd_veiculo);

alter table ite_vendas
add constraint FK_ITE_VENDAS_PRODUTOS
foreign key (cd_produto)
references produtos (cd_produto);

alter table ite_vendas
add constraint FK_ITE_VENDAS_VENDEDORES
foreign key (cd_vendedor)
references vendedores (cd_vendedor);

alter table ite_vendas
add constraint FK_ITE_VENDAS_VENDAS
foreign key (cd_venda)
references vendas (cd_venda);

alter table produtos
add constraint FK_PRODUTOS_CATEGORIAS
foreign key (cd_categoria)
references categorias (cd_categoria);

alter table ite_compras
add constraint FK_ITE_COMPRAS_PRODUTOS
foreign key (cd_produto)
references produtos (cd_produto);

alter table ite_compras
add constraint FK_ITE_COMPRAS_COMPRAS
foreign key (cd_compra)
references compras (cd_compra);

alter table compras
add constraint FK_COMPRAS_VEICULOS
foreign key (cd_veiculo)
references veiculos (cd_veiculo);

alter table compras
add constraint FK_COMPRAS_CLIENTES
foreign key (cd_cliente)
references clientes (cd_cliente);

alter table contas_pagar
add constraint FK_CONTAS_PAGAR_COMPRAS
foreign key (cd_compra)
references compras (cd_compra);

alter table livro_caixa
add constraint FK_LIVRO_CAIXA_VENDAS
foreign key (cd_venda)
references vendas (cd_venda);

alter table livro_caixa
add constraint FK_LIVRO_CAIXA_CONTAS_RECEBER
foreign key (cd_conta_receber)
references contas_receber (cd_receber);

alter table livro_caixa
add constraint FK_LIVRO_CAIXA_CONTAS_PAGAR
foreign key (cd_conta_pagar)
references contas_pagar (cd_pagar);

alter table contas_receber
add constraint FK_CONTAS_RECEBER_VENDAS
foreign key (cd_venda)
references vendas (cd_venda);

alter table pag_compras
add constraint FK_PAG_COMPRAS_COMPRAS
foreign key (cd_compra)
references compras (cd_compra);

alter table pag_compras
add constraint FK_PAG_COMPRAS_PAGAMENTOS
foreign key (cd_pagamento)
references pagamentos (cd_pag);

alter table pag_vendas
add constraint FK_PAG_VENDAS_VENDAS
foreign key (cd_venda)
references vendas (cd_venda);

alter table pag_vendas
add constraint FK_PAG_VENDAS_PAGAMENTOS
foreign key (cd_pagamento)
references pagamentos (cd_pag);

-- Inserts --
insert into usuarios (ds_usuario, ds_cpf, ds_email, ds_celular, ds_endereco, ds_senha, ds_nascimento, ds_situacao ) values ('adm', '43243243', 'adm@email.com.br', '432432423', 'teste', '1', '28022003', '1')

update usuarios set ds_email = 'adm@email.com.br'
where cd_usuario = '1'

select * from clientes
select * from usuarios
select * from categorias
select * from produtos
select * from ite_vendas
select * from ser_vendas
select * from vendas
select * from servicos
select * from veiculos
select * from vendedores
select * from pagamentos
select * from pag_vendas

insert into veiculos (ds_placa, ds_tipo, ds_cor, ds_situacao) values ('32432', 'bmw', 'azul', '1')
insert into vendedores (cd_vendedor, ds_nome) values ('1', 'pedro')
insert into pagamentos (cd_vendedor, ds_pag) values ('1', 'pedro')

insert into servicos (ds_servico, vl_hora, vl_minimo, tp_tipo, ds_situacao) values ('servico_teste', '234', '100', 'informatica', '1')


insert into produtos (ds_produto, cd_categoria, qt_estoque , vl_compra, vl_venda, ds_unidade, ds_situacao) values ('teste','1', '23','23','34','und','1')

insert into categorias (ds_categoria) values ('categoria_teste')

update clientes set tp_tipo = '0' where cd_cliente = '3'


insert into clientes (ds_nome, ds_cpf_cnpj, ds_tel , ds_cep, ds_uf, ds_municipio, ds_logradouro, tp_tipo) values ('Joao','87987898', '4324323','488849','SC','teste','teste','1');
insert into clientes (ds_nome, ds_cpf_cnpj, ds_tel, ds_cep, ds_uf, ds_municipio, ds_logradouro, tp_tipo) values ('Teste','87987898', '4324323','488849','SC','teste','teste','1')

drop database infojp