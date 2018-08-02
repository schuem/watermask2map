const express = require('express');
const app = express();
const request = require('request');
const jsonObj = require('./id_funceme.json');
const apiFunceme = 'http://api.funceme.br/rest/acude/volume'


app.use((req, res, next) => {
  // console.log(parseInt(req.query.idRequest));
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  res.idResponse = parseInt(jsonObj.reservoirs[0].properties.id_funceme)
  console.log(res.idResponse);
  next()
})

app.get('/', function(req, res, next) {
  // Handle the get for this route
});

app.post('/', function(req, res, next) {
 // Handle the post for this route
});

app.use((req, res, next) => {
  var k;
  var resArray=jsonObj.reservoirs;
  var idResponse;
  for (k = 0; k < resArray.length; ++k) { if (resArray[k].properties.id_funceme == req.query.idRequest) {res.idResponse = resArray[k].properties.cod} };
  console.log('idResponse:   ' + res.idResponse);
  // console.log(res)
  next()
})

app.use((req,res,next) => {
  request({url:apiFunceme, qs:{"reservatorio.cod": res.idResponse, "dataColeta.GTE":"2018-01-01"}}, function(err, response, body) {
    console.log(err, body);
  })
  next()
})


app.get('/', (req, res) => {
  console.log('idResponse:   ' + res.idResponse);
  res.send(res.idResponse)
})

app.listen(3000)
