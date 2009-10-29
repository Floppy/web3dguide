function DetectNetscape() {
	var retVal = 0;
	var version = parseFloat(navigator.appVersion);
	if (version>=3) {
		var plugin = navigator.mimeTypes["model/vrml"];
		if (plugin != null) {
			retVal = 1;
		}
	}
	return retVal;
}

function DetectIE() {
	var retVal = 0;
	var version = parseFloat(navigator.appVersion);
	if (version>=2) {
		var pluginArray = (new VBArray(GetPluginArray())).toArray();
		for (i = 0; i < pluginArray.length; i++) {
			if (pluginArray[i]==true) retVal = 1;
		}
	}
	return retVal;
}

function DisplayVRML(vrml,novrml) {
	var browser = navigator.appName;
	var displayVRML = 0;
	if (browser=="Netscape") displayVRML = DetectNetscape();
	else if (browser=="Microsoft Internet Explorer") displayVRML = DetectIE();
	if (displayVRML == 1) {
	 	document.writeln(vrml);
	}
	else {
		document.writeln(novrml);
	}
}
