Dans cette api simple basée sur le http,Vous avez droit à la lecture des contacts sans etre connecté, par contre pour les autres verbes put,post,delete il faut etre connecté et l'api va générer un token à chaque connexion et à chaque avant d'excécuter une action le code va comparer le token de la session au token dans l'url pour contrer les attaques csrf.
Après vous avez le choix soit utiliser le format d'échange json ou xml.
Pour insérer une personne en base de données en json, vu q'il n'y a pas d'appareils qui consomment mon api  j'ai fais de telle sorte que vous tapiez du json dans le champ, il y a un exemple en bas du champ pour se faire une idée.Assi pour enregistrer en xml, il faut utiliser du xml aussi, un exemple de code est à coté du champ.
J'ai mis un champ de recherche dans la page principale si vous voulez accéder aux informations d'une personne à partir de son nom seulement.
Pour ajouter un carnet vous avez le droit d'enregister qu'une adresse par contact, après en affichant les informations de la personne en étant connecté vous pouvez ajouter d'autres adresses mais si vous afficher sans etre connecté vous ne pourriez jamais modifier, ni supprimer, ni ajouter d'autres adresses.
L'afichage en xml n'est pas très visible, pour vérifier ce qui est affiché est en xml je vous recommande de faire un clic droit ensuite afficher le code source.
Vous pouvez aussi importer et exporter son carnet d'adresse en json et en xml.
La coniguration de la base de données se trouve dans le repertoire "include/config.php".Il suffit juste de modifier le nom de la base de données, le compte utilisateur, le mot de passe, le server hote =localhost.Et tout sera configuré automatiquuement.Le fichier sql se trove dans le repertoire include.
J'ai joint un fichier json et xml.
La page principale : le repertoire localhost/API

JSON : 
Liste des contacts : http://localhost/API/JSON/api.php?action=get

JSON : 
Liste des contacts : http://localhost/API/XML/api.php?action=get
