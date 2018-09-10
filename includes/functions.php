<?  
function getUsername($userid){
    
    global $db;
        $newU = "SELECT * FROM members WHERE memberID = '$userid'";
        $stmtU = $db->prepare($newU);
        $stmtU-> execute();
        $rowU = $stmtU->fetch();
        
        return $rowU["username"];		
	}

function getAvatar($userid){
    global $db;
    
    $newU = "SELECT * FROM members WHERE memberID = '$userid'";
    $stmtU = $db->prepare($newU);
    $stmtU-> execute();
    $rowU = $stmtU->fetch();
    
    $avatar = $rowU["avatar"];
    
    
    
    return $avatar;
}
function dollar($dollar){
    
    setlocale(LC_MONETARY, 'en_US');
    $new_euro = money_format('%(#10n', $dollar);
    return $new_euro;
}

function euro($euro){
    setlocale(LC_MONETARY, 'nl_NL.UTF-8');
    $new_euro = money_format('%(#1n', $euro);
    
    return $new_euro;
}


function infoCoin($infoLink){
   
        $curl = curl_init();
                            
                                    

         curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.coinmarketcap.com/v1/ticker/".$infoLink."/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",

        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response_code = json_decode($response, true);
        return $response_code;
}

function historyPrice($fsym, $tsym, $timestamp){
   
          $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://min-api.cryptocompare.com/data/pricehistorical?fsym=".$fsym."&tsyms=".$tsym."&ts=".$timestamp."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $response_code = json_decode($response, true);
    return $response_code[$fsym][$tsym];
}

function currentPrice($fsym, $tsym){   
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://min-api.cryptocompare.com/data/price?fsym=".$fsym."&tsyms=".$tsym."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $response_code = json_decode($response, true);
    return $response_code[$tsym];
}

function getPercentage($nieuw, $oud){
    
   $percentage = (($nieuw - $oud) / $oud) * 100;
    return number_format($percentage, 2);
    
}




  //login function 

  

    
  /*add new post if user post 
  public function add_post($user_id,$status,$file_parh){
   global $pdo; 
   if(empty($file_parh)){
    $file_parh = 'NULL';
   }
   $query = $pdo->prepare('INSERT INTO `posts` (`post_id`, `user_id_p`, `status`, `status_image`, `status_time`) VALUES (NULL, ?, ?,?,  CURRENT_TIMESTAMP)');
   $query->bindValue(1,$user_id);
   $query->bindValue(2,$status);
   $query->bindValue(3,$file_parh);
   $query->execute();
   header('Location: index.php');
  }
    
  //fetch user data by user id 
  public function user_data($user_id){
   global $pdo;
   $query = $pdo->prepare('SELECT * FROM members WHERE memberID = ?');
   $query->bindvalue(1,$user_id);
   $query->execute();

   return $query->fetch();
  }
    
    */
  //timeAgo Function
 function timeAgo($time_ago){

   $time_ago = strtotime($time_ago);
   $cur_time   = time();
   $time_elapsed   = $cur_time - $time_ago;
   $seconds    = $time_elapsed ;
   $minutes    = round($time_elapsed / 60 );
   $hours      = round($time_elapsed / 3600);
   $days       = round($time_elapsed / 86400 );
   $weeks      = round($time_elapsed / 604800);
   $months     = round($time_elapsed / 2600640 );
   $years      = round($time_elapsed / 31207680 );
   // Seconds
   if($seconds <= 60){
       return "just now";
   }
   //Minutes
   else if($minutes <=60){
       if($minutes==1){
           return "one minute ago";
       }
       else{
           return "$minutes minutes ago";
       }
   }
   //Hours
   else if($hours <=24){
       if($hours==1){
           return "an hour ago";
       }else{
           return "$hours hrs ago";
       }
   }
   //Days
   else if($days <= 7){
       if($days==1){
           return "yesterday";
       }else{
           return "$days days ago";
       }
   }
   //Weeks
   else if($weeks <= 4.3){
       if($weeks==1){
           return "a week ago";
       }else{
           return "$weeks weeks ago";
       }
   }
   //Months
   else if($months <=12){
       if($months==1){
           return "a month ago";
       }else{
           return "$months months ago";
       }
   }
   //Years
   else{
       if($years==1){
           return "one year ago";
       }else{
           return "$years years ago";
       }
   }
  }
 
?>

