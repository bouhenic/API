# API REST


- db_connect.php: Ce fichier utilisera la chaîne de connexion mysql.

- temperature.php: Ce fichier contient tous les méthode d’API REST.

- .htaccess: Ce fichier est utilisé pour le routage.

| Route        | Méthode    |  Type     | Description|
| :------------- | :----------: | -----------: |-----------: |
|  API/temperature | GET   | JSON    |Récupérer toute la table temperature.|
| API/temperature/{id}   | GET | JSON |Récupérer les données d’un seul enregistrement température |
|  API/temperature | POST   | JSON    |Insérer une nouvelle mesure dans la base de données.|
| API/temperature/{id}   | PUT | JSON |Mettre à jour un enregistrement dans la base de données. |
| API/temperature/{id}   | DELETE | JSON |Supprimer un enregistrement dans la base de données. |

Requête GET de toute la table temperature : curl http://localhost:8888/API/temperature

Requête GET de l'enregistrement 880 : curl http://localhost:8888/API/temperature/880

Requête POST : curl -d "TEMP=33" -X POST http://localhost:8888/API/temperature

Requête update : curl -X PUT -H "Content-Type: application/json" -d '{"temp":"40"}' http://localhost:8888/API/temperature/824

Requête Delete : curl -X DELETE http://localhost:8888/API/temperature/824

