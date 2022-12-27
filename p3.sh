#/bin/bash

################
# Скрипт начального индексирования файлов изображений
# Этап 3
# - Создание файлов Preview (больших и маленьких)

################
# Читаем файл конфигурации
. p.sh.conf

################
# Размеры для файла типа Big
##
## 7 Mpix
## нормальные размеры
#BHeight=2400
#BWidth=3200
## удвоенные размеры
#BBHeight=4800
#BBWidth=6400
#
# 5 Mpix
# нормальные размеры
BHeight=1920
BWidth=2560
# удвоенные размеры
BBHeight=3840
BBWidth=5120
################
# Размеры для файла типа Small
SHeight=600
SWidth=800

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
# Проверяем доступность сервиса smb с файлами Preview
##########################################################################
smbclient -N //${PRV_SERV}/${PRV_PATH}/ -c "echo 1 1"
if [ $? -gt 0 ]
then
	echo "Ошибка! Сервис //${PRV_SERV}/${PRV_PATH}/ недоступен!"
	exit 1
fi

##########################################################################
# Получаем уже занятые пространства на разделах Preview
##########################################################################
# индексами массива являются имена томов
declare -A PVOLS_SIZE
for d in "${PRV_VOL[@]}"
do
	PVOLS_SIZE[${d}]=`smbclient -N //${PRV_SERV}/${PRV_PATH}/ -D ${d} -c "dir" |grep -v " D "| grep -v "blocks available" |awk 'NF>5{sum+=$(NF-5);}END{print sum;}'`
done


##########################################################################
# !!! Эту строчку потом убрать !!!
##########################################################################
free_db

lock_db

echo Работа

# Запомнить входной подкаталог
VOL_IN=$1

# Запросить из БД номера файлов и их подкаталоги
#
# Поскольку в БД никак не отмечается наличие файлов Preview,
# запрашивать надо все файлы, в том числе с закрытых от записи томов.
# Последнее необходимо для случая потери Preview.
# (Если какого-либо исходного файла не окажется в доступе,
# операция создания для него Preview будет просто проигнорирована,
# и тогда необходима будет особая процедура изготовления Preview из "кеша").
zapros="select pics.pic_id, pics.fmt, pics.vol_id from pics,volumes where pics.vol_id=volumes.vol_id and volumes.dirname like '"${VOL_IN}"'"

# Выполнить запрос к БД
# По результатам проверить наличие готовых файлов Preview,
# сформировать отсутствующие файлы Preview
# и разместить их на разделах для Preview.
#
# При невозможности записи очередного файла Preview
# прервать процесс.
# Откат не требуется.
zapr=""
while read i f v
do
	# Сформировать короткое имя исходного файла
	printf -v Fname "p%017d.full.%s" ${i} ${f}
	# Сформировать полное имя исходного файла
	#printf -v FName "%s/%s/v%d/p%017d.full.%s" ${VOL_IN} ${VOLROOT} ${v} ${i} ${f}
	printf -v FName "%s/%s/v%d/%s" ${VOL_IN} ${VOLROOT} ${v} ${Fname}
	# Сформировать простое имя большого файла Preview
	printf -v FBig "p%017d.big.jpg" ${i}
	# Сформировать простое имя маленького файла Preview
	printf -v FSmall "p%017d.small.jpg" ${i}

	echo
	echo "Обработка "${Fname}

	# Проверить наличие большого файла Preview
	dbig=
	# В данном случае 
	# (перебор строковых элементов массива)
	# корректно работает только так:
	for d in "${PRV_VOL[@]}"
	do
		aaa=`smbclient -N //${PRV_SERV}/${PRV_PATH}/ -D ${d} -c "dir ${FBig}"`
		#if [ -f "${d}/${FBig}" ]
		if [ $? -eq 0 ]
		then
			dbig="${d}"
			break
		fi
	done

	# Если файл не найден, то создать его
	if [ -z ${dbig} ]
	then
		# Проверить наличие файла на диске
		if ! [ -f ${FName} ]
		then
			# Отсутствие файла - пропустить этот файл
			# Возможно, что он уже записан на внешний архивный диск
			echo "Файл "${Fname}" недоступен для создания Preview"
			continue
		fi

		echo "Создание "${FBig}
		# Определимся с обрабатываемым размером
		case ${f} in
			"raw" )
				#echo "Вызываем dcraw + awk"
				WxH=`dcraw -i -v ${FName} | grep "Output size"`
				fheight=`echo "${WxH}" | awk '{print $5;}' `
				fwidth=`echo "${WxH}" | awk '{print $3;}' `
				;;
			* )
				#echo "Вызываем identify"
				fheight=`identify -format "%h" ${FName}`
				fwidth=`identify -format "%w" ${FName}`
				;;
		esac
#echo "[h w] "$fheight" "$fwidth

		# Если исходная картинка действительно большая
		# (причём здесь проверяем обе стороны по наибольшему размеру)
		if [ ${fheight} -ge $BWidth ] || [ ${fwidth} -ge $BWidth ]
		then
			# То надо сделать уменьшенную картинку
			#echo "Делаем уменьшенную Big картинку"

			if [ ${fheight} -ge $BBWidth ] || [ ${fwidth} -ge $BBWidth ]
			then
				keyJpSize="-define jpeg:size=${BBWidth}x${BBWidth}"
			else
				keyJpSize=" "
			fi
