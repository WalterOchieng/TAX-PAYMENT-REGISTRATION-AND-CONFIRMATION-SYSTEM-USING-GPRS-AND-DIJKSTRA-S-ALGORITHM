<?php
	require("barcode.inc.php");
	//########################//
	// 
	// Authored by Belal for STARTPHP.com
	// Created : Feb 20, 2017 in Ajax, Ontatio, Canada 
	
	// barcode.inc.php barcode class is written by Harish Chauhan
	// 
	
	// How to use:
	// all three files are needed to run and use
	// 1- barcode.inc.pp
	// 2- barcode.php
	// 3- index.php
	//
	// if you website is http://mysite.com
	// then put the above 3 files in a folder called "genbarcode"
	// to call it for genrating the barcode, use http://mysite.com/genbarcode/barcode.php?bdata=MY BARCODE
	//
	// if you barcode is barcode is "Belal 255", use barcode.php?bdata=Belal 255
	// the default barcode format is CODE128
	// look at the commnted lines and change the value to customize it.
	
	
	//########################//

	$bar= new BARCODE();
	
	if($bar==false)
		die($bar->error());
        
        $encode=filter_input(INPUT_GET, 'encode');
        if(empty($encode)){
            $bar->setSymblogy("CODE128");// the barcode value
        }else{
            $bar->setSymblogy($encode); 
        }  

        $bdataPrefix ="";
        $bdataSuffix ="";
	$barnumber=filter_input(INPUT_GET, 'bdata');// barcode data
        $barnumber = $bdataPrefix .$barnumber. $bdataSuffix;
        if(!$barnumber)
            $barnumber="STARTPHP.com";       // the printed data

	
        $height = filter_input(INPUT_GET, 'height');
        
        if(empty($height) && !is_numeric($height)){
            $bar->setHeight(50);
        }else{
           $bar->setHeight($height); 
        } 
        
        $scale = filter_input(INPUT_GET, 'scale');
        if(!$scale)
            $bar->setScale(1);          // scale the barcode or set 1
	$bar->setScale($scale); 
        
        $color = filter_input(INPUT_GET, 'color');
        $bGcolor = filter_input(INPUT_GET, 'bgcolor');
        if(!$color){
              $color ="#333366";          // borcode color
        }
        if(!$bGcolor){
             $bGcolor ="#FFFFFF";       // borcode background color   
        }
        $bar->setHexColor($color,$bGcolor);   

       $imageType= filter_input(INPUT_GET, 'type');        
        if(!$imageType)
            $imageType = "PNG";         // image type, PNG, JPG         

        $fileNamePrefix="";
        $fileNameSuffix="";
        $fileName = filter_input(INPUT_GET, 'file');
        if($fileName){
           // $fileName =$fileNamePrefix.$fileName.$fileNameSuffix;
        }
	        
  	
	$return = $bar->genBarCode($barnumber,$imageType,$fileName);
	if($return==false)
		$bar->error(true);
	
?>