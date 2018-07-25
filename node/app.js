const MongoClient = require('mongodb').MongoClient;
const assert = require('assert');

// Connection URL
const url = 'mongodb://sar2water:buhayra@localhost:27017/sar2watermask';
// const url = 'mongodb://localhost:27017';

// Database Name
const dbName = 'sar2watermask';

// Use connect method to connect to the server
MongoClient.connect(url, function(err, client) {
  assert.equal(null, err);
  console.log("Connected successfully to server");

  const db = client.db(dbName);
  findDocuments(db,console.log);
  // const collection = db.collection('toponyms');
  // collection.find({'properties.cod':2}).toArray(function(err, docs) {
  //   assert.equal(err, null);
  //   console.log("Found the following records");
  //   console.log(docs)
    // callback(docs);
  // });
  client.close();
});


const findDocuments = function(db, callback) {
  // Get the documents collection
  const collection = db.collection('toponyms');
  // Find some documents
  collection.find({'properties.cod':2}).toArray(function(err, docs) {
    assert.equal(err, null);
    console.log("Found the following records");
    console.log(JSON.stringify(docs))
    callback(docs);
  });
}
