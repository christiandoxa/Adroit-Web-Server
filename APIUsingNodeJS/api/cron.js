
var cron = require('node-cron');
var job = null;
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
  }
};

module.exports = new Cron();
