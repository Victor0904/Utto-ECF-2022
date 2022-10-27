function fCreateAjax() {
  var xhr_object = null;
  if (window.XMLHttpRequest) {
    xhr_object = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) {
    try {
      xhr_object = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {
        alert("XHR not created");
      }
    }
  }
  return xhr_object;
};
function fGetFile(psFile) {
  var xhr_object = fCreateAjax();
  if (xhr_object != null) {
    xhr_object.open("GET", psFile, false);
    xhr_object.send(null);
    if (xhr_object.readyState == 4) {
      return (xhr_object.responseText);
    }
    else {
      return ("");
    }
  }
};