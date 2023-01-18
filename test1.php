  <head>
    <title>ХАХАХАХАХАХА</title>
  </head>

  <html>
        <body>
                ^^^^^^^^^^^^^^^^^^^^ <BR>
         <?php

         $tag2 = "CreatorTool";

          $filename ='test_new.xmp';
           $text = file_get_contents($filename);
/*
           // echo $text;
            $sub1 = substr($text,strpos($text, $tag2) + strlen($tag2) + 1,strpos($text, $tag2.'>'));
///////////////////////////////////////////////////////////////////////////      

            $sub2 = substr($sub1,0,strpos($sub1, '</')); //содержание тега

            //echo "<pre>$sub2</pre>";

///////////////////////////////////////////////////////////////////////////////////
            $sub3 = substr($sub1,0,strpos($sub1, '>')+1);// для удаления

            $sub4 = '<'.substr($sub3,strpos($sub3, '<')+2,strpos($sub3, '>')).$sub3; // формируем всю строку для удаления

            //echo  htmlspecialchars("<pre>$text</pre>");
            $delete_txt = substr($text,0,strpos($text,$sub4)).substr($text,strpos($text,$sub4)+strlen($sub4),strlen($text));//склеиваем основной текст обходя эту строку

             //echo htmlspecialchars($sub1);

            // echo htmlspecialchars($delete_txt);
              //   echo $pos;
                

///////////////////////////////////////////////////
                  /////////////////////////////////
               $new_text = substr($text,0,strpos($text, $sub1))."Ваня гей".substr($text,strpos($text, $sub1)+strlen($sub2),strlen($text)); //формируем строку где меняем все содержимое тега
              
                echo htmlspecialchars($new_text);

                //вот этот new_text просто записываем в файл полной заменой 

////////////////////////////////////////////////////////
*/
               /*  $filename1 ='test2.xmp';
                 $text1 = file_get_contents($filename);
*/
          /*       $list = array("DateTime","ModifyDate","FileModifyDate","ImageWidth","ImageHeight","Label","T4444itle","AuthorPosition","ObjectName","By-lineTitle","UserComment","Description","ImageDescription","Headline","Caption-Abstract","Country","Country-PrimaryLocationName","State","Province-State","City","Subject","Keywords","Creator","Artist","Author","Identifier","Rights","Copyright","CopyrightNotice");
                
                  $data_pos = 0;
                  $sub = " " ;
                  $sub1 = " " ;
                   $sub2 = " " ;
                 for($i = 0 ;$i < count($list);$i++)
                 {
                  if(strpos($text, $list[$i]))
                  {
                    $sub = substr($text, strpos($text, $list[$i]));
                    $sub1 = substr($sub,0, strpos($text, ' : '));
                    $sub2 = substr($sub,strpos($text, ':'), strpos($text,"\n"));

                    echo $sub1." : ".$sub2;
                    echo '<br>';
                  }
                  
                 }
                  echo htmlspecialchars("<pre>$text</pre>");
           */


                /*  $str =  "2023:01:18 18:38:55+00:00";

                  $str1 = substr($str,0, strpos($str, ' '));
                  $str1 = str_replace(':','-', $str1);

                  $str1 =  $str1.substr($str,strpos($str, ' '));
                  $str1 = substr($str1,0,strpos($str1,'+'));
                  echo $str1;*/
                  $str = 0;
                 echo '
                       <ul class="logreg">
                        <li><a href="#modal1" class="button7">Регистрация</a></li>
                        <li><a href="#exampleModal" id="#example1" 
                         onclick="$\'echo $str\'" class="button8">Войти</a></li>
                      </ul>';
                 
          ?>
            
          </body>
</html>