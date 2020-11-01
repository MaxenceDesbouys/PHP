<?php
//----------------------------------
// R�cup�rer la cl� du QUESTIONNAIRE
//----------------------------------
session_start();
$cle=$_SESSION["cle"];

//------------------------------
// R�cup�rer les valeurs post�es
//------------------------------
$m�thode=$_SERVER["REQUEST_METHOD"];
if ($m�thode=="GET")
	$param=$_GET;
else 
	$param=$_POST;

$type=$param["type"];
$name=$param["name"];
$text=$param["text"];
$defaut=$param["defaut"];

// La requ�te est valide si tous les champs ont �t� saisis (au - 1 r�ponse)
// Si non, reaffichage de la page de saisie des questions
$requ�teValide=($type!="" && $name!="" && $text!="" && $defaut!="" && $param["reponses"]!="");
if ($requ�teValide)
	{
	//-----------------------------------------------------------
	// R�cup�rer la liste de REPONSES
	// Le contenu de textarea se pr�sente sous la forme :
	// "ligne1\r\nligne2\r\nligne3"
	// Les lignes sont s�par�es entre elles par la s�quence "\r\
	// on r�cup�re chaque sous cha�ne dans un tableau
	//-----------------------------------------------------------
	$reponses=explode("\r\n",$param["reponses"]);
	
	//-------------------------------------------------
	// Prise en compte des apostrophes dans les cha�nes
	// pour pouvoir faire un INSERT : ' remplac� par \'
	//-------------------------------------------------
	$name = str_replace("'", "\'", $name);
	$text = str_replace("'", "\'", $text);
	for ($i=0; $i<sizeof($reponses); $i++)
		$reponses[$i]=str_replace("'", "\'", $reponses[$i]);
	
	//-----------------------------------------
	// Pour le QUESTIONNAIRE en cours (cf. cle)
	// Ajout des QUESTIONS dans la BD
	//-----------------------------------------

	// 1. Formatage du RANG (heure+minute+seconde)
	$rang = time();
	$rang = date("his",$rang);
	
	// 2. Configuration serveur et BD
	$user="root";		// Login
	$pwd="";			// pwd
	$bdd="QCM";			// BD MySQL
	$hote="localhost";	// Serveur
	
	// 3. Connexion au serveur et � la BD
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

	// 4. Ajout du QUESTIONNAIRE
	$SQL = 	"INSERT INTO questions (cle,rang,typeQ,name,text,reponse1,reponse2,reponse3,reponse4,reponse5,defaut) VALUES('".
			$cle."','".$rang."','".$type."','".$name."','".$text."'";
		
	$liste=array("vide","vide","vide","vide","vide");
	for ($i=0; $i<sizeof($reponses); $i++)
		$liste[$i]=$reponses[$i];

	for ($i=0; $i<sizeof($liste); $i++)
		$SQL = $SQL .(",'".$liste[$i]."'");
 
	$SQL = $SQL . ",".$defaut.")"; 	

	$execution= $cnx->query($SQL);
	if (! $execution)
		{
		echo "Cr�ation des QUESTIONS impossible !";
		mysql_close($cnx);
		exit();
		}

	// 5. Fin de connexion
	mysqli_close($cnx); 
	}
else
	header('Location: saisir_questions.php');
?>
<HTML>
<HEAD>
<TITLE>Enregistrement des QUESTIONS</title>
<LINK rel="stylesheet" href="questionnaires.css" type="text/css" />
</HEAD>
<BODY>
<FORM>
<h1>Question enregistr�e</h1>
<P>
	<input value="Nouvelle question" onclick="self.location.href='saisir_questions.php'" />
	<input value="Nouveau questionnaire" onclick="self.location.href='saisir_questionnaire.php'" />
</P>
</FORM>
</BODY>
</HEAD>
</HTML>