#echo "[kJS] "$keyJpSize

			# Создать ${FBig} в /tmp
			case ${f} in
				"raw" )
					#echo "Вызываем dcraw + convert"
					dcraw -c -w ${FName} |
					convert - -quality 100 ${keyJpSize} -thumbnail ${BWidth}x${BWidth} -unsharp 0x.5 -strip /tmp/${FBig}
					;;
				* )
					#echo "Вызываем convert"
					convert ${FName} -quality 100 ${keyJpSize} -thumbnail ${BWidth}x${BWidth} -unsharp 0x.5 -strip /tmp/${FBig}
					;;
			esac
		else
			# Иначе за уменьшенную Big картинку 
			# принять копию исходной с конверсией в jpeg
			#echo "Делаем копию исходной картинки в jpeg"

			# Создать ${FBig} в /tmp
			case ${f} in
				"raw" )
					#echo "Вызываем dcraw + convert"
					dcraw -c -w ${FName} |
					convert - -quality 100 -strip /tmp/${FBig}
					;;
				"png" | "tif" )
					#echo "Вызываем convert"
					convert ${FName} -quality 100 -strip /tmp/${FBig}
					;;
				* )
					# Из JPEG убрать всю метаинформацию
					#echo "JPEG не пережимаем"
					exiftool -ALL= -o /tmp/${FBig} ${FName} 					;;
			esac
		fi
		
		# Определяем размер получившегося файла
		read -a asz <<< `ls -l /tmp/${FBig}`
		sz=${asz[4]}

		# Подобрать для него раздел из ${PRV_VOL[]}
		dbig=
		for d in "${PRV_VOL[@]}"
		do
			#read -a asdu <<< `du -bxs ${d}`
			#sdu=$(( ${asdu[0]} + $sz ))
			sdu=$(( ${PVOLS_SIZE[${d}]} + $sz ))
			if [ $sdu -lt $PRV_SIZE ]
			then
				PVOLS_SIZE[${d}]=$sdu
				dbig="${d}"
				break
			fi
		done

		if [ -z ${dbig} ]
		then
			# Не удалось подобрать место - переполнение сервера
			# Процесс должен быть остановлен до решения проблемы
			echo "ОШИБКА!!!"
			echo "На выделенных для Preview разделах нет свободного места!"
			echo "Процесс остановлен."

			free_db
			exit 1
		fi

		# Переместить ${FBig} в подобранный раздел
		#mv /tmp/${FBig} ${dbig}
		smbclient -N //${PRV_SERV}/${PRV_PATH}/ -D ${dbig} -c "lcd /tmp;prompt off;put ${FBig}"
		if [ $? -gt 0 ]
		then
			echo "Ошибка копирования /tmp/${FBig} на //${PRV_SERV}/${PRV_PATH}/${dbig}"
			continue
		fi
	fi

	# Проверить наличие маленького файла Preview
	dsmall=
	for d in "${PRV_VOL[@]}"
	do
		aaa=`smbclient -N //${PRV_SERV}/${PRV_PATH}/ -D ${d} -c "dir ${FSmall}"`
		#if [ -f "${d}/${FSmall}" ]
		if [ $? -eq 0 ]
		then
			dsmall="${d}"
			break
		fi
	done

	# Если файл не найден, то создать его
	if [ -z ${dsmall} ]
	then
		echo "Создание "${FSmall}
		# Здесь, поскольку большой файл Preview уже точно есть,
		# маленький делаем из него (так быстрее и однозначно convert)
		#
		# Кроме того, здесь важна именно высота картинки,
		# независимо от её ориентации

		# Если большого файла нет в /tmp, 
		# скопировать его из smb
		if ! [ -f /tmp/${FBig} ]
		then
			smbclient -N //${PRV_SERV}/${PRV_PATH}/ -D ${dbig} -c "lcd /tmp;prompt off;get ${FBig}"
			if [ $? -gt 0 ]
			then
				echo "Ошибка копирования //${PRV_SERV}/${PRV_PATH}/${dbig}/${FBig} в /tmp"
				continue
			fi
		fi

		# Создать ${FSmall} в /tmp
		convert /tmp/${FBig} -quality 65 -thumbnail x${SHeight} -unsharp 0x.5 -strip /tmp/${FSmall}


		# Определяем размер получившегося файла
		read -a asz <<< `ls -l /tmp/${FSmall}`
		sz=${asz[4]}

		# Подобрать для него раздел из ${PRV_VOL[]}
		dsmall=
		for d in "${PRV_VOL[@]}"
		do
			#read -a asdu <<< `du -bxs ${d}`
			#sdu=$(( ${asdu[0]} + $sz ))
			sdu=$(( ${PVOLS_SIZE[${d}]} + $sz ))
			if [ $sdu -lt $PRV_SIZE ]
			then
				PVOLS_SIZE[${d}]=$sdu
				dsmall="${d}"
				break
			fi
		done

		if [ -z ${dsmall} ]
		then
			# Не удалось подобрать место - переполнение сервера
			# Процесс должен быть остановлен до решения проблемы
			echo "ОШИБКА!!!"
			echo "На выделенных для Preview разделах нет свободного места!"
			echo "Процесс остановлен."

			free_db
			exit 1
		fi

		# Переместить ${FSmall} в подобранный раздел
		#mv /tmp/${FSmall} ${dsmall}
		smbclient -N //${PRV_SERV}/${PRV_PATH}/ -D ${dsmall} -c "lcd /tmp;prompt off;put ${FSmall}"
		if [ $? -gt 0 ]
		then
			echo "Ошибка копирования /tmp/${FSmall} на //${PRV_SERV}/${PRV_PATH}/${dsmall}"
		fi

		# Убрать промежуточные файлы из /tmp
		if [ -f /tmp/${FBig} ]
		then
			rm /tmp/${FBig}
		fi
		if [ -f /tmp/${FSmall} ]
		then
			rm /tmp/${FSmall}
		fi
	fi

	
done < <(
	psql -U sch -h $DBHOST -d $DBNAME -q -t -A -F " " -c "${zapros}"
	)


free_db

