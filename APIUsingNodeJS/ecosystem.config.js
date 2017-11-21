module.exports = {
  apps : [{
    name   : "AngkatinAPI",
    script : "./bin/www",
    watch  : true,
    env    :{
      "NODE_ENV": "development"
    },
    env_production:{
      "NODE_ENV": "production"
    }
  }]
}
