<HTML>
<HEAD>
<TITLE>Elaboration d'un QUESTIONNAIRE</title>
<LINK rel="stylesheet" href="questionnaires.css" type="text/css" />
</HEAD>
<BODY>
<FORM method="POST" action="traiter_questionnaire.php">
<!-- Zone de saisie du QUESTIONNAIRE -->
<!-- NOM (name), LIBELLE A AFFICHER (displayName), DESCRIPTION (description) -->
<fieldset>
<legend>Questionnaire</legend>
	<label for="name">Nom :</label>
	<input type="text" name="name" size="40" maxlength="40"/>
	<label for="displayName">Libellé à afficher :</label>
	<input type="text" name="displayName" size="40" maxlength="60"/>
	<label for="description">Descriptif :</label>
	<textarea name="description" cols="30" rows="4"></textarea>
</fieldset>
<!-- BOUTONS -->
<P>
	<input type="submit" value="Envoyer" />
	<input type="reset" value="Annuler" />
</P>
</FORM>
</BODY>
</HTML>