var objInput = document.getElementById('client_id');
if (objInput != null)
{
  input.onkeydown = function (e) {
    var k = e.which;
    /* numeric inputs can come from the keypad or the numeric row at the top */
    if ((k < 48 || k > 57) && (k < 96 || k > 105)) {
      e.preventDefault();
      return false;
    }
  };
}

function JsClientSearch(psInstallId, pnNoPage) {
  document.getElementById("noFiltre").value = "0";
  var sInnerHTML = fGetFile("z_clients.php?install_id=" + psInstallId + "&nopage=" + pnNoPage);
  document.getElementById("contenu").innerHTML = sInnerHTML;
}

/* Méthodes de recherche*/
function JsClientSearchClientName(psInstallId, psClientName,pnNoPage) {
  document.getElementById("noFiltre").value = "1";
  document.getElementById("client_id").value = "";
  console.log(psClientName + "," + psInstallId);
  var sInnerHTML = fGetFile("z_clients.php?client_name=" + psClientName + "&install_id=" + psInstallId + "&nopage=" + pnNoPage);
  document.getElementById("contenu").innerHTML = sInnerHTML;
}

function JsClientSearchClientId(psInstallId, psClientId,pnNoPage) {
  document.getElementById("noFiltre").value = "2";
  document.getElementById("client_name").value = "";
  var sInnerHTML = fGetFile("z_clients.php?client_id=" + psClientId + "&install_id=" + psInstallId + "&nopage=" + pnNoPage);
  document.getElementById("contenu").innerHTML = sInnerHTML;
}  

function JsClientSearchClientActive(psInstallId, pnClientActive, pnNoPage) {
  if (pnClientActive == 0) {
    document.getElementById("noFiltre").value = "3";
  }
  else if (pnClientActive == 1){ 
    document.getElementById("noFiltre").value = "4";
  }
  /* toutes */
  else {
    document.getElementById("noFiltre").value = "5";
  }
  
  console.log(pnClientActive + "," + psInstallId);
  document.getElementById("client_name").value = "";
  document.getElementById("client_id").value = "";
  var sInnerHTML = fGetFile("z_clients.php?client_active=" + pnClientActive + "&install_id=" + psInstallId + "&nopage=" + pnNoPage);
  document.getElementById("contenu").innerHTML = sInnerHTML;
}

/* Méthode appellée en cliquant sur un N0 de page*/
function JsClientChangerPage(psInstallId, pnNoPage) {
  var sNoFiltre = document.getElementById("noFiltre").value;
  var sClientName = document.getElementById("client_name").value;
  var sClientId = document.getElementById("client_id").value;

  switch (sNoFiltre) {
    case "1": JsClientSearchClientName(psInstallId, sClientName, pnNoPage);
      break;
    case "2": JsClientSearchClientId(psInstallId, sClientId, pnNoPage);
      break;
    case "3": JsClientSearchClientActive(psInstallId, 0, pnNoPage);
      break;
    case "4": JsClientSearchClientActive(psInstallId, 1, pnNoPage);
      break;
    case "5": JsClientSearchClientActive(psInstallId, 2, pnNoPage);
      break;
    case "0": JsClientSearch(psInstallId, pnNoPage);
      break;
  }
}

function JsClientActiverDesactiver(psClientId, psNomClient, pObjCheck) {
  //alert(pbChecked);     
  var sMessage = "l'activation";
  if (!pObjCheck.checked)
    sMessage = 'la désactivation';

  sMessage = "Confirmer " + sMessage + " " + psNomClient + " ?"
  var bResult = confirm(sMessage);

  if (bResult) {
    var sRetour = fGetFile("BddExecution.php?action=1&client_id=" + psClientId);
    document.getElementById("div_erreur").innerHTML = sRetour;
  }
  else {
    pObjCheck.checked = !pObjCheck.checked;
  }
}
/* Rappeler clients */
function JsClientChargerClients(psInstallId) {

  var sInnerHTML = fGetFile("clients.php?install_id=" + psInstallId);
  document.getElementById("div_principal").innerHTML = sInnerHTML;
  JsClientSearch(psInstallId, 1);
}

function JsClientChargerUnClient(psInstallId, psClientId) {
  var sInnerHTML = fGetFile("client.php?install_id=" + psInstallId + "&client_id=" + psClientId);
  document.getElementById("div_principal").innerHTML = sInnerHTML;  
  JsClientHallSearch(psInstallId, psClientId, 1);
}

    