
var cron = require('node-cron');
var job = null;
var sensor = null;
var servoCron = null;
var request = require('request');
var dateFormat = require('dateformat');
var async = require('async');
var admin = require("firebase-admin");
var serviceAccount = require("./adroit-apps-service-firebase-adminsdk-h4dyf-822a5b5d85.json");
admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://adroit-apps-service.firebaseio.com"
});

function Cron(){
  this.init = function(db){
    job = cron.schedule('* * * * * *',function(){
      async.waterfall([
      	function(callback){
      		db.que('SELECT * FROM jemur WHERE DATE_ADD(tanggal_jemur, INTERVAL estimasi_waktu SECOND) <= ? AND status = "belum kering"',new Date(),function(err,data){
      		  if(err){
      		    callback("selJemur : "+err,null);
      		  }else{
      		  	callback(null,data);
      		  }
      		});
      	},
      	function(riwayat,callback){
      		let idRiwayat = [];
      		for(let i = 0; i <= riwayat.length; i++){
            if(i<riwayat.length){
              idRiwayat.push(riwayat[i].id_jemuran);
            }else{
              db.que('UPDATE jemur SET status = "sudah kering" WHERE id_jemuran in (?)',idRiwayat,function(err,data){
                if(err){
                  if(err == "other"){
                    callback(null,riwayat);
                  }else{
                    callback("upJemur : "+err,null);
                  }
                }else{
                  callback(null,riwayat);
                }
              });
            }
      		}
      	},
        function(riwayat,callback){
          let email = [];
          for(let i = 0; i <= riwayat.length; i++){
            if(i<riwayat.length){
              email.push(riwayat[i].email);
            }else{
              db.que('SELECT regToken FROM akun WHERE email in (?)',null,function(err,data){
                if(err){
                  callback("selRegToken : "+err,null);
                }else{
                  callback(null,data);
                }
              });
            }
          }
        },
        function(dataAkun,callback){
          let regTokens = [];
          for(let i = 0; i <= dataAkun.length; i++){
            if(i < dataAkun.length){
              if(dataAkun[i].regToken != ''){
                regTokens.push(dataAkun[i].regToken);
              }
            }else{
              callback(null,regTokens);
            }
          }
        }
      ],function(err,regTokens){
      	if(!err){
      		console.log(regTokens);
          var payload = {
            notification: {
              title: "Jemuran Kering",
              body: "Jemuran anda Telah kering"
            }
          };
          var options = {
            priority: "high",
            timeToLive: 60 * 60 * 48
          };
          admin.messaging().sendToDevice(regTokens, payload, options)
          .then(function(response) {
            console.log("Successfully sent message:", response);
          })
          .catch(function(error) {
            console.log("Error sending message:", error);
          });
      	}
      });
    });
	  sensor = cron.schedule("*/5 * * * * *", function () {
		  async.waterfall([
			  function (callback) {
				  db.que('SELECT device_id FROM device WHERE status = "On"', null, function (err, data) {
					  if (err) {
						  callback(err, null);
					  } else {
						  let deviceIds = [];
						  for (let i = 0; i <= data.length; i++) {
							  if (i < data.length) {
								  deviceIds.push(data[i].device_id);
							  } else {
								  callback(null, deviceIds);
							  }
						  }
					  }
				  })
			  },
			  function (deviceIds, callback) {
				  let i = 0;
				  let idDeviceOnline = [];
				  let errAray = [];

				  function getDeviceStatus() {
					  if (i < deviceIds.length) {
						  let option = {
							  url: 'https://api.arkademy.com:8443/v0/arkana/device/IO/' + deviceIds[i] + '/status',
							  headers: {
								  'Authorization': 'Bearer MTgwNjg2MjI5MC4zODI3NDE1Og=='
							  }
						  };
						  request(option, function (error, response, body) {
							  if (!error && response.statusCode == 200) {
								  let bodyJSON = JSON.parse(body);
								  if (bodyJSON.result == "device is online") {
									  idDeviceOnline.push(bodyJSON.device_id);
									  i++;
									  getDeviceStatus();
								  } else {
									  db.que('UPDATE device SET status = "Off", servo = "Angkat", auto = "Manual" WHERE device_id = ?', deviceIds[i], function (err, data) {
										  if (err) {
											  if (err == 'other') {
												  i++;
												  getDeviceStatus();
											  } else {
												  errAray.push(err);
											  }
										  } else {
											  i++;
											  getDeviceStatus();
										  }
									  });
									  i++;
									  getDeviceStatus();
								  }
							  } else {
								  console.log(error);
								  i++;
								  getDeviceStatus();
							  }
						  })
					  } else {
						  if (errAray.length > 0) {
							  console.log(errAray);
						  }
						  if (idDeviceOnline.length > 0) {
							  callback(null, deviceIds);
						  } else {
							  callback("No Device Online", null);
						  }
					  }
				  }

				  getDeviceStatus();
			  },
			  function (deviceIds, callback) {
				  async.parallel([
					  function (callback) {
						  for (let i = 0; i <= deviceIds.length; i++) {
							  if (i < deviceIds.length) {
								  let option = {
									  url: 'https://api.arkademy.com:8443/v0/arkana/device/IO/' + deviceIds[i] + '/adc/data',
									  headers: {
										  'Authorization': 'Bearer MTgwNjg2MjI5MC4zODI3NDE1Og=='
									  }
								  };
								  request(option, function (error, response, body) {
									  if (!error && response.statusCode == 200) {
										  let bodyJSON = JSON.parse(body);
										  if (bodyJSON.status == true && bodyJSON.data.status != null) {
											  let cahaya = bodyJSON.data.result["0"];
											  console.log(cahaya);
											  db.que('UPDATE device SET cahaya = ? WHERE device_id = ?', [cahaya, deviceIds[i]], function (err, data) {
												  if (err) {
													  if (err != 'other') {
														  callback(err);
													  } else {
														  callback(null);
													  }
												  } else {
													  callback(null);
												  }
											  })
										  }
									  } else {
										  callback(error);
									  }
								  })
							  }
						  }
					  },
					  function (callback) {
						  console.log(deviceIds);
						  for (let i = 0; i <= deviceIds.length; i++) {
							  if (i < deviceIds.length) {
								  let option = {
									  url: 'https://api.arkademy.com:8443/v0/arkana/device/IO/' + deviceIds[i] + '/dht11/data',
									  headers: {
										  'Authorization': 'Bearer MTgwNjg2MjI5MC4zODI3NDE1Og=='
									  }
								  };
								  request(option, function (error, response, body) {
									  if (!error && response.statusCode == 200) {
										  let bodyJSON = JSON.parse(body);
										  if (bodyJSON.status == true && bodyJSON.data.status == "OK") {
											  console.log(bodyJSON.data.result["humidity"]);
											  db.que('UPDATE device SET lembab = ? WHERE device_id = ?', [bodyJSON.data.result["humidity"], deviceIds[i]], function (err, data) {
												  if (err) {
													  if (err != 'other') {
														  callback(err);
													  } else {
														  callback(null);
													  }
												  } else {
													  callback(null);
												  }
											  })
										  }
									  } else {
										  callback(error);
									  }
								  })
							  }
						  }
					  }/*,
					function (callback) {
						for(let i = 0; i <= deviceIds; i++){
							if(i < deviceIds){
								let option = {
									url: 'http://api.arkademy.com:3000/v0/arkana/device/IO/'+deviceIds[i]+'/gpio/data',
									headers:{
										'Authorization': 'Bearer NDk0NjY4NzE2NC4zNzYwMjQ6'
									}
								};
								request(option,function (error, response, body) {
									if(!error && response.statusCode == 200){
										let body = JSON.parse(body);
										if(body.status == true && body.data.status != null){
											db.que('UPDATE device SET hujan = ? WHERE device_id = ?',[body.data.result["4"],deviceIds[i]],function (err, data) {
												if(err){
													if(err != 'other'){
														callback(err);
														break;
													}else {
														callback(null);
													}
												}else {
													callback(null);
												}
											})
										}
									}else {
										callback(error);
									}
								})
							}
						}
					}*/
				  ], function (err) {
					  if (err) {
						  console.log(err);
						  callback(err);
					  } else {
						  callback(null);
					  }
				  })
			  }
		  ], function (err) {
			  if (err) {
				  console.log(err);
			  }
		  })
	  });

	  servoCron = cron.schedule("*/10 * * * * *", function () {
		  async.waterfall([
			  function (callback) {
				  db.que('SELECT device_id FROM device WHERE status = "On"', null, function (err, data) {
					  if (err) {
						  callback(err, null);
					  } else {
						  let deviceIds = [];
						  for (let i = 0; i <= data.length; i++) {
							  if (i < data.length) {
								  deviceIds.push(data[i].device_id);
							  } else {
								  callback(null, deviceIds);
							  }
						  }
					  }
				  })
			  },
			  function (deviceIds, callback) {
				  let errArray = [];
				  for (let i = 0; i <= deviceIds.length; i++) {
					  if (i < deviceIds.length) {
						  db.que("SELECT * FROM device WHERE device_id = ?", [deviceIds[0]], function (err, data) {
							  if (err) {
								  errArray.push(err);
							  } else {
								  let dataDevice = data[0];
								  console.log("servo : " + dataDevice.device_id);
								  if (dataDevice.auto == "Otomatis") {
									  let servoMoveDirection = "";
									  let sql = "";
									  if (dataDevice.cahaya >= 400 && dataDevice.lembab >= 30) {
										  servoMoveDirection = "13";
										  sql = "servo = Jemur";
									  } else {
										  servoMoveDirection = "1";
										  sql = "servo = Angkat";
									  }

									  let optionServo = {
										  url: "https://api.arkademy.com:8443/v0/arkana/device/IO/" + dataDevice.device_id + "/pwm/control",
										  method: "POST",
										  headers: {
											  "Authorization": "Bearer MTgwNjg2MjI5MC4zODI3NDE1Og=="
										  },
										  json: {
											  "controls": {
												  "4": servoMoveDirection,
												  "frequency": "20"
											  }
										  }
									  };
									  request(optionServo, function (error, response, body) {
										  if (!error && response.statusCode == 200) {
											  db.que("UPDATE device SET " + sql + " WHERE device_id = ?", dataDevice.device_id, function (err, data) {
												  if (err) {
													  if (err != 'other') {
														  errArray.push(err);
													  }
												  }
											  });
										  } else {
											  errArray.push(error);
										  }
									  })
								  }
							  }
						  });
					  } else {
						  if (errArray.length > 0) {
							  callback(errArray);
						  } else {
							  callback(null);
						  }
					  }
				  }
			  }
		  ], function (err) {
			  if (err) {
				  if (Array.isArray(err)) {
					  for (let i = 0; i <= err.length; i++) {
						  console.log(err[i]);
					  }
				  } else {
					  console.log(err);
				  }
			  }
		  });
	  })
  };
}

module.exports = new Cron();
