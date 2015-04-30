<?php
	require_once("includes/settings.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/employee.class.php");
	$objSale = new sale();
	$objEmployee = new employee();

	$ModuleName = "Sales Commission Report";
	if(empty($_GET['y']))$_GET['y'] = date("Y");
			

	if($_SESSION['AdminType'] != "admin"){ 
		$EmpID = $_SESSION["AdminID"]; $EmpDivision = 5;
		$arryEmp = $objEmployee->GetEmployeeBrief($EmpID);
		for($i=1;$i<=12;$i++) {
			$mon = $i; if($mon<10) $mon = '0'.$i;
			$FromDate = $_GET['y'].'-'.$mon.'-01';
			$ToDate = $_GET['y'].'-'.$mon.'-31';
			$MonthName = date("F",strtotime($FromDate));
			if($arryEmp[0]['CommOn']==1){
				include("includes/html/box/commission_cal_per.php");
			}else{
				include("includes/html/box/commission_cal.php");
			}
			if($TotalCommission<=0) $TotalCommission='';
			$valuesBar[$MonthName] = $TotalCommission;

		}
		

	}else{
		exit;
	}

 	//echo '<pre>';print_r($valuesBar);exit;	



		//image filed
		 $img_width=385;
		 $img_height=250;
		 $BotTextHeight = 40;
		//border margins
		 $margins=30;
		 $ymargin=30;

		 $graph_width=$img_width - $margins * 2;
		 $graph_height=$img_height - $margins * 2; 
		 
		 $img=imagecreate($img_width,$img_height);
		 
		 $bar_width=20;
		 $total_bars=count($valuesBar);
		 $gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1); 
		 
		 $bar_color=imagecolorallocate($img,102,102,102);
		 $background_color=imagecolorallocate($img,240,240,255);
		 $border_color=imagecolorallocate($img,255,255,255);
		 $line_color=imagecolorallocate($img,220,220,220); 
		 

		$bag_color=imagecolorallocate($img,255,255,255);//Baground color
$xyline_color=imagecolorallocate($img,135,135,135);//XY-axis color

$bar_color=imagecolorallocate($img,123,172,172);//Yellow color


$bar_color_arry[0]=imagecolorallocate($img,0,80,123);//Blue color
$bar_color_arry[1]=imagecolorallocate($img,123,172,172);//Sky color
$bar_color_arry[2]=imagecolorallocate($img,0,123,0);//Green color
$bar_color_arry[3]=imagecolorallocate($img,172,0,0);//Red color
$bar_color_arry[4]=imagecolorallocate($img,123,172,172);//Sky color
$bar_color_arry[5]=imagecolorallocate($img,172,212,123);//Yellow color


$txt_color=imagecolorallocate($img,211,63,63);//text color
$line_color=imagecolorallocate($img,157,176,134); 
$values_color=imagecolorallocate($img,73,86,58);//values color


		 imagefilledrectangle($img,0,0,$img_width,$img_height+20,$bag_color);
		 #imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
		 
        $LineHeight = $img_height-$margins-$ymargin;
		imageline($img,$margins,$LineHeight,$img_width-$ymargin,$LineHeight,$xyline_color);
		imageline($img,$margins,2,$margins,$LineHeight,$xyline_color);
		imageline($img,$img_width-$ymargin,2,$img_width-$ymargin,$LineHeight,$xyline_color);


		 $max_value=(max($valuesBar)>5000)?(max($valuesBar)):(5000); 
		 $ratio= $graph_height/$max_value; 
		 
		 $horizontal_lines=10;
		 $LineHeight=$LineHeight+5;
		 $horizontal_gap=$graph_height/$horizontal_lines;
		 for($i=1;$i<=$horizontal_lines;$i++){
			$y=$LineHeight - 4 - $horizontal_gap * $i ;
			imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
			$v=intval($horizontal_gap * $i /$ratio);
			imagestring($img,0,0,$y,$v,$values_color);
		 }
		 $ymargin = $ymargin;
		 for($i=0;$i< $total_bars; $i++){
			list($key,$value)=each($valuesBar);
			$x1= $margins + $gap + $i * ($gap+$bar_width) ;
			$x2= $x1 + $bar_width;
			$y1=($margins +$graph_height- intval($value * $ratio))-$ymargin ;
			$y2=($img_height-$margins)-$ymargin;
			
			$rem = ceil($value/20);

			$c++; if($c==6) $c=0;
			$rand_no = rand(0,5);

			if($value>0){
				imagefilledrectangle($img,$x1+3,$y1,$x2,$y2,$bar_color_arry[$rand_no]);
			}
			imagestringup($img,0,$x1+8,$y1-10,$value,$values_color);
			imagestringup($img,0,$x1+7,$img_height-10,substr($key,0,10),$values_color);

		} 
		

			imagestring($img,2,$img_width-50,2, $Config['Currency'], $txt_color);


			header("Content-type:image/png");
			imagepng($img);

?>
