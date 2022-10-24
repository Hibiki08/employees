create table if not exists user
(
	id bigint auto_increment comment 'ID сотрудника'
		primary key,
	name varchar(255) not null comment 'Имя сотрудника',
    unique_key int not null comment 'Уникальный ключ',
    parent_key int null

)
comment 'Сотрудники';
create unique index user_unique_key_uindex
    on user (unique_key);

create table if not exists user_tree
(
	id bigint auto_increment comment 'ID связи сотрудника и руководителя'
		primary key,
	user_id bigint not null comment 'ID сотрудника',
	boss_id bigint not null comment 'ID руководителя',
	constraint user_tree_boss_id_fk
		foreign key (boss_id) references user (id)
			on delete cascade,
	constraint user_tree_user_id_fk
		foreign key (user_id) references user (id)
			on delete cascade
)
comment 'Отношения сотрудников друг к другу';