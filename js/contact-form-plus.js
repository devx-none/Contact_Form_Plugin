document.addEventListener("DOMContentLoaded", function() {

let name = document.querySelector('#name');
name.addEventListener('change',function(){
    if(name.checked==true){
console.log('test') ;      }
    });
});