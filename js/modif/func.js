"use strict"

function affichMDP() {
  var pw = document.getElementById("motdepasse");
  if (pw.type === "password") {
    pw.type = "text";
  } else {
    pw.type = "password";
  }
}

$(function () {
  $('[data-toggle="popover"]').popover()
})