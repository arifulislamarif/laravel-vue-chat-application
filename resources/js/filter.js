window.Vue = require("vue");
// moment js
window.moment = require("moment");

Vue.filter('timeformat', function(value){
    return moment(value).format("MMMM Do YYYY, h:mm:ss a");
})
