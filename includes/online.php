<?php

 $sql = "UPDATE `access_users`   
      (`contact_first_name`,`contact_surname`,`contact_email`,`telephone`) 
      VALUES (:firstname, :surname, :telephone, :email);
      ";



 $statement = $conn->prepare($sql);
 $statement->bindValue(":firstname", $firstname);
 $statement->bindValue(":surname", $surname);
 $statement->bindValue(":telephone", $telephone);
 $statement->bindValue(":email", $email);
 $count = $statement->execute();

?>