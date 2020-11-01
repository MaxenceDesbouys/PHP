<?php
//------------------------------
// R�cup�rer les valeurs post�es
//------------------------------
// La r�cup�ration d�pend de la m�thode d'envoi de ceux-ci
$m�thode=$_SERVER["REQUEST_METHOD"];
if ($m�thode=="GET")
	$param=$_GET;
else 
	$param=$_POST;

$name=$param["name"];
$displayName=$param["displayName"];
$description=$param["description"];

// La requ�te est valide si tous les champs ont �t� saisis
// Si non, reaffichage de la page de saisie du questionnaire
$requ�teValide=($name!="" && $displayName!="");
if ($requ�teValide)
	{
	//----------------------------------
	// Ajout du QUESTIONNAIRE dans la BD
	//----------------------------------
	
	// 1. Formatage de la CLE (ann�e+mois+jour+heure+minute+seconde)
	$cle = time();
	$cle = date("ymjhis",$cle);
	
	// 2. Prise en compte des apostrophes dans les cha�nes
	// pour pouvoir faire un INSERT : ' remplac� par \'
	$name = str_replace("'", "\'", $name);
	$displayName = str_replace("'", "\'", $displayName);
	$description = str_replace("'", "\'", $description);

	// 3. Configuration serveur et BD
	$user="root";		// Login
	$pwd="";			// pwd
	$bdd="qcm";			// BD MySQL
	$hote="localhost";	// Serveur
	
	// 4. Connexion au serveur et � la BD
	$cnx = mysqli_connect($hote, $user, $pwd ,$bdd);
	if (! $cnx)
		{
		echo "Connexion au serveur impossible !";
		mysql_close($cnx);
		exit();
		}
	$labd=mysqli_select_db($cnx,$bdd);
	if (! $labd)
		{
		echo "Connexion � la base de donn�es impossible !";
		mysql_close($cnx);
		exit();
		}

	// 5. Ajout du QUESTIONNAIRE
	if ($description!="")
		$SQL = "INSERT INTO questionnaire(cle,name,displayName,description) VALUES('".$cle."','".$name."','".$displayName."','".$description."')";
	else
		$SQL = "INSERT INTO questionnaire(cle,name,displayName,description) VALUES('".$cle."','".$name."','".$displayName."','vide')";
	
	$execution= $cnx->query($SQL);
	if (! $execution)
		{
		echo "Cr�ation du QUESTIONNAIRE impossible !";
		mysql_close($cnx);
		exit();
		}

	// 6. Fin de connexion
	mysqli_close($cnx);

	//---------------------------------------------
	// D�marrage de SESSION pour sauvegarder le 
	// descriptif et la cl� du questionnaire, puis
	// affichage de la page de saisie des QUESTIONS
	//---------------------------------------------
	session_start();
	$_SESSION["cle"] = $cle;
 	$_SESSION["displayName"] = $displayName;

	header('Location: saisir_questions.php');
	//ou bien : include "saisir_questions.php";	
	}
else
	//-----------------------------------------------------
	// Reaffichage du formulaire de saisie du questionnaire
	//-----------------------------------------------------
	header('Location: saisir_questionnaire.php');
?>
