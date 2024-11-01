// JavaScript Document 
document.onreadystatechange = function () {
var state = document.readyState;
/*ss-preload will be hidden when all data will be loaded in the DOM and site is ready for view*/
  if (state == 'complete') {
      setTimeout(function(){
         document.getElementById('load').style.visibility="hidden";
      },500);
  }
}