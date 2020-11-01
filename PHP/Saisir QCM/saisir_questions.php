<?php
//------------------------------------------------
// Récupérer le libellé et la clé du questionnaire
//------------------------------------------------
session_start();
$questionnaire=$_SESSION["displayName"];
$cle=$_SESSION["cle"];
?>
<HTML>
<HEAD>
<TITLE>QUESTIONS liées à un Questionnaire</title>
<LINK rel="stylesheet" href="questionnaires.css" type="text/css" />
<SCRIPT type="Text/JavaScript">
<!-- Limiter le nombre de lignes du TEXTAREA à 5 -->
function bloquer(event, zoneSaisie)
   {  
   // Si on a tapé sur un caractère de retour à la ligne
   if ( event.keyCode==13 || event.which==13 )
      {  
	  // Nombre de "\n" présents dans la textarea >= 5
	  // split() : nb de sous-chaînes ayant "\n" comme séparateur
      if ( zoneSaisie.value.split("\n").length >= 5 )
			{ 
			// L'événement onkeyPress est placé à faux
			// pour interdir toute frappe de touche supplémentaire...
			event.returnValue=false;
			// Sortie de la fonction
			return false;
			}
      }
	  // Sortie de la fonction
      return true;
   }
</SCRIPT>
</STYLE>
</HEAD>
<BODY>
<FORM method="POST" action="traiter_questions.php" >
<h1><?php echo $questionnaire;?></h1>

<!-- Zone de saisie des QUESTIONS -->
<!-- TYPE d'objet (type), NOM (name), LIBELLE A AFFICHER (text) -->
<!-- REPONSES (reponses), PAR DEFAUT (defaut) -->
<fieldset>
<legend>Question</legend>

<label for="type">Type de composant :</label>
   <select name="type">
		<option value="combo">Liste déroulante</option>
		<option value="liste">Liste à choix multiples</option>
		<option value="radio">Boutons radio</option>
		<option value="text">Zone de texte</option>
   </select>

<label for="name">Nom :</label>
<input type="text" name="name" size="20" maxlength="20"/>
	
<label for="text">Libellé à afficher :</label>
<input type="text" name="text" size="40" maxlength="60"/>

<BR><BR>
<TABLE>
<TR>
<TD>
<label for="reponses">Réponse(s) (1 par ligne) :</label>
<textarea name="reponses" cols="30" rows="4" wrap="off" onkeyPress="return( bloquer(event, this) );"></textarea>
</TD>
<TD>
   <h2>Réponse par défaut ?</h2>
   <P>
   <label class="inline">Réponse 1</label>
   <input type="radio" name="defaut" value="1" checked="checked" /> 
   <br>
   <label class="inline">Réponse 2</label>
   <input type="radio" name="defaut" value="2" /> 
   <br>
   <label class="inline">Réponse 3</label>
   <input type="radio" name="defaut" value="3" /> 
   <br>
   <label class="inline">Réponse 4</label>
   <input type="radio" name="defaut" value="4" /> 
   <br>
   <label class="inline">Réponse 5</label>
   <input type="radio" name="defaut" value="5" /> 
   </P>
</TD>
</TR>
</TABLE>
</fieldset>
<!-- BOUTONS -->
<P>
	<input type="submit" value="Envoyer" />
	<input type="reset" value="Annuler" />
	<input value="Nouveau questionnaire" onclick="self.location.href='saisir_questionnaire.php'" />
</P>
</FORM>
</BODY>
</HTML>
