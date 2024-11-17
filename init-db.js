// Récupération des variables d'environnement
let env = {
  username: _getEnv('MONGO_INITDB_ROOT_USERNAME'),
  password: _getEnv('MONGO_INITDB_ROOT_PASSWORD'),
  database: _getEnv('MONGO_INITDB_DATABASE')
};

// Connexion initiale à admin
db = db.getSiblingDB('admin');

try {
  db.auth(env.username, env.password);
  
  // Création et utilisation de la base de données spécifiée
  db = db.getSiblingDB(env.database);
  
  // Création de la collection click 
  if (!db.getCollectionNames().includes('click')) {
    db.createCollection('click');
  }
  
  // Chargement des données depuis le fichier JSON
  let jsonContent;
  try {
    jsonContent = cat('/docker-entrypoint-initdb.d/arcadiaMongo.json');
  } catch (e) {
    throw e;
  }
  
  let data = JSON.parse(jsonContent);
  
  if (data && data.length > 0) {
    // Suppression des données existantes
    db.click.deleteMany({});
      
    // Insertion des nouvelles données
    db.click.insertMany(data);

    // Création d'un utilisateur dédié pour cette base de données si nécessaire
    db.createUser({
      user: env.username,
      pwd: env.password,
      roles: [
        {
          role: "readWrite",
          db: env.database
        }
      ]
    });
      
  } else {
    throw new Error('Aucune donnée valide trouvée dans le fichier JSON');
  }
  
} catch (error) {
  throw error;
}