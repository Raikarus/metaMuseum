-- Служебная таблица для блокировки доступа
create table locktable(
lockfield integer	-- поле со счётчиком
);
-- задание затравочного значения счётчика
insert into locktable(lockfield) values(0);
grant all on locktable to sch;
grant all on locktable to "www-data";


-- Таблица дисковых томов
-- Для компоновки файлов по внешним носителям
create table volumes(
vol_id	int,	-- уникальный идентификатор тома
		-- он же - номер в имени подкаталога 
dirname	text,	-- имя подкаталога (без пути),
		-- файлы которого компонуются
lock	int DEFAULT 0,	-- Если >0, то том закрыт для записи новых файлов
primary key(vol_id)
);
-- задание затравочного значения индекса
insert into volumes(vol_id) values(0);
grant all on volumes to sch;
grant all on volumes to "www-data";


-- Таблица картинок
create table pics(
pic_id	bigint,	-- уникальный идентификатор картинки
fmt	varchar(4),	-- формат картинки (jpg, tif, png, raw)
subscr	text,	-- произвольное описание картинки
title	text,	-- название картинки
width 	int,	-- ширина картинки
height	int,	-- высота картинки
date	timestamp,	-- дата создания (теоретически) картинки
dirnum	bigint,	-- уникальный номер папки (тома) основного места хранения
fsize	bigint,	-- размер файла в байтах
md5	varchar(32),	-- сумма MD5
rights	text,	-- Информация о правах
vol_id	int,	-- идентификатор тома, в который помещён файл
jpg_id	bigint DEFAULT 0,	-- pic_id копии в формате jpg (jpeg)
				-- 	для файлов tif, png, raw
nkp	int DEFAULT (-1),	-- nkp физического оригинала картинки по БД КП;
				-- в этой БД может повторяться
dnkp	int DEFAULT (-1),	-- dnkp физического оригинала картинки по БД КП;
				-- в этой БД может повторяться
primary key(pic_id),
foreign key(vol_id) references volumes(vol_id)
);
-- задание затравочного значения индекса
insert into pics(pic_id) values(0);
grant all on pics to sch;
grant all on pics to "www-data";


-- Таблица списка тегов
create table tags(
tag_id		int,	-- уникальный идентификатор тега
			-- в этой таблице может повторяться
tag_prt		int,	-- приоритет поиска однотипных тегов
tag_path 	varchar(256) NOT NULL,	-- path ВЫБОРКИ содержимого тега
					-- из выдачи exiftool -X
tag_name 	varchar(30),	-- название тега (как называть в интерфейсе)
pics_name 	varchar(10),	-- имя столбца таблицы pics
tag_type 	int,		-- код типа обработки
				-- 0 - по имени столбца; 
				-- 1 - географич; 
				-- 2 - по таблицам значений и связей
primary key(tag_id,tag_prt)
--UNIQUE(tag_id,tag_prt)
);
-- задание начальных значений
-- регистр букв - по exiftool
insert into tags values
--
(1,1,'//XMP-tiff:DateTime',	'Дата','date',0),
(1,2,'//IFD0:ModifyDate',		'','date',0),
(1,3,'//PNG:ModifyDate',		'','date',0),
(1,4,'//System:FileModifyDate',		'','date',0),
--
(2,1,'//XMP-tiff:ImageWidth',	'Ширина','width',0),
(2,2,'//IFD0:ImageWidth',		'','width',0),
(2,3,'//PNG:ImageWidth',		'','width',0),
(2,4,'//ExifIFD:ExifImageWidth',	'','width',0),
(2,5,'//File:ImageWidth',		'','width',0),
--
(3,1,'//XMP-tiff:ImageHeight',	'Высота','height',0),
(3,2,'//IFD0:ImageHeight',		'','height',0),
(3,3,'//PNG:ImageHeight',		'','height',0),
(3,4,'//ExifIFD:ExifImageHeight',	'','height',0),
(3,5,'//File:ImageHeight',		'','height',0),
--
(4,1,'//XMP-xmp:Label',		'Коллекция','',2),
--
(5,1,'//XMP-dc:Title',		'Название','title',0),
(5,2,'//XMP-photoshop:AuthorPosition',	'','title',0),
(5,3,'//IPTC:ObjectName',		'','title',0),
(5,4,'//IPTC:By-lineTitle',		'','title',0),
--
(6,1,'//ExifIFD:UserComment',	'Описание','subscr',0),
(6,2,'//XMP-exif:UserComment',		'','subscr',0),
(6,3,'//XMP-dc:Description',		'','subscr',0),
(6,4,'//EXIF:ImageDescription',		'','subscr',0),
(6,5,'//XMP-photoshop:Headline',	'','subscr',0),
(6,6,'//IPTC:Caption-Abstract',		'','subscr',0),
(6,7,'//IPTC:Headline',			'','subscr',0),
--
(7,1,'//XMP-photoshop:Country',		'Страна','',1),
(7,2,'//IPTC:Country-PrimaryLocationName',	'','',1),
--
(8,1,'//XMP-photoshop:State',	'Регион (штат)','',1),
(8,2,'//IPTC:Province-State',			'','',1),
--
(9,1,'//XMP-photoshop:City',	'Город (населённый пункт)','',1),
(9,2,'//IPTC:City',					'','',1),
--
(10,1,'//XMP-dc:Subject//rdf:li',	'Ключевые слова','',2),
(10,2,'//IPTC:Keywords',				'','',2),
--
(11,1,'//XMP-dc:Creator//rdf:li',	'Автор(ы)','',2),
(11,2,'//XMP-tiff:Artist',			'','',2),
(11,3,'//IFD0:Artist',				'','',2),
(11,4,'//PNG:Artist',				'','',2),
(11,5,'//XMP-pdf:Author',			'','',2),
(11,6,'//PNG:Author',				'','',2),
--
(12,1,'//XMP-xmp:Identifier//rdf:li',	'Преобразовано из','',2),
(12,2,'//XMP-dc:Identifier',				'','',2),
--
(13,1,'//XMP-dc:Rights',	'Авторские права','rights',0),
(13,2,'//XMP-tiff:Copyright',			'','rights',0),
(13,3,'//EXIF:Copyright',			'','rights',0),
(13,4,'//IPTC:CopyrightNotice',			'','rights',0),
--
(0,0,'','','',0)
;
grant all on tags to sch;
grant all on tags to "www-data";


