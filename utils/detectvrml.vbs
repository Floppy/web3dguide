function GetPluginArray()
	On error resume next
	pluginArray = Array(false,false,false,false)
	pluginArray(0) = NOT IsNull(CreateObject("Cortona.Control"))
	pluginArray(1) = NOT IsNull(CreateObject("blaxxunCC3D.blaxxunCC3D"))
	pluginArray(2) = NOT IsNull(CreateObject("SGI.CosmoPlayer.1"))
	pluginArray(3) = NOT IsNull(CreateObject("SGI.CosmoPlayer.2"))
	pluginArray(4) = NOT IsNull(CreateObject("Nexternet.NexternetPlayer.1"))
	GetPluginArray = pluginArray
end function

