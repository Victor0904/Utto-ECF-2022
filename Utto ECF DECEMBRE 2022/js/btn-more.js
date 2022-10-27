function fnBtnShow(psBtnShowId, psBtnHideId, psBranchId) {
  document.getElementById(psBranchId).style.visibility = 'visible';
  document.getElementById(psBranchId).style.width = '99%';
  document.getElementById(psBranchId).style.height = 'auto';
  document.getElementById(psBtnHideId).style.visibility = 'visible';
  document.getElementById(psBtnShowId).style.visibility = 'hidden';
};
function fnBtnHide(psBtnShowId, psBtnHideId, psBranchId) {
  document.getElementById(psBranchId).style.visibility = 'hidden';
  document.getElementById(psBranchId).style.width = '0px';
  document.getElementById(psBranchId).style.height = '0px';
  document.getElementById(psBtnHideId).style.visibility = 'hidden';
  document.getElementById(psBtnShowId).style.visibility = 'visible';
};  