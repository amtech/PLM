function format_ddmmyyyy(oObj) {
	// console.log(oObj);
	// var sValue = oObj.aData([oObj.iDataColumn]);
	var sValue = oObj;
	var aDate = sValue.split('-');
	if(aDate[2] + "/" + aDate[1] + "/" + aDate[0] == "00/00/0000")
	{
		return "";
	}else{
		return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
	}
}