-- Таблица названий групп ключевых слов/фраз
create table gkwords(
gkword_id	int,			-- уникальный код группы
gkword_name	varchar(128) NOT NULL,	-- название группы
primary key(gkword_id)
);
-- задание начальных значений
insert into gkwords values
(1,'Персоналии'),
(2,'Организации'),
(3,'События'),
--
(0,'')
;
grant all on gkwords to sch;
grant all on gkwords to "www-data";

-- Таблица списка всех возможных значений типа обработки 2
-- (ключевых слов, авторов...)
create table kwords(
tag_id		int,		-- код тега
tag_id_num	int,		-- порядковый номер для тега tag_id
kword_name	varchar(256) NOT NULL,	-- собственно слово/фраза (произвольная строка)
gkword_id	int DEFAULT 0,		-- код группы слова/фразы
					-- Не используется, так как
					-- для этого сделана 
					-- отдельная таблица kwgkw!!!
hidden		int DEFAULT 0,	-- Если >0, то слово/фраза считаются скрытыми
				-- Просто совсем удалять из системы нежелательно - мало ли что?
				-- ВНИМАНИЕ!
				-- На практике удобнее оказалось
				-- отмечать сокрытие спец.кодами в status,
				-- поэтому поле не используется!!!
status		int DEFAULT 0,	-- Статус тега:
				-- 0 - автоматический -
				--     появился при автоматическом вводе 
				--     (по имени подкаталога/файла,
				--     либо вытащен из тегов картинки);
				--     должен быть ВРУЧНУЮ переведён:
				--     - в рабочие;
				--     - в скрытые;
				-- 1 - рабочий - переведён из автоматического,
				--     либо ранее введён вручную и ему уже
				--     сопоставлены картинки;
				--     именно рабочие теги должны назначаться
				--     картинкам при их систематизации
				-- 2 - рабочий - введён вручную,
				--     и пока не привязан ни к одной картинке;
				-- 10,11,12 - аналогичные 0,1,2, но скрытые;
UNIQUE(tag_id,tag_id_num),
foreign key(gkword_id) references gkwords(gkword_id)
);
-- задание затравочных значений индексов
insert into kwords(tag_id,tag_id_num,kword_name) values
(0,0,''),
(4,0,''),
(10,0,''),
(11,0,'')
;
grant all on kwords to sch;
grant all on kwords to "www-data";




-- Таблица сопоставления kwords и gkwords
create table kwgkw(
gkword_id	int NOT NULL,			-- уникальный код группы
tag_id		int NOT NULL,		-- идентификатор тега
tag_id_num	int NOT NULL,		-- порядковый номер тега tag_id
foreign key(gkword_id) references gkwords(gkword_id),
foreign key(tag_id,tag_id_num) references kwords(tag_id,tag_id_num),
UNIQUE(gkword_id,tag_id,tag_id_num)
);
grant all on kwgkw to sch;
grant all on kwgkw to "www-data";




-- Таблица сопоставления kwords и pics
create table pictags(
pic_id		bigint NOT NULL,	-- идентификатор картинки
tag_id		int NOT NULL,		-- идентификатор тега
tag_id_num	int NOT NULL,		-- порядковый номер тега tag_id
doubt	integer default 0,	-- 1 = сомнение в соответствии тега картинке
foreign key(pic_id) references pics(pic_id),
foreign key(tag_id,tag_id_num) references kwords(tag_id,tag_id_num),
UNIQUE(pic_id,tag_id,tag_id_num)
);
grant all on pictags to sch;
grant all on pictags to "www-data";


-- Таблица названий подборок изображений
create table selections(
sel_id		bigint NOT NULL,	-- идентификатор подборки
sel_name	text NOT NULL,		-- название подборки
primary key(sel_id)
);
-- задание затравочного значения подборок
insert into selections(sel_id,sel_name) values(0,'');
grant all on selections to sch;
grant all on selections to "www-data";

-- Таблица сопоставления selections и pics
create table selpics(
sel_id		bigint NOT NULL,	-- идентификатор подборки
pic_id		bigint NOT NULL,	-- идентификатор картинки
foreign key(pic_id) references pics(pic_id),
foreign key(sel_id) references selections(sel_id),
UNIQUE(sel_id,pic_id)
);
grant all on selpics to sch;
grant all on selpics to "www-data";

