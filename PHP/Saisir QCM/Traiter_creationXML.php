<?php
    $methode=$_SERVER["REQUEST_METHOD"];
    if ($methode=="GET")
	    $param=$_GET;
    else 
        $param=$_POST;
    include 'EcrireXML3.php';
    $choix=$_POST['type'];
    
    
    $user="root";		// Login
	$pwd="";			// pwd
	$bdd="QCM";			// BD MySQL
	$hote="localhost";	// Serveur
    $dsn = "mysql:host=$hote;dbname=$bdd"; 
    $laquestion= $clef[$choix];
    $sql = "SELECT * FROM questions WHERE cle = $laquestion";
    
    // 4. Connexion au serveur et a la BD
    

    try
    {
        $pdo = new PDO($dsn, $user, $pwd);
        $stmt = $pdo->query($sql);
        
        if($stmt === false){
         die("Erreur");
        }
        
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
       $i = 0;
       $j=0;
       $y=0;
       $o =1;
       $u=0;
       while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : 
       $question[$i] = $row['name']; 
       $i += 1;
       while ($y < 5) 
        {
             $Reponses[$u] = $row["reponse".$o]; 
             $y +=1;
             $o +=1;
             $u+=1;
        }
        $y=0;
        $o=1;
       $j += 1;
        endwhile;
        


        $pdo=null;


    $xml = new DOMDocument('1.0', 'utf-8');
    $tag = $xml->createElement('Questionnaire',$name[$choix]);
    $xml->appendChild($tag);
    $i=0;
    $y=0;
    $P =0;
    while ($i < $j) {
        $tag2 = $xml->createElement('Questions',$question[$i]);
        $tag->appendChild($tag2);
        while ($y < 5) 
        {
            $tag3 = $xml->createElement('Reponses',$Reponses[$P]);
            $tag2->appendChild($tag3);
            $P+=1;
            $y +=1;
        }
        $y=0;
        echo "<script>alert(\"XML CREER\")</script>";
        $i += 1;
    }
    $xml->saveXML();
    $larequete = $name[$choix] . $clef[$choix];
    $xml->save($larequete .'.XML');

?>