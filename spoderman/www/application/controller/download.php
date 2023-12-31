<?php
function download($file, $name, $mime_type='')
{
 if(!is_readable($file))
    {
        echo "File is not readable!";
        return;
    }

 $size = filesize($file);
 $name = rawurldecode($name);
 $known_mime_types=array(
        "pdf" => "application/pdf",
        /*"txt" => "text/plain",
        "html" => "text/html",
        "htm" => "text/html",*/
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg"=> "image/jpg",
        "jpg" =>  "image/jpg",
        //"php" => "text/plain"
 );
 if($mime_type==''){
         $file_extension = strtolower(substr(strrchr($file,"."),1));
         if(array_key_exists($file_extension, $known_mime_types)){
                $mime_type=$known_mime_types[$file_extension];
         } else {
                $mime_type="application/force-download";
         };
 };
 @ob_end_clean();//turn off output buffering to decrease cpu usage
 if(ini_get('zlib.output_compression'))// required for IE, otherwise Content-Disposition may be ignored
  ini_set('zlib.output_compression', 'Off');
 header('Content-Type: ' . $mime_type);
 header('Content-Disposition: attachment; filename="'.$name.'"');
 header("Content-Transfer-Encoding: binary");
 header('Accept-Ranges: bytes');
 header("Cache-control: private");
 header('Pragma: private');
 //header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 if(isset($_SERVER['HTTP_RANGE']))// multipart-download and download resuming support
 {
        list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
        list($range) = explode(",",$range,2);
        list($range, $range_end) = explode("-", $range);
        $range=intval($range);
if(!$range_end) {
                $range_end=$size-1;
        } else {
                $range_end=intval($range_end);  }
        $new_length = $range_end-$range+1;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range-$range_end/$size");
 } else {
        $new_length=$size;
        header("Content-Length: ".$size); }
 $chunksize = 1*(1024*1024); //may want to change this
 $bytes_send = 0;
 if ($file = fopen($file, 'r'))
 {
        if(isset($_SERVER['HTTP_RANGE']))
        fseek($file, $range);

        while(!feof($file) &&
                (!connection_aborted()) &&
                ($bytes_send<$new_length)
              )
        {
                $buffer = fread($file, $chunksize);
                print($buffer); //echo($buffer); // can also possible
                flush();
                $bytes_send += strlen($buffer);
        }
 fclose($file);
 } else{//If no permision
 header('location:error.html'); }
}
?>
