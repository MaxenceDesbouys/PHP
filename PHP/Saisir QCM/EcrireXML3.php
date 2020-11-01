<?php
$user="root";		// Login
	$pwd="";			// pwd
	$bdd="QCM";			// BD MySQL
	$hote="localhost";	// Serveur
    $dsn = "mysql:host=$hote;dbname=$bdd"; 
    $sql = "SELECT * FROM questionnaire";
    

	// 4. Connexion au serveur et a la BD
	$cnx =  new PDO($dsn, $user, $pwd);
    try{
        $pdo = new PDO($dsn, $user, $pwd);
        $stmt = $pdo->query($sql);
        
        if($stmt === false){
         die("Erreur");
        }
        
       }
       catch (PDOException $e){
         echo $e->getMessage();
       }
        
?>
<HTML>
<HEAD>
<TITLE>Generer les questionnaires XML</title>
<LINK rel="stylesheet" href="questionnaires.css" type="text/css" />

</HEAD>
<BODY onload="initElement();">


<?php
     $i = 0;
     while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : 
     $clef[$i] = $row['cle']; 
     $name[$i] = $row['name']; 
     $i += 1;
     
      endwhile;
      $cnx=null;
       ?>


<fieldset>
<FORM name="QCM" method="POST" action="Traiter_creationXML.php" >
<legend>Generer du XML</legend>
<label for="type">Choisir le questionnaire :</label>
   <select name="type" id="liste">
   <?php
    $a =0;
    while($i > $a) : 
    echo "<option value='".$a."'>".$name[$a]." </option>";
    $a=$a+1;
    endwhile;
    ?>
   </select>
</fieldset>
<button type="submit" id="foo">Creer un fichier XML</button>
</FORM>
</body>


<?php

    // $xml = new DOMDocument('1.0', 'utf-8');
    // $tag = $xml->createElement('items',$name[0]);
    // $xml->appendChild($tag);
    // $xml->saveXML();
    // $larequete = $name[0] . $clef[0];
    // -$xml->save($larequete .'.XML');
?> 


