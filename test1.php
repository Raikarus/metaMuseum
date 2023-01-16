  <head>
    <title>ХАХАХАХАХАХА</title>
  </head>

  <html>
        <body>
                ^^^^^^^^^^^^^^^^^^^^ <BR>
         <?php

         $tag = "Artist";
         $tag2 = "CreateDate";

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
            echo "<pre>$sub1</pre>";
              //   echo $pos;
                 
          ?>
          </body>
</html>