<?php

namespace PaymentLibrary\Core;

use Error;

class Utils{
    public static function env($ENV){
        $filePath = __DIR__."/../../.env";

        if(file_exists($filePath)){
            $variables_array = [];
            $fopen = fopen($filePath, 'r');
            if($fopen){
                //Loop the lines of the file
                while (($line = fgets($fopen)) !== false){
                    // Check if line is a comment
                    $line_is_comment = (substr(trim($line),0 , 1) == '#') ? true: false;
                    // If line is a comment or empty, then skip
                    if($line_is_comment || empty(trim($line))){
                        continue;
                    }
                    
         
                    // Split the line variable and succeeding comment on line if exists
                    $line_no_comment = explode("#", $line, 2)[0];
                    // Split the variable name and value
                    $env_ex = preg_split('/(\s?)\=(\s?)/', $line_no_comment);
                    $env_name = trim($env_ex[0]);
                    $env_value = isset($env_ex[1]) ? trim($env_ex[1]) : "";
                    $variables_array[$env_name] = $env_value;
                }
                // Close the file
                fclose($fopen);

                foreach($variables_array as $name => $value){
                    if($ENV === $name){
                        return $value;
                    }
                }
            }
        } else {
            echo "Le fichier .env n'existe pas.";
        }
    }
}