<?php

//$single_answer_type;
// $class_array s-single, m-multiple, i-integer

function ias_model_year_paper($model_year,$paper)


{   

 if(($model_year=="2017") &&($paper=="P1"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18 
	$class_array=array("","m","m","m","m","m","m","m","i","i","i","i","i","s","s","s","s","s","s",
						  "m","m","m","m","m","m","m","i","i","i","i","i","s","s","s","s","s","s",
						  "m","m","m","m","m","m","m","i","i","i","i","i","s","s","s","s","s","s"
	);
	 
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=18;                               //2
	$response_array[]=$total_q=54;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=54;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

    //
    $response_array[]=$this_model_mark_file_string="1,7,4,-2,8,12,3,0,13,18,3,-1,19,25,4,-2,26,30,3,0,31,36,3,-1,37,43,4,-2,44,48,3,0,49,54,3,-1";//5
  
    $response_array[]=$to_from_range="1-18,19-36,37-54";

	return $response_array;  //done
   }
 if(($model_year=="2017") &&($paper=="P2"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9   10  11  12  13  14  15    16  17   18 
	$class_array=array("","s","s","s","s","s","s","s","m","m","m","m","m","m","m","cs","cs","cs","cs",
	                      "s","s","s","s","s","s","s","m","m","m","m","m","m","m","cs","cs","cs","cs",
						  "s","s","s","s","s","s","s","m","m","m","m","m","m","m","cs","cs","cs","cs"
						  
	);
	 
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=18;                               //2
	$response_array[]=$total_q=54;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=54;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;


    $response_array[]=$this_model_mark_file_string="1,7,3,-1,8,14,4,-2,15,18,3,0,19,25,3,-1,26,32,4,-2,33,36,3,0,37,43,3,-1,44,50,4,-2,51,54,3,0";//5
    $response_array[]=$to_from_range="1-18,19-36,37-54";



	return $response_array;  //done
   }


   
 if(($model_year=="2016") &&($paper=="P1"))
   {//doing
	  //                   1   2   3   4   5   6   7   8   9  10   11  12  13  14  15  16  17  18 
	$class_array=array("","s","s","s","s","s","m","m","m","m","m","m","m","m","i","i","i","i","i",
	                      "s","s","s","s","s","m","m","m","m","m","m","m","m","i","i","i","i","i",
						  "s","s","s","s","s","m","m","m","m","m","m","m","m","i","i","i","i","i"
	
	
	                  );
	
	 
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=18;                               //2
	$response_array[]=$total_q=54;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=54;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,5,3,-1,6,13,4,-2,14,18,3,0,19,23,3,-1,24,31,4,-2,32,36,3,0,37,41,3,-1,42,49,4,-2,50,54,3,0";//5
    $response_array[]=$to_from_range="1-18,19-36,37-54";


	return $response_array;
	//return $response_array;  //done  
   }
    if(($model_year=="2016") &&($paper=="P2"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10   11  12  13  14  15   16   17   18 
	$class_array=array("","s","s","s","s","s","s","m","m","m","m","m","m","m","m","cs","cs","cs","cs",
	                      "s","s","s","s","s","s","m","m","m","m","m","m","m","m","cs","cs","cs","cs",
						  "s","s","s","s","s","s","m","m","m","m","m","m","m","m","cs","cs","cs","cs"
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=18;                               //2
	$response_array[]=$total_q=54;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=54;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,6,3,-1,7,14,4,-2,15,18,3,0,19,24,3,-1,25,32,4,-2,33,36,3,0,37,42,3,-1,43,50,4,-2,51,54,3,0";//5
   
    $response_array[]=$to_from_range="1-18,19-36,37-54";
	return $response_array; //done 
   }
       if(($model_year=="2015") &&($paper=="P1"))
   {  // doing //MATRIX BIG.. FIRST
      //                   1   2   3   4   5   6   7   8   9  10   11  12  13  14  15 16  17  18   19   20   21   22   23   24   25   26
	$class_array=array("","i","i","i","i","i","i","i","i","m","m","m","m","m","m","m","m","m","m","mb","mb","mb","mb","mb","mb","mb","mb",
	                      "i","i","i","i","i","i","i","i","m","m","m","m","m","m","m","m","m","m","mb","mb","mb","mb","mb","mb","mb","mb",
						  "i","i","i","i","i","i","i","i","m","m","m","m","m","m","m","m","m","m","mb","mb","mb","mb","mb","mb","mb","mb"
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=26;                               //2
	$response_array[]=$total_q=78;                                                  //3
	$this_question_number_array=array();
	for($a=1;$a<=18;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="19a";$this_question_number_array[]="19b";$this_question_number_array[]="19c";$this_question_number_array[]="19d";
	$this_question_number_array[]="20a";$this_question_number_array[]="20b";$this_question_number_array[]="20c";$this_question_number_array[]="20d";
	
	for($a=21;$a<=38;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="39a";$this_question_number_array[]="39b";$this_question_number_array[]="39c";$this_question_number_array[]="39d";
	$this_question_number_array[]="40a";$this_question_number_array[]="40b";$this_question_number_array[]="40c";$this_question_number_array[]="40d";
	
	for($a=41;$a<=58;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="59a";$this_question_number_array[]="59b";$this_question_number_array[]="59c";$this_question_number_array[]="59d";
	$this_question_number_array[]="60a";$this_question_number_array[]="60b";$this_question_number_array[]="60c";$this_question_number_array[]="60d";
	
	$response_array[]=$this_question_number_array;

		$response_array[]=$this_model_mark_file_string="1,8,4,0,9,18,4,-2,19,26,2,-1,27,34,4,0,35,44,4,-2,45,52,2,-1,53,60,4,0,61,70,4,-2,71,78,2,-1";//5



	$response_array[]=$to_from_range="1-26,27-52,53-78";
	return $response_array; //done
   }
   
       if(($model_year=="2015") &&($paper=="P2"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10   11  12  13  14  15 16   17   18   19   20
	$class_array=array("","i","i","i","i","i","i","i","i","m","m","m","m","m","m","m","m","cm","cm","cm","cm",
	                      "i","i","i","i","i","i","i","i","m","m","m","m","m","m","m","m","cm","cm","cm","cm",
						  "i","i","i","i","i","i","i","i","m","m","m","m","m","m","m","m","cm","cm","cm","cm"
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=20;                               //2
	$response_array[]=$total_q=60;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=60;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;


	$response_array[]=$this_model_mark_file_string="1,8,4,0,9,16,4,-2,17,20,4,-2,21,28,4,0,29,36,4,-2,37,40,4,-2,41,48,4,0,49,56,4,-2,57,60,4,-2";//5


    $response_array[]=$to_from_range="1-20,21-40,41-60";
	return $response_array; //done 
   }
          if(($model_year=="2014") &&($paper=="P1"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10   11  12  13  14  15 16  17  18  19  20
	$class_array=array("","m","m","m","m","m","m","m","m","m","m","i","i","i","i","i","i","i","i","i","i",
	                      "m","m","m","m","m","m","m","m","m","m","i","i","i","i","i","i","i","i","i","i",
						  "m","m","m","m","m","m","m","m","m","m","i","i","i","i","i","i","i","i","i","i"
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=20;                               //2
	$response_array[]=$total_q=60;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=60;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,10,3,0,11,20,3,0,21,30,3,0,31,40,3,0,41,50,3,0,51,60,3,0";//5
   
    $response_array[]=$to_from_range="1-20,21-40,41-60";
	return $response_array; //done
   }
             if(($model_year=="2014") &&($paper=="P2"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10   11   12   13   14   15   16   17   18   19   20
	$class_array=array("","s","s","s","s","s","s","s","s","s","s","cs","cs","cs","cs","cs","cs","ms","ms","ms","ms",
						  "s","s","s","s","s","s","s","s","s","s","cs","cs","cs","cs","cs","cs","ms","ms","ms","ms",
						  "s","s","s","s","s","s","s","s","s","s","cs","cs","cs","cs","cs","cs","ms","ms","ms","ms"
	                      
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=20;                               //2
	$response_array[]=$total_q=60;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=60;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,10,3,-1,11,16,3,-1,17,20,3,-1,21,30,3,-1,31,36,3,-1,37,40,3,-1,41,50,3,-1,51,56,3,-1,57,60,3,-1";//5


    $response_array[]=$to_from_range="1-20,21-40,41-60";
	return $response_array; //done
   }
                if(($model_year=="2013") &&($paper=="P1"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20
	$class_array=array("","s","s","s","s","s","s","s","s","s","s","m","m","m","m","m","i","i","i","i","i",
						  "s","s","s","s","s","s","s","s","s","s","m","m","m","m","m","i","i","i","i","i",
						  "s","s","s","s","s","s","s","s","s","s","m","m","m","m","m","i","i","i","i","i"
	                      
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=20;                               //2
	$response_array[]=$total_q=60;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=60;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,10,2,0,11,15,4,-1,16,20,4,-1,21,30,2,0,31,35,4,-1,36,40,4,-1,41,50,2,0,51,55,4,-1,56,60,4,-1";//5

    $response_array[]=$to_from_range="1-20,21-40,41-60";
	return $response_array; //done
   }
                   if(($model_year=="2013") &&($paper=="P2"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9    10   11   12   13  14   15    16  17    18   19   20
	$class_array=array("","m","m","m","m","m","m","m","m","cs","cs","cs","cs","cs","cs","cs","cs","ms","ms","ms","ms",
						  "m","m","m","m","m","m","m","m","cs","cs","cs","cs","cs","cs","cs","cs","ms","ms","ms","ms",
						  "m","m","m","m","m","m","m","m","cs","cs","cs","cs","cs","cs","cs","cs","ms","ms","ms","ms"
	                      
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=20;                               //2
	$response_array[]=$total_q=60;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=60;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,8,3,-1,9,16,3,-1,17,20,3,-1,21,28,3,-1,29,36,3,-1,37,40,3,-1,41,48,3,-1,49,56,3,-1,57,60,3,-1";//5


    $response_array[]=$to_from_range="1-20,21-40,41-60";
	return $response_array; //done
   }
                      if(($model_year=="2012") &&($paper=="P1"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10  11  12  13  14  15  16  17  18  19  20
	$class_array=array("","s","s","s","s","s","s","s","s","s","s","m","m","m","m","m","i","i","i","i","i",
						  "s","s","s","s","s","s","s","s","s","s","m","m","m","m","m","i","i","i","i","i",
						  "s","s","s","s","s","s","s","s","s","s","m","m","m","m","m","i","i","i","i","i"
	                      
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=20;                               //2
	$response_array[]=$total_q=60;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=60;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,10,3,-1,11,15,4,0,16,20,4,0,21,30,3,-1,31,35,4,0,36,40,4,0,41,50,3,-1,51,55,4,0,56,60,4,0";//5


    $response_array[]=$to_from_range="1-20,21-40,41-60";
	return $response_array; //done
   }
          if(($model_year=="2012") &&($paper=="P2"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9    10   11   12   13   14  15  16  17  18  19   20
	$class_array=array("","s","s","s","s","s","s","s","s","cs","cs","cs","cs","cs","cs","m","m","m","m","m","m",
						  "s","s","s","s","s","s","s","s","cs","cs","cs","cs","cs","cs","m","m","m","m","m","m",
						  "s","s","s","s","s","s","s","s","cs","cs","cs","cs","cs","cs","m","m","m","m","m","m"
						
	                      
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","PHYSICS","CHEMISTRY","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=20;                               //2
	$response_array[]=$total_q=60;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=60;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,8,3,-1,9,14,3,-1,15,20,4,0,21,28,3,-1,29,34,3,-1,35,40,4,0,41,48,3,-1,49,54,3,-1,55,60,4,0";//5

    $response_array[]=$to_from_range="1-20,21-40,41-60";
	return $response_array; //done
   }




             if(($model_year=="2011") &&($paper=="P1"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10  11   12   13   14   15   16  17  18  19  20   21  22  23
	$class_array=array("","s","s","s","s","s","s","s","m","m","m","m","cs","cs","cs","cs","cs","i","i","i","i","i","i","i",
						  "s","s","s","s","s","s","s","m","m","m","m","cs","cs","cs","cs","cs","i","i","i","i","i","i","i",
						  "s","s","s","s","s","s","s","m","m","m","m","cs","cs","cs","cs","cs","i","i","i","i","i","i","i"
						 
						
	                      
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","CHEMISTRY","PHYSICS","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=23;                               //2
	$response_array[]=$total_q=69;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=69;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,7,3,-1,8,11,4,0,12,16,3,-1,17,23,4,0,24,30,3,-1,31,34,4,0,35,39,3,-1,40,46,4,0,47,53,3,-1,54,57,4,0,58,62,3,-1,63,69,4,0";//5


    $response_array[]=$to_from_range="1-23,24-46,47-69";
	return $response_array; //done
   }





                if(($model_year=="2011") &&($paper=="P2"))
   { 

// doing //MATRIX BIG.. SECOND
      //                   1   2   3   4   5   6   7   8   9  10   11  12  13  14  15 16  17  18   19   20   21   22   23   24   25   26
	$class_array=array("","s","s","s","s","s","s","s","s","m","m","m","m","i","i","i","i","i","i","mb","mb","mb","mb","mb","mb","mb","mb",
	                      "s","s","s","s","s","s","s","s","m","m","m","m","i","i","i","i","i","i","mb","mb","mb","mb","mb","mb","mb","mb",
						  "s","s","s","s","s","s","s","s","m","m","m","m","i","i","i","i","i","i","mb","mb","mb","mb","mb","mb","mb","mb"
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","CHEMISTRY","PHYSICS","MATHEMATICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=26;                               //2
	$response_array[]=$total_q=78;                                                  //3
	$this_question_number_array=array();
	for($a=1;$a<=18;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="19a";$this_question_number_array[]="19b";$this_question_number_array[]="19c";$this_question_number_array[]="19d";
	$this_question_number_array[]="20a";$this_question_number_array[]="20b";$this_question_number_array[]="20c";$this_question_number_array[]="20d";
	
	for($a=21;$a<=38;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="39a";$this_question_number_array[]="39b";$this_question_number_array[]="39c";$this_question_number_array[]="39d";
	$this_question_number_array[]="40a";$this_question_number_array[]="40b";$this_question_number_array[]="40c";$this_question_number_array[]="40d";
	
	for($a=41;$a<=58;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="59a";$this_question_number_array[]="59b";$this_question_number_array[]="59c";$this_question_number_array[]="59d";
	$this_question_number_array[]="60a";$this_question_number_array[]="60b";$this_question_number_array[]="60c";$this_question_number_array[]="60d";
	
	$response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,8,3,-1,9,12,4,0,13,18,4,0,19,26,2,0,27,34,3,-1,35,38,4,0,39,44,4,0,45,52,2,0,53,60,3,-1,61,64,4,0,65,70,4,0,71,78,2,0";//5


	$response_array[]=$to_from_range="1-26,27-52,53-78";
	return $response_array; //done
   }
                if(($model_year=="2010") &&($paper=="P1"))
   { //doing
	  //                   1   2   3   4   5   6   7   8   9  10  11   12  13  14   15  16   17   18   19  20  21  22  23   24  25  26  27  28
	$class_array=array("","s","s","s","s","s","s","s","s","m","m","m","m","m","cs","cs","cs","cs","cs","i","i","i","i","i","i","i","i","i","i",
					      "s","s","s","s","s","s","s","s","m","m","m","m","m","cs","cs","cs","cs","cs","i","i","i","i","i","i","i","i","i","i",
						  "s","s","s","s","s","s","s","s","m","m","m","m","m","cs","cs","cs","cs","cs","i","i","i","i","i","i","i","i","i","i"
	      
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","CHEMISTRY","MATHEMATICS","PHYSICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=28;                               //2
	$response_array[]=$total_q=84;                                                  //3
	$this_question_number_array=array();for($a=1;$a<=84;$a++) {$this_question_number_array[]=$a;} $response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,8,3,-1,9,13,3,0,14,18,3,-1,19,28,3,0,29,36,3,-1,37,41,3,0,42,46,3,-1,47,56,3,0,57,64,3,-1,65,69,3,0,70,74,3,-1,75,84,3,0";//5


    $response_array[]=$to_from_range="1-28,29-56,57-84";
	return $response_array; //done
   }
   
   
   
               if(($model_year=="2010") &&($paper=="P2"))
   {
	   
	    // doing //MATRIX BIG.. THIRD
      //                   1   2   3   4   5   6   7   8   9  10   11  12   13   14  15   16    17   18   19   20   21   22   23   24   25   
	$class_array=array("","s","s","s","s","s","s","i","i","i","i","i","cs","cs","cs","cs","cs","cs","mb","mb","mb","mb","mb","mb","mb","mb",
	                      "s","s","s","s","s","s","i","i","i","i","i","cs","cs","cs","cs","cs","cs","mb","mb","mb","mb","mb","mb","mb","mb",
						  "s","s","s","s","s","s","i","i","i","i","i","cs","cs","cs","cs","cs","cs","mb","mb","mb","mb","mb","mb","mb","mb"
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","CHEMISTRY","MATHEMATICS","PHYSICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=25;                               //2
	$response_array[]=$total_q=75;                                                  //3
	$this_question_number_array=array();
	for($a=1;$a<=17;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="18a";$this_question_number_array[]="18b";$this_question_number_array[]="18c";$this_question_number_array[]="18d";
	$this_question_number_array[]="19a";$this_question_number_array[]="19b";$this_question_number_array[]="19c";$this_question_number_array[]="19d";

	
	for($a=20;$a<=36;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="37a";$this_question_number_array[]="37b";$this_question_number_array[]="37c";$this_question_number_array[]="37d";
	$this_question_number_array[]="38a";$this_question_number_array[]="38b";$this_question_number_array[]="38c";$this_question_number_array[]="38d";
	
	for($a=39;$a<=55;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="56a";$this_question_number_array[]="56b";$this_question_number_array[]="56c";$this_question_number_array[]="56d";
	$this_question_number_array[]="57a";$this_question_number_array[]="57b";$this_question_number_array[]="57c";$this_question_number_array[]="57d";
	
	$response_array[]=$this_question_number_array;

		$response_array[]=$this_model_mark_file_string="1,6,5,-2,7,11,3,0,12,17,3,-1,18,25,2,0,26,31,5,-2,32,36,3,0,37,42,3,-1,43,50,2,0,51,56,5,-2,57,61,3,0,62,67,3,-1,68,75,2,0";//5

	$response_array[]=$to_from_range="1-25,26-50,51-75";
	return $response_array; //done
   }
   
   if(($model_year=="2009") &&($paper=="P1"))
   { 

// doing //MATRIX BIG.. FOURTH
      //                   1   2   3   4   5   6   7   8   9  10   11  12  13   14   15  16   17   18    19   20   21   22   23   24   25   26
	$class_array=array("","s","s","s","s","s","s","s","s","m","m","m","m","cs","cs","cs","cs","cs","cs","mb","mb","mb","mb","mb","mb","mb","mb",
	                      "s","s","s","s","s","s","s","s","m","m","m","m","cs","cs","cs","cs","cs","cs","mb","mb","mb","mb","mb","mb","mb","mb",
						  "s","s","s","s","s","s","s","s","m","m","m","m","cs","cs","cs","cs","cs","cs","mb","mb","mb","mb","mb","mb","mb","mb"
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","CHEMISTRY","MATHEMATICS","PHYSICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=26;                               //2
	$response_array[]=$total_q=78;                                                  //3
	$this_question_number_array=array();
	for($a=1;$a<=18;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="19a";$this_question_number_array[]="19b";$this_question_number_array[]="19c";$this_question_number_array[]="19d";
	$this_question_number_array[]="20a";$this_question_number_array[]="20b";$this_question_number_array[]="20c";$this_question_number_array[]="20d";
	
	for($a=21;$a<=38;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="39a";$this_question_number_array[]="39b";$this_question_number_array[]="39c";$this_question_number_array[]="39d";
	$this_question_number_array[]="40a";$this_question_number_array[]="40b";$this_question_number_array[]="40c";$this_question_number_array[]="40d";
	
	for($a=41;$a<=58;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="59a";$this_question_number_array[]="59b";$this_question_number_array[]="59c";$this_question_number_array[]="59d";
	$this_question_number_array[]="60a";$this_question_number_array[]="60b";$this_question_number_array[]="60c";$this_question_number_array[]="60d";
	
	$response_array[]=$this_question_number_array;

	$response_array[]=$this_model_mark_file_string="1,8,3,-1,9,12,4,-1,13,18,4,-1,19,26,2,0,27,34,3,-1,35,38,4,-1,39,44,4,-1,45,52,2,0,53,60,3,-1,61,64,4,-1,65,70,4,-1,71,78,2,0";//5


	$response_array[]=$to_from_range="1-26,27-52,53-78";
	return $response_array; //done
   }


   if(($model_year=="2009") &&($paper=="P2"))
   { 

// doing //MATRIX BIG.. FIFTH
      //                   1   2   3   4   5   6   7   8   9   10   11   12   13   14   15  16    17  18  19  20  21  22  23  24  25  
	$class_array=array("","s","s","s","s","m","m","m","m","m","mb","mb","mb","mb","mb","mb","mb","mb","i","i","i","i","i","i","i","i",
	                      "s","s","s","s","m","m","m","m","m","mb","mb","mb","mb","mb","mb","mb","mb","i","i","i","i","i","i","i","i",
						  "s","s","s","s","m","m","m","m","m","mb","mb","mb","mb","mb","mb","mb","mb","i","i","i","i","i","i","i","i"
	                   );
	$response_array=array(); 
	$response_array[]=$sub_array=array("0","CHEMISTRY","MATHEMATICS","PHYSICS");    //0
	$response_array[]=$class_array;                                                 //1
	$response_array[]=$no_of_question_per_section=25;                               //2
	$response_array[]=$total_q=75;                                                  //3
	$this_question_number_array=array();
	for($a=1;$a<=9;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="10a";$this_question_number_array[]="10b";$this_question_number_array[]="10c";$this_question_number_array[]="10d";
	$this_question_number_array[]="11a";$this_question_number_array[]="11b";$this_question_number_array[]="11c";$this_question_number_array[]="11d";
	
	for($a=12;$a<=28;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="29a";$this_question_number_array[]="29b";$this_question_number_array[]="29c";$this_question_number_array[]="29d";
	$this_question_number_array[]="30a";$this_question_number_array[]="30b";$this_question_number_array[]="30c";$this_question_number_array[]="30d";
	
	for($a=31;$a<=47;$a++) {$this_question_number_array[]=$a;};
	$this_question_number_array[]="48a";$this_question_number_array[]="48b";$this_question_number_array[]="48c";$this_question_number_array[]="48d";
	$this_question_number_array[]="49a";$this_question_number_array[]="49b";$this_question_number_array[]="49c";$this_question_number_array[]="49d";
	
	for($a=50;$a<=57;$a++) {$this_question_number_array[]=$a;};
	
	$response_array[]=$this_question_number_array;


  $response_array[]=$this_model_mark_file_string="1,4,3,-1,5,9,4,-1,10,17,2,0,18,25,4,-1,26,29,3,-1,30,34,4,-1,35,42,2,0,43,50,4,-1,51,54,3,-1,55,59,4,-1,60,67,2,0,68,75,4,-1";//5


	$response_array[]=$to_from_range="1-25,26-50,51-75";
	return $response_array; //done
   }
   
}//fun end



?>