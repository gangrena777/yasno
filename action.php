 <?php
	
include('db.php');

      if(isset($_GET['deals']) ){
        $data = json_decode($_GET['deals'], false);
           if($data->deals =='all'){
          
          $sql = "SELECT  * FROM  todolist";
          $res = mysqli_query($link, $sql);

          if(mysqli_num_rows($res)>0) 
          {
          	
            $row = mysqli_fetch_array($res);
            $list= array();

          	   do{
         
              $list[] = $row;
                  } 
                while($row = mysqli_fetch_array($res));
                $list['avaible'] = true;
         
               echo  json_encode($list);

         }
         else{
                    $list['avaible'] = false;
         
               echo  json_encode($list);
         }
        


     }
}

     /// ////////////////////////
    
       /// add begin/////

  if(isset($_GET['new_deal'])) {

       $data = json_decode($_GET['new_deal'], false);
     
         if($data->name !==''){
           $name = htmlspecialchars($data->name);
         }
         if($data->description !==''){
           $description = htmlspecialchars($data->description);
         }
          if($data->phone !==''){
        $phone = htmlspecialchars($data->phone);
         }
         $date_create = date("d.m.y") ;
       
      $sqll = "INSERT INTO todolist (`date_create`,`name`, `description`,`phone`) VALUES ('".$date_create."','".$name."', '".$description."', '".$phone."')";
    
      $ress = mysqli_query($link, $sqll);

       if($ress){
      
                          $message = ["message"=>"New deal was seccessfuly add",
                                      "status"=>"dark"];
                           echo json_encode($message);
             
        }
        else{
     

                          

                           $message = ["message"=>"Problem with adding",
                                      "status"=>"danger"];
                           echo json_encode($message);
       }

  }
////// add end /////

	////edit begin ///// 

if(isset($_GET['edit_deal'])){
       $data = json_decode($_GET['edit_deal'], false);

         if(!empty($data->id)){
          $id = $data->id;
         }

         if($data->name !==''){
           $name = htmlspecialchars($data->name);
         }
         if($data->description !==''){
           $sections = htmlspecialchars($data->description);
         }
          if($data->phone !==''){
        $phone = htmlspecialchars($data->phone);
         }
            if($data->date_create !==''){
        $date_create = htmlspecialchars($data->date_create);
         }

          $sqll = "UPDATE todolist SET `name` ='".$name."', `description` ='".$sections."', phone='".$phone."' , date_create='".$date_create."' WHERE id ='".$id."' ";

    
         $resss = mysqli_query($link, $sqll);
         if($resss){

                 $message = ["message"=>"Info about deal was seccessfuly edit",
                                             "status"=>"dark"];
                                               echo json_encode($message); 
    
         }
         else{

                 $message = ["message"=>"Promlem with edit",
                                             "status"=>"danger"];
                                               echo json_encode($message); 
    
        }

}

/////edit end /////

	//////del begin /////
     
	    if(isset($_GET['del_id'])){
           $data = json_decode($_GET['del_id'], false);
                 if($data->del_id !=='')
                 {
                     $id = $data->del_id;
                  }   
                     $sqll = "DELETE  FROM todolist  WHERE id ='$id'";
                     $ress = mysqli_query($link, $sqll);
                    if($ress){
                                 $message = ["message"=>"Info about deal was seccessfuly delete",
                                             "status"=>"dark"];
                                               echo json_encode($message); 
                               }
                  else{
                                 $message = ["message"=>"Promlem with delete",
                                             "status"=>"danger"];
                                               echo json_encode($message); 
                       }
                  
       }
	/////del end//////

  //////filter begin /////
     
      if(isset($_GET['filter_deal'])){
           $data = json_decode($_GET['filter_deal'], false);
         
             $str = '';
         
                  if($data->phone !=='' && $data->date_create_from =='' && $data->date_create_to ==''){
                    $phone = htmlspecialchars($data->phone);
                    $str .=" WHERE phone='".$phone."'";
                  }
                  if($data->phone !=='' && $data->date_create_from !=='' && $data->date_create_to =='' ){
                    
                    $phone = htmlspecialchars($data->phone);
                    $date_create_from = htmlspecialchars($data->date_create_from);
                    $str .=" WHERE phone='".$phone."' AND date_create >='".$date_create_from."'";
                  }

                  if($data->phone !=='' && $data->date_create_from !=='' && $data->date_create_to !=='' ){
                    
                    $phone = htmlspecialchars($data->phone);
                    $date_create_from = htmlspecialchars($data->date_create_from);
                    $date_create_to = htmlspecialchars($data->date_create_to);
                    $str .=" WHERE phone='".$phone."' AND  date_create  BETWEEN  '".$date_create_from."' AND '".$date_create_to."'";
                  }

                  if($data->phone !=='' && $data->date_create_from =='' && $data->date_create_to !=='' ){

                    $phone = htmlspecialchars($data->phone);
                    $date_create_from = htmlspecialchars($data->date_create_to);
                    $str .=" WHERE phone='".$phone."' AND date_create <='".$date_create_to."'";

                  }


                  if($data->phone =='' && $data->date_create_from !=='' && $data->date_create_to !=='' ){
                    
                  
                    $date_create_from = htmlspecialchars($data->date_create_from);
                    $date_create_to = htmlspecialchars($data->date_create_to);
                    $str .=" WHERE date_create  BETWEEN  '".$date_create_from."' AND '".$date_create_to."'";
                  }

                  if($data->phone =='' && $data->date_create_from !=='' && $data->date_create_to  =='' ){
                    $date_create_from = htmlspecialchars($data->date_create_from);
                    $str .=" WHERE  date_create >='".$date_create_from."'";
                  }
                  if($data->phone =='' && $data->date_create_from =='' && $data->date_create_to  !=='' ){
                    $date_create_to = htmlspecialchars($data->date_create_to);
                    $str .=" WHERE  date_create <='".$date_create_to."'";
                  }

                
                 
                     $sqlll = "SELECT * FROM todolist  $str";
                
                     $res = array();

                     $ress = mysqli_query($link, $sqlll);


                          if(mysqli_num_rows($ress)>0) 
                          {

                              $row = mysqli_fetch_array($ress);
                              

                             do{

                                  $res[] = $row;
                                } 
                                while($row = mysqli_fetch_array($ress));
                                  $res['avaible'] = true;

                                  echo  json_encode($res);

                          }
                          // else{
                          //     $res['avaible'] = false;

                          //     echo  json_encode($res);
                          // }
                  
       }
  /////filter end//////

?>