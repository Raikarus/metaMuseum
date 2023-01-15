  <html>
        <body>
                 VAN DARCHOLM <BR>
         <?php

         $tag = "Artist";
         $var = "<rdf:Description rdf:about='20221225-2837_ss.jpg'
                  xmlns:et='http://ns.exiftool.ca/1.0/' et:toolkit='Image::ExifTool 12.16'
                  xmlns:IFD0='http://ns.exiftool.ca/EXIF/IFD0/1.0/'>
                 <IFD0:Artist>GAY1</IFD0:Artist>
                </rdf:Description>
                </rdf:RDF>";

          $pos = substr($var,strpos($var, $tag) + strlen($tag) + 1,strpos($var, $tag+'>'));

          $sub = substr($pos,strpos($var, '>'),strpos($var, '1'));
                 echo $pos;
                 echo $sub;
          ?>
          </body>
</html>