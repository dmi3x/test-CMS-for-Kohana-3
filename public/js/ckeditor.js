/* CK-EDITOR */
var CKinit = function (selector, CKOptions) {
    this.init(selector, CKOptions);
}

CKinit.prototype.settings = {
    "selector" : '.ckeditor'
}

CKinit.prototype.init = function(selector, CKOptions) {
    var self = this;
    var set = self.settings;

    set.selector = selector ? selector : set.selector;

    var options	= CKOptions ? CKOptions : {};

    $(document).ready(function(){
	if(typeof(CKEDITOR)!='undefined' && typeof(CKFinder)!='undefined') {
	    CKFinder.SetupCKEditor(null);
	}
	if(typeof(CKEDITOR)!='undefined') {
	    $(set.selector).ckeditor(options);
	}
    })    
}

CKinit.prototype.merge = function (my_defaults, my_options) {
    for(key in my_defaults) {
        if(typeof(my_options[key])=='undefined') {
            my_options[key] = my_defaults[key];
        }
    }
    return my_options;
}

CKinit.prototype.clone = function (obj){
    var self = this;
    
    if(obj == null || typeof(obj) != 'object') {
        return obj;
    }
    var temp = new obj.constructor();
    for(var key in obj) {
        temp[key] = self.clone(obj[key]);
    }
    return temp;
}