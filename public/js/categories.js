var selectedItemID = 0;
var currentFolderID = 0;
var treeStructure;
var prevParentId;
	
$(function () {
	$("#catalogTree").tree({
		"plugins": {
			"cookie" : {
				"prefix" : "jstree_",
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
				"draggable" : false,
			    	"max_depth" : 3,
				"valid_children" : [ "categoryFull", "categoryEmpty" ],
				"icon" : {
					"image" : "/public/images/admin/root.png"
				}
			},
			"categoryFull": {
				"valid_children" : [ "categoryFull", "categoryEmpty" ]
			},
			"categoryEmpty": {
				"valid_children" : [ "categoryFull", "categoryEmpty" ],
				"icon" : {
					"image" : "/public/images/admin/menu.gif"
				}
			}
		},
		"callback": {
			"beforemove" : function(NODE,REF_NODE,TYPE,TREE_OBJ,RB) {
			    prevParentId = $(TREE_OBJ.parent(NODE)).attr('id');			    
			    return true;
			},
			"onmove" : function (NODE,REF_NODE,TYPE,TREE_OBJ,RB) {
			    var id = $(TREE_OBJ.get_node(NODE)).attr("id");
			    var parentId = $(TREE_OBJ.parent(NODE)).attr("id");
			    //alert('prev:' + prevParentId + ' curr:' + parentId);
			    saveTree(id, parentId, prevParentId, RB);
			}
		}
	});	
	
	$('#createTreeItemDialog').dialog({autoOpen: false, width: 610, height: 290, modal: true, close: function(event, ui) {$('#createMenuItemDialog').html('');}});
	if ($("#catalogTree a.clicked").length > 0) {
		onTreeItemClick ($("#catalogTree a.clicked"), 'not_redirect');
	}
	$("#catalogTree .loader").hide();
});

// Action on tree click (select)
function onTreeItemClick (obj, not_redirect)
{   
	var id = obj.parent().attr('id').substr(4);
	if(id==selectedItemID) {
	    return;
	}
	selectedItemID = id;

	var d = 'disabled';
	if(selectedItemID>0) {
	    d = '';
	}

	$('#deleteMenuItemBtn').attr('disabled', d);

	not_redirect = !(typeof(not_redirect)=='undefined');
	
	if(!not_redirect) {
	    editTreeItem();
	}
}

// Action for Delete Button
function deleteTreeItem()
{
	if (!confirm("Realy delete?")) return false;
	window.location = "/admin/catalog/delete/" + selectedItemID;
	return true;
}

// Action for Edit Button
function editTreeItem()
{
        var url = "/admin/catalog/index/" + selectedItemID;

	if(window.location.pathname != url) {
	    window.location.href = url;
	}
	return false;
}

// Parse Tree Structure to String
function getPositions(parentId)
{
	var  selector = "#catalogTree li#" + parentId + " ul:first > li";
	if (parentId=='') {
	    selector = "#catalogTree ul:first li:first ul:first > li";
	}
	var positions = {};
	$(selector).each(function (pos)	{
	    var itemIdNum = $(this).attr("id").substr(4);
	    positions[pos] = itemIdNum;
	});
	return positions;
}

// Save Tree Structure to Database
function saveTree(id, parentId, prevParentId, RB)
{
	$("#catalogTree .loader").show();

	// 1. Составляем список позиций в branch
	var data = {};
	data['positions'] = getPositions(parentId);
	data['parentId'] = parentId.substr(4);
	data['moveId'] = 0;
	if(parentId!=prevParentId) {
	    // 2. Передаём id категории, которую переместили
	    data['moveId'] = id.substr(4);
	}

	data = "data=" + JSON.stringify(data);

	$.ajax({
	    "url" : "/admin/catalog/saveTree", 
	    "data": data,
	    "type": "POST",
	    "success": function(r) {
		if (r != 1) {
		    alert(r);
		    //window.location.reload();
		    $.tree.rollback(RB);
		}
	    },
	    "complete": function() {
		$("#catalogTree .loader").hide();
	    }
	});
}

// Action for Create Button
function showCreateTreeItemDialog()
{
	$('#createTreeItemDialog').dialog('open');
	$("#createTreeItemDialog").html('<div id="modalWindowLoader"></div>');
	$("#createTreeItemDialog").load("/admin/catalog/addCategory/"+selectedItemID , function() {
		//$('#createTreeItemDialog input[name=parent_id]').val(selectedItemID);
	});
	return false;
}
