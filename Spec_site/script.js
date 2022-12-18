function flipflop( id )
         {

          // id -- идентификатор элемента, который надо скрыть или показать

          // получаем этот элемент
          element = document.getElementById( id );

          // если таковой в документе существует
          if( element )   
             // меняем ему видимость
             element.style.display = element.style.display == "none" ? "" : "none";   
         }