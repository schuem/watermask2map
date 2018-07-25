const http = require('http');
const MongoClient = require('mongodb').MongoClient;
const assert = require('assert');
const url = require('url');

const myurl = 'mongodb://sar2water:buhayra@localhost:27017/sar2watermask';

// Database Name
const dbName = 'sar2watermask';

const server = http.createServer(function (request, response) {

  var qs = url.parse( request.url, true );
  var qskey = Object.keys( qs.query );
  qs.query["properties." + qskey[0]] = parseInt(qs.query[qskey[0]])
  delete qs.query[qskey[0]]

  console.log(qs.query);
  // Use connect method to connect to the server
  MongoClient.connect(myurl, function(err, client) {
    assert.equal(null, err);
    console.log("Connected successfully to server");

    const db = client.db(dbName);
    findDocuments(db,qs.query,console.log);

    client.close();
  });
});


const findDocuments = function(db, query, callback) {
  // Get the documents collection
  const collection = db.collection('toponyms');
  // Find some documents
  collection.find(query).toArray(function(err, docs) {
    assert.equal(err, null);
    console.log("Found the following records");
    console.log(JSON.stringify(query))
    console.log(JSON.stringify(docs["properties.cod"]))
    callback(JSON.stringify(docs));
  });
}

server.listen(5155);
