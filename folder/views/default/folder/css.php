a.add-folder-button{
	-moz-border-radius:5px;
	-moz-background-clip:border;
	-moz-background-origin:padding;
	-moz-background-inline-policy:continuous;
	color:white;
	background-color:#4690D6;
	cursor:pointer;
	height:auto;
	width:auto;
	line-height:100%;
	font-weight:bold;
	padding:5px;
	float:left;
	margin-left:10px;
	font-size:12px;
}

a.add-folder-button:hover{
	background-color:#0054A7;
	cursor:pointer;
	text-decoration:none;
}

#add-folder-div{
	margin:20px 10px 0px 10px;
}

/*#empty_folder{
	-moz-border-radius:5px;
        -moz-background-clip:border;
        -moz-background-origin:padding;
        -moz-background-inline-policy:continuous;
	background-color:#4690D6;
	margin-top:10px;
	color:white;
	padding:5px;
	min-width:150px;
	min-height:50px;
}*/

.ui-state-active{
	border:2px solid #333;
}

#loading_div{
	border:1px solid #909090;
	padding:10px;
	background-color:#FFFFFF;
	-moz-border-radius:5px;
	-moz-background-clip:border;
	-moz-background-origin:padding;
	-moz-background-inline-policy:continuous;
	position:absolute;
	zindex:10006;
	margin-left:30%;
	margin-top:10%;
	
}

/* Improved view for drag'n'drop */
#files_list .ui-draggable { border:1px outset grey; -webkit-border-radius:5px; -moz-border-radius:5px; }
#files_list .ui-draggable:hover .search_listing { background:transparent; }
#files_list .ui-draggable:hover { background:#fafafa; border:1px inset grey; }
