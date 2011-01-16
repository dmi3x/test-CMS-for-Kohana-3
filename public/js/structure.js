var selectedItemID = 0;
var currentFolderID = 0;
var treeStructure;
var treeConfigObj = eval("(" + structureTreeConfig + ")");

$(function () {

	var config = {
		"plugins": {
			"cookie" : {
				"prefix" : "jstree_structure_",
				"options" : {
					"expires": false,
					"path": '/',
					"domain": false,
					"secure": false
				}
			}
		},
		"rules" : {
			"valid_children" : [ "root" ]
		},
		"types" : {
			"root": {
				"valid_children" : [ "folder" ],
				"draggable" : false,
				"icon" : {
					"image" : "/public/images/admin/modules/root.png"
				}
			},
			"folder": {
				"draggable" : false,
				"icon" : {
					"image" : "/public/images/admin/modules/menu.gif"
				}
			}

		},
		"callback": {
			"onmove" : function (NODE,REF_NODE,TYPE,TREE_OBJ,RB) {
				saveTreeStructure();
			}
		}
	};

	for(alias in treeConfigObj) {
	    config.types[alias] = {};
	    config.types[alias]['max_depth'] = treeConfigObj[alias]['max_depth'];
	    config.types[alias]['draggable'] = treeConfigObj[alias]['draggable'];
	    config.types[alias]['icon'] = {}
	    config.types[alias]['icon']['image'] = treeConfigObj[alias]['icon'];
	    config.types[alias]['valid_children'] = treeConfigObj[alias]['valid_children'];
	}
	$("#menusTree").tree(config);
	
	$('#createMenuItemDialog').dialog({autoOpen: false, width: 610, height: 290, modal: true, close: function(event, ui) {$('#createMenuItemDialog').html('');}});
	
	if ($("#menusTree a.clicked").length > 0) {
		onTreeItemClick ($("#menusTree a.clicked"), 'not_redirect');
	}
});

// Action on tree click (select)
function onTreeItemClick (obj, not_redirect)
{
	var moduleAlias = obj.parent().attr('rel');
	var n = (moduleAlias == 'folder') ? 6 : 4;
	if(moduleAlias!="root") {
	    var id = obj.parent().attr('id').substr(n);	    
	    selectedItemID  = id;
	    currentFolderID = 0;
	    if(moduleAlias == 'folder') {
		selectedItemID  = 0;
		currentFolderID = id;
	    }
//	    if(module == 'root') {
//		selectedItemID  = 0;
//		currentFolderID = 0;
//	    }
	}
	module = {};
	if(treeConfigObj[moduleAlias]) {
	   module = treeConfigObj[moduleAlias];
	}

	var e = "";
	var d = "";
	var c = "";
	
	if(module.delete_mode=='deny') {
	    d = "disabled";
	}
	if (moduleAlias == "root" || moduleAlias == "folder")   {
	    d = e = "disabled";
	}

	if (!module.isDefault && moduleAlias != "folder" && moduleAlias != "root") {
	    c = "disabled";
	}

	//$("#editMenuItemBtn").attr('disabled', e);
	$("#deleteMenuItemBtn").attr('disabled', d);	
	$("#createMenuItemBtn").attr('disabled', c);

	not_redirect = !(typeof(not_redirect)=='undefined');
	if(!not_redirect && e == "" && selectedItemID > 0) {
	    editMenuItem();
	}
}

// Action for Delete Button
function deleteMenuItem() 
{
	if (!confirm("Realy delete?")) return false;
	window.location = "/admin/structure/delete/" + selectedItemID;
	return true;
}

// Action for Edit Button
function editMenuItem() 
{
	var url = '';
	var module = $('#item' + selectedItemID).attr('rel');
	if(!treeConfigObj[module]) {
	    return false;
	}

	switch(treeConfigObj[module].edit_mode) {
	    case 'module':
		url = "/admin/" + module;
		break;
	    case 'linked':
		url = "/admin/" + module + '/index/' + selectedItemID;
		break;
	    default:
		url = "/admin/structure/edit/" + selectedItemID;
	}

	if(window.location.pathname != url) {
	    window.location.href = url;
	}
	return false;
}

// Action for Create Button
function showCreateMenuItemDialog()
{
	$('#createMenuItemDialog').dialog('open');
	$("#createMenuItemDialog").html('<div id="modalWindowLoader"></div>');
	$("#createMenuItemDialog").load('/admin/structure/add/' + selectedItemID, function()
	{
		$('#createMenuItemDialog input[name=folderId]').val(currentFolderID);
	});
	return false;
}

// Parse Tree Structure to String
function getTreeStructure(parentID, menuID)
{
	var structure = "";

	var selector = "#menusTree li:first ul:first > li";
	if (parentID > 0) {
	    selector = "#menusTree li#item" + parentID + " ul:first > li";
	}
	if (menuID > 0) {
	    selector = "#menusTree li#folder" + menuID + " ul:first > li";
	}

	$(selector).each(function (pos)
	{
	    var itemID = 0;
	    var setMenuID = 0;

	    if(parentID == -1) {
		 setMenuID = $(this).attr("id").substr(6);
	    }
	    else {
		itemID = $(this).attr("id").substr(4);
		structure += parentID + "," + itemID + "," + pos + "," + menuID + "|";
	    }

	    structure += getTreeStructure(itemID, setMenuID);
	});

	return structure;
}

// Save Tree Structure to Database
function saveTreeStructure()
{
	$("#menusTree li:first a:first").append('<img id="loader" src="/images/admin/loader2.gif" />');
	
	var structure = getTreeStructure(-1, 0);
	
	$.post("/admin/structure/saveTreeStructure", {structure: structure}, function(r)
	{
		if (r != 1) {
		    alert(r);
		    window.location.reload();
		}
		$("#menusTree li:first a:first img").remove();
	});
}