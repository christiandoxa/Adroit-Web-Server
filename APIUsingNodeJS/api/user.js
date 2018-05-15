var db = require("../database/model");
var hashToSHA1 = require("sha1");
var generateToken = require("../database/GenerateToken");
var async = require('async');
var dateFormat = require('dateformat');
var cron = require('../api/cron');
var request = require('request');
var base64_encode = function(val){
  var encode = null;
  if(val){
    encode = new Buffer(val).toString('base64');
  }
  return encode;
};
var base64_decode = function(val){
  var decode = null;
  if(val){
    decode = new Buffer(val,'base64').toString('ascii');
  }
  return decode;
};
const SUCCESS = true;
const FAIL = false;

function API(){
  cron.init(db);

  this.getDevice = function(req,res){
    var id_device = req.params.id;
    if(id_device){
      db.que('SELECT * FROM device WHERE device_id = ?',id_device,function(err,data){
        if(err){
          res.status(400).json({status:FAIL,result:err});
        }else{
          res.status(200).json({status:SUCCESS,result:data[0]});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.loginAwal = function(req,res){
    var email = base64_decode(req.body.email);
    var pass = base64_decode(req.body.password);
    var regToken = req.body.regToken;
    if(email && pass){
      async.waterfall([
        function(callback){
          db.que('SELECT token FROM akun WHERE email = ? AND kata_sandi = ?',[email,hashToSHA1(pass)],function(err,data){
            if(err){
              callback(err,null);
            }else{
              callback(null,data[0].token);
            }
          });
        },
        function(token,callback){
          db.que('UPDATE akun SET regToken = ? WHERE email = ? AND kata_sandi = ?',[regToken,email,hashToSHA1(pass)],function(err,data){
            if(err){
              if(err == 'other'){
                callback(null,token)
              }else{
                callback(err,token);
              }
            }else{
              callback(null,token);
            }
          });
        }
      ],function(err,token){
        if(err){
          res.status(400).json({status:FAIL,result:err});
        }else{
          res.status(200).json({status:SUCCESS,result:{token:token}});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.login = function(req,res){
    res.status(200).json({status:SUCCESS});
  };

  this.logout = function(req,res){
    let tok = req.headers.authorization;
    let token = tok.substring(7,tok.length);
    db.que('UPDATE akun SET regToken = "" WHERE token = ?',token,function(err,data){
      if(err){
        if(err=="other"){
          res.status(200).json({status:SUCCESS});
        }else{
          res.status(400).json({status:FAIL});
        }
      }else{
        res.status(200).json({status:SUCCESS});
      }
    });
  };

  this.withGmail = function(req,res){
    let email = base64_decode(req.body.email);
    let nama = base64_decode(req.body.name);
    let password = generateToken.getPass();
    let regToken = req.body.regToken;
    if(email && nama){
      async.waterfall([
        function(callback){
          db.que('SELECT token FROM akun WHERE email = ?',email,function(err,data){
            if(err){
              if(err=='other'){
                callback(null,true,null);
              }else{
                callback(err,null,null);
              }
            }else{
              callback(null,null,data[0].token);
            }
          });
        },
        function(insert,dataToken,callback){
          if(insert){
            let tok = generateToken.getToken(email,password);
            db.que('INSERT INTO akun (email,nama,kata_sandi,token,regToken) VALUES (?,?,?,?,?)',[email,nama,password,tok,regToken],function(err,data){
              if(err){
                if(err == 'other'){
                  callback(null,SUCCESS,tok);
                }else{
                  callback(err,null,null);
                }
              }else{
                callback(null,SUCCESS,tok);
              }
            });
          }else{
            callback(null,SUCCESS,dataToken);
          }
        }
      ],function(err,success,resultToken){
        if(err){
          res.status(400).json({status:FAIL,result:err});
        }else{
          res.status(200).json({status:SUCCESS,result:resultToken});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.updateDevice = function(req,res){
    let id = req.body.id;
    let job = req.body.job;
    let sql = null;
	  let servoMove = false;
	  let servoMoveDirection = "";
    if(id && job){
      switch (job) {
        case "angkat":
          sql = "servo = 'Angkat'";
			servoMove = true;
			servoMoveDirection = "1";
          break;
        case "jemur":
          sql = "servo = 'Jemur'";
			servoMove = true;
			servoMoveDirection = "13";
          break;
        case "On":
          sql = "status = 'On'";
          break;
        case "Off":
          sql = "status = 'Off', servo = 'Angkat', auto = 'Manual'";
			servoMove = true;
			servoMoveDirection = "1";
          break;
        case "Manual":
          sql = "auto = 'Manual'";
          break;
        case "Otomatis":
          sql = "auto = 'Otomatis', servo = 'Angkat'";
          break;
      }

      if(sql){
		  if (servoMove) {
			  let option = {
				  url: 'https://api.arkademy.com:8443/v0/arkana/device/IO/' + id + '/status',
				  headers: {
					  'Authorization': 'Bearer MTgwNjg2MjI5MC4zODI3NDE1Og=='
				  }
			  };
			  request(option, function (error, respone, body) {
				  if (!error && respone.statusCode == 200) {
					  let bodyJSON = JSON.parse(body);
					  if (bodyJSON.result == "device is online") {
						  let optionServo = {
							  url: "https://api.arkademy.com:8443/v0/arkana/device/IO/" + id + "/pwm/control",
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
								  db.que("UPDATE device SET " + sql + " WHERE device_id = ?", id, function (err, data) {
									  if (err) {
										  if (err == 'other') {
											  res.status(200).json({status: SUCCESS});
										  } else {
											  res.status(400).json({status: FAIL, result: err});
											  console.log(err);
										  }
									  } else {
										  res.status(200).json({status: SUCCESS});
									  }
								  });
							  } else {
								  console.log(error);
								  res.status(500).json({status: FAIL, result: error});
							  }
						  })
					  } else {
						  db.que('UPDATE device SET status = "Off", servo = "Angkat", auto = "Manual" WHERE device_id = ?', id, function (err, data) {
							  if (err) {
								  if (err == 'other') {
									  res.status(400).json({status: FAIL, result: "Device must be online"});
								  } else {
									  res.status(500).json({status: FAIL, result: err});
								  }
							  } else {
								  res.status(400).json({status: FAIL, result: "Device must be online"});
							  }
						  });
					  }
				  } else {
					  console.log(error);
					  res.status(500).json({status: FAIL, result: error});
				  }
			  });
		  } else {
			  db.que("UPDATE device SET " + sql + " WHERE device_id = ?", id, function (err, data) {
				  if (err) {
					  if (err == 'other') {
						  res.status(200).json({status: SUCCESS});
					  } else {
						  res.status(400).json({status: FAIL, result: err});
					  }
				  } else {
					  res.status(200).json({status: SUCCESS});
				  }
			  });
		  }
      }else{
        res.status(400).json({status:FAIL,result:'params not found'});
      }
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.signUp = function(req,res){
    let email = base64_decode(req.body.email);
    let nama = base64_decode(req.body.name);
    let password = hashToSHA1(base64_decode(req.body.password));
    if(email && nama && password){
      let tok = generateToken.getToken(email,base64_decode(req.body.password));
      db.que('INSERT INTO akun (email,nama,kata_sandi,token) VALUES (?,?,?,?)',[email,nama,password,tok],function(err,data){
        if(err == 'other'){
          res.status(200).json({status:SUCCESS});
        }else{
          res.status(400).json({status:FAIL,result:err});
        }
        if(err){
        }else{
          res.status(200).json({status:SUCCESS});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.jemuranGet = function(req,res){
    let tok = req.headers.authorization;
    let token = tok.substring(7,tok.length);
    async.waterfall([
      function(callback){
        db.que('SELECT email FROM akun WHERE token = ?',token,function(err,data){
          if(err){
            callback(err,null);
          }else{
            callback(err,data[0].email);
          }
        });
      },
      function(email,callback){
        db.que('SELECT *,DATE_ADD(tanggal_jemur, INTERVAL estimasi_waktu SECOND) AS tgl_selesai FROM jemur WHERE email = ?',email,function(err,data){
          if(err){
            callback(err,null);
          }else{
            callback(null,data);
          }
        });
      }
    ],function(err,data){
      if(err){
        res.status(400).json({status:FAIL,result:err});
      }else{
        res.status(200).json({status:SUCCESS,result:data});
      }
    });
  };

  this.jemuranUpdate = function(req,res){
    let id_jemuran = req.body.id;
    db.que("UPDATE jemur SET status = 'sudah kering' WHERE id_jemuran = ?",id_jemuran,function(err,data){
      if(err){
        if(err=="other"){
          res.status(200).json({status:SUCCESS});
        }else{
          res.status(400).json({status:FAIL});
        }
      }else{
        res.status(200).json({status:SUCCESS});
      }
    });
  };

  this.jemuranPost = function(req,res){
    let tok = req.headers.authorization;
    let token = tok.substring(7,tok.length);
    let date = new Date(req.body.date);
    let tgl_jemur = dateFormat(date,"yyyy-mm-dd'T'HH:MM:ss'Z'");
    let timeNumber = 3600*2;
    let timeString = parseInt(timeNumber,10);
    let id_device = req.body.id;
    let id_jemuran = dateFormat(date,"yyyymmddHHMMss");
    if(date && id_device){
      async.waterfall([
        function(callback){
          db.que("SELECT email FROM akun WHERE token = ?",token,function(err,data){
            if(err){
              callback(err,null);
            }else{
              callback(null,data[0].email);
            }
          });
        },
		function (email,callback) {
			db.que('SELECT cahaya,hujan,lembab FROM device WHERE device_id = ?',id_device,function (err, data) {
				if(err){
					if(err == 'other'){
						callback("device not found",null);
					}else {
						callback(err,null);
					}
				}else {
					callback(null,data,email);
				}
			})
		},
        function(dataDevice,email,callback){
          db.que("INSERT INTO jemur (id_jemuran,device_id,tanggal_jemur,estimasi_waktu,cahaya,hujan,lembab,email) VALUES (?,?,?,?,?,?,?,?)",[id_jemuran,id_device,tgl_jemur,timeString,dataDevice[0].cahaya,dataDevice[0].hujan,dataDevice[0].lembab,email],function(err,data){
            if(err){
              if(err == 'other'){
                callback(null);
              }else{
                callback(err);
              }
            }else{
              callback(null);
            }
          });
        }
      ],function(err){
        if(err){
			res.status(400).json({status:FAIL,result:err});
        }else{
          res.status(200).json({status:SUCCESS});
        }
      });
    }else{
      res.status(400).json({status:FAIL,result:'params not found'});
    }
  };

  this.profileUpdate = function(req,res){
    let tok = req.headers.authorization;
    let token = tok.substring(7,tok.length);
    let regToken = req.body.regToken;
    db.que('UPDATE akun set regToken = ? WHERE token = ?',[regToken,token],function(err,data){
      if(err){
        if(err == 'other'){
          res.status(200).json({status:SUCCESS});
        }else{
          res.status(400).json({status:FAIL,result:err});
        }
      }else{
        res.status(200).json({status:SUCCESS});
      }
    });
  };

  this.profile = function(req,res){
    let tok = req.headers.authorization;
    let token = tok.substring(7,tok.length);
    async.waterfall([
      function(callback){
        db.que('SELECT email,nama FROM akun WHERE token = ?',token,function(err,data){
          if(err){
            callback(err,null);
          }else{
            callback(null,data[0]);
          }
        });
      },
      function(dataUser,callback){
        db.que('SELECT * FROM device WHERE email = ?',dataUser.email,function(err,data){
          if(err){
            if(err=="other"){
              callback(null,dataUser,null);
            }else{
              callback(err,null,null);
            }
          }else{
            callback(null,dataUser,data);
          }
        });
      },
      function(dataUser,dataDevice,callback){
        db.que('SELECT * FROM jemur WHERE email = ?',dataUser.email,function(err,data){
          if(err){
            if(err=="other"){
              callback(null,dataUser,dataDevice,null);
            }else{
              callback(err,null,null,null);
            }
          }else{
            callback(null,dataUser,dataDevice,data);
          }
        });
      }
    ],function(err,resultUser,resultDevice,resultRiwayat){
      if(err){
        res.status(400).json({status:FAIL,result:err});
      }else{
        res.status(200).json({status:SUCCESS,result:{profile:resultUser,devices:resultDevice,riwayat:resultRiwayat}});
      }
    });
  };
}

module.exports = new API();
