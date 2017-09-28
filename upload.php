<!DOCTYPE html>
<html lang="fr">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
  <form action="processGPX.php" method="post" enctype="multipart/form-data">
    Charger un fichier GPX contenant traces et WayPoints :
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Charger le fichier sur le serveur" name="submit">
</form>

<a href='index.php'>Retour à la carte</a>

  </body>

</html>