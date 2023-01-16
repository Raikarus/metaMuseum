  <head>
    <title>ХАХАХАХАХАХА</title>
  </head>

  <html>
        <body>
                ^^^^^^^^^^^^^^^^^^^^ <BR>
         <?php

   
         $tag2 = "softwareAgent";

          $filename ='test2.xmp';
           $text = file_get_contents($filename);

           // echo $text;
            $sub1 = substr($text,strpos($text, $tag2) + strlen($tag2) + 1,strpos($text, $tag2.'>'));
///////////////////////////////////////////////////////////////////////////      

            $sub2 = substr($sub1,0,strpos($sub1, '</')); //содержание тега

           // echo "<pre>$sub2</pre>";

///////////////////////////////////////////////////////////////////////////////////
            $sub3 = substr($sub1,0,strpos($sub1, '>')+1);// для удаления

            $sub4 = '<'.substr($sub3,strpos($sub3, '<')+2,strpos($sub3, '>')).$sub3; // формируем всю строку для удаления

            //echo  htmlspecialchars("<pre>$text</pre>");
            $delete_txt = substr($text,0,strpos($text,$sub4)).substr($text,strpos($text,$sub4)+strlen($sub4),strlen($text));//склеиваем основной текст обходя эту строку

             //echo htmlspecialchars($sub1);

             //echo htmlspecialchars($delete_txt);
              //   echo $pos;
                

///////////////////////////////////////////////////
                  /////////////////////////////////
               $new_text = substr($text,0,strpos($text, $sub2))."Ваня гей".substr($text,strpos($text, $sub2)+strlen($sub2),strlen($text)); //формируем строку где меняем все содержимое тега
              
                echo htmlspecialchars($new_text);

                //вот этот new_text просто записываем в файл полной заменой 


           
          ?>


          </body>
</html>