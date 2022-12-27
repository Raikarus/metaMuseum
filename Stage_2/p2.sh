#/bin/bash

################
# Скрипт начального индексирования файлов изображений
# Этап 2
# - Выборка и занесение в БД сумм MD5

################
# Читаем файл конфигурации
. p.sh.conf

################
################
# Захватить БД в монопольное пользование на запись или отказаться от работы.
# Здесь же отследить ошибку при обращении к БД.
# Наиболее вероятными являются ошибки отсутствия таблиц
# или невозможности связаться с самой БД.
# Если здесь ошибок не произошло, то дальше их возникновение маловероятно,
# и их можно не проверять (это очень неудобно делать)
#
function lock_db ()
{
local zapros
local t

zapros="update locktable set lockfield=lockfield+1"
psql -U sch -h $DBHOST -d $DBNAME -q -t -A -F "|" -c "${zapros}"
if [ $? -ne 0 ]
then
	echo Ошибка захвата БД
	exit 1
fi

zapros="select lockfield from locktable"
t=`psql -U sch -h $DBHOST -d $DBNAME -q -t -A -F "|" -c  "${zapros}"`
if [ $t -gt 1 ]
then
	echo БД занята
	exit 1
fi
}

################
################
# Освободить БД
function free_db ()
{
local zapros

zapros="update locktable set lockfield=0"
psql -U sch -h $DBHOST -d $DBNAME -q -t -A -F "|" -c "${zapros}"
}


##########################################################################
##########################################################################
##########################################################################
# Начало программы
##########################################################################
##########################################################################
##########################################################################
if [ $# -lt 1 ]
then
	echo "Запуск: "`basename $0`" подкаталог"
	exit 1
fi
if ! [ -d $1 ]
then
	echo Не найден подкаталог $1
	exit 1
fi

##########################################################################
# !!! Эту строчку потом убрать !!!
##########################################################################
free_db

lock_db

echo Работа

# Запомнить входной подкаталог
VOL_IN=$1

# Запросить из БД номера файлов и их подкаталоги,
# для которых в БД ещё нет MD5
zapros="select pics.pic_id, pics.fmt, pics.vol_id from pics,volumes where pics.md5 is null and pics.vol_id=volumes.vol_id and volumes.lock=0 and volumes.dirname like '"${VOL_IN}"'"

# Выполнить запрос к БД
# По результатам сформировать имена файлов,
# извлечь суммы MD5
# и подготовить их запись в БД
zapr=""
while read i f v
do
	printf -v FName "%s/v%d/p%017d.full.%s" ${VOLROOT} ${v} ${i} ${f}
	fname=`find ${VOL_IN} -samefile "${VOL_IN}/${FName}" |grep -v "${VOL_IN}/${FName}"`
	read md5 rest <<< `grep "${fname/${VOL_IN}\//}" ${VOL_IN}/MD5`
	if [ -z "${md5}" ]
	then
		echo "Нет суммы MD5 для файла ${FName}(${fname})"
	else
		zapr=${zapr}"update pics set md5='"${md5}"' where pic_id="${i}"; "
	fi
done < <(
	psql -U sch -h $DBHOST -d $DBNAME -q -t -A -F " " -c "${zapros}"
	)

# Выполнить занесение сумм MD5 в БД
if ! [ -z "${zapr}" ]
then
	zapr="begin transaction; "${zapr}" end transaction;"
	#echo ${zapr}
	psql -U sch -h $DBHOST -d $DBNAME -q -t -A -F " " -c "${zapr}"
	if [ $? -ne 0 ]
	then
		echo Ошибка занесения сумм MD5 в БД
	fi
fi


free_db

