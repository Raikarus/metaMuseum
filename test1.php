  <head>
    <title>ХАХАХАХАХАХА</title>
  </head>

  <html>
        <body>
                ^^^^^^^^^^^^^^^^^^^^ <BR>
         <?php

         $tag = "Artist";
         $tag2 = "softwareAgent";

         $var = "<rdf:Description rdf:about='20221225-2837_ss.jpg'
                  xmlns:et='http://ns.exiftool.ca/1.0/' et:toolkit='Image::ExifTool 12.16'
                  xmlns:IFD0='http://ns.exiftool.ca/EXIF/IFD0/1.0/'>
                 <IFD0:Artist>GAY1</IFD0:Artist>
                </rdf:Description>
                </rdf:RDF>";

          //$sub = substr($var,strpos($var, ':'.$tag),strpos($var,"</rdf:Description>"));

          $pos = substr($var,strpos($var, $tag) + strlen($tag) + 1,strpos($var, $tag.'>'));
          $filename ='test2.xmp';
           $text = file_get_contents($filename);

           // echo $text;
            $sub1 = substr($text,strpos($text, $tag2) + strlen($tag2) + 1,strpos($text, $tag2.'>'));
                 
            $sub2 = substr($sub1,0,strpos($sub1, ' '));

           // echo "<pre>$sub2</pre>";

            echo "<pre>$text</pre>";
              //   echo $pos;
                

///////////////////////////////////////////////////
                  /////////////////////////////////
     /*          $new_text = substr($text,0,strpos($text, $sub2))."Ваня гей".substr($text,strpos($text, $sub2)+strlen($sub2),strlen($text));
              
                echo "<pre>$new_text</pre>";
               if (is_writable($filename))
                 {

                    if (!$fp = fopen($filename, 'w+')) {
                         echo "Не могу открыть файл ($filename)";
                         exit;
                    }

                    // Записываем $somecontent в наш открытый файл.
                    if (fwrite($fp, $somecontent) === FALSE) {
                        echo "Не могу произвести запись в файл ($filename)";
                        exit;
                    }

                    echo "Ура! Записали ($somecontent) в файл ($filename)";

                    fclose($fp);

            } else {
                echo "Файл $filename недоступен для записи";
            }*/
          ?>


          </body>
</html>