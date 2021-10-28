var today = new Date();
var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

let elementsCurrentTime = document.getElementsByClassName("currentTime");

for (let index = 0; index < elementsCurrentTime.length; index++) {
elementsCurrentTime[index].value = time;
}