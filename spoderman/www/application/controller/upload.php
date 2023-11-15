<?php
function upload($dataPath, $fleName='fleName', $bef=''){
$tempFiles=$_FILES[$fleName]['tmp_name'];
if($tempFiles[0] != ""){
	for($file=0; $file<count($tempFiles); $file++){
		$fileName=$bef . basename($_FILES[$fleName]['name'][$file]);
                $filePath=$dataPath . '/' . $fileName;
                if(move_uploaded_file($tempFiles[$file], $filePath)){

                }
        }
}
}
?>
