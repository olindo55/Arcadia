try {
  // db = db.getSiblingDB('admin');
  let jsonContent = fs.readFileSync('/docker-entrypoint-initdb.d/arcadiaMongo.json', 'utf8');
  let data = JSON.parse(jsonContent);

  db = db.getSiblingDB('arcadia');
  
  // Création de la collection click si elle n'existe pas
  if (!db.getCollectionNames().includes('click')) {
      db.createCollection('click');
  } else {
  }
  
  if (Array.isArray(data) && data.length > 0) {
      // Suppression des données existantes
      let deleteResult = db.click.deleteMany({});

      // Insertion des nouvelles données
      let insertResult = db.click.insertMany(data);

      // Création d'index
      db.click.createIndex({ "name": 1 }, { unique: true });

      // Vérification finale
      let count = db.click.countDocuments();

  } else {
      throw new Error('Aucune donnée valide trouvée dans le fichier JSON');
  }


} catch (error) {
  printjson(error);
  throw error;
}