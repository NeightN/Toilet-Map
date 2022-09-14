<?php

//set parameters
if (isset($_POST["jmeno"]) && $_POST["coords"])
{
    $jmeno = $_POST["jmeno"];
    $coords = $_POST["coords"];

    if(isset($_POST["cena"]) && $_POST["cena"] != "")
    {
        $cena = $_POST["cena"];
    } 
    else
    {
        $cena = 0;
    }
    
    $toWrite = $jmeno.','.$cena.','.$coords;

//    echo ($toWrite);

    $samplefile = fopen("data.csv", "a");  
    fwrite($samplefile, "\n".$toWrite); 
    fclose($samplefile);

}


$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}

    header("Location: " . $previous);
    exit();


?>