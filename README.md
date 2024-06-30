# Installation 


* Téléchargez le fichier

* prendre le dossier ``install in wamp64`` et comme son l'indique  mettre  les deux sous dossiers contenus dans le dossier dans le dossier ``wamp64``  sans quoi le login  sécurisé ne fonctionnera pas

* créer les de données "auth" et "events" dans  phpmyadmins

* prendre les fichier .sql dans le dossier ``databases`` et les importer dans les tables précèdement crées dans phpmyadmin  

* créer deux  utilisateurs dans phpmyadmin avec pour informations de connexion les valeur stockées dans les fichier contenus dans les sous dossier de ``install in wamp64``  avec comme droits :
  
 SELECT
 INSERT
 UPDATE
 DELETE
 FILE

 CREATE
 ALTER
 INDEX
 DROP
 * placer le sous dossier contenu dans ``src`` dans ```www```


# Utilisation 

Pour  S'inscrire tapez http://localhost/API-Security/Register
Pour se Connecter tapez http://localhost/API-Security/Login
Pour se Déconnecter tapez  http://localhost/API-Security/SignOut

Pour utiliser l'api CRUD:
pour créer un evènement tapez   http://localhost/API-Security/CreateData/?table=events&data={"name":"event","date":20/06/2024,duration:120}
