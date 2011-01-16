var urlGenerator = function (options) {    
    this.init(options);
}

urlGenerator.prototype.defaults = {
    "generate"  : '.generateUrl',
    "change"    : '.changeUrl',
    "fullUrl"   : '.fullUrl',
    "alias"     : '[name=alias]',
    "parentUrl" : '.parentUrl',
    "name"      : '[name=name]'
}

urlGenerator.prototype.settings = {}

urlGenerator.prototype.init = function(options)
{ 
    var self = this;
    var set = self.settings;

    options = $.extend({}, self.defaults, options);
  
    set.generate = $(options.generate, options.form);
    set.change = $(options.change, options.form);
    set.fullUrl = $(options.fullUrl, options.form);
    set.alias = $(options.alias, options.form);
    set.parentUrl = $(options.parentUrl, options.form);
    set.name = $(options.name, options.form);
    
    //self.extend(set, options)

    $(set.generate).click(function() {
	self.update(set.name.val());
	return false;
    });

    $(set.change).click(function() {
	self.change();
	return false;
    });    
}

//urlGenerator.prototype.extend = function(obj, prop)
//{
//    if(!prop) {prop = obj;obj = this;}
//    for ( var i in prop ) {obj[i] = prop[i];}
//}

urlGenerator.prototype.update = function(alias)
{
    var self = this;
    var set = self.settings;

    alias = alias ?  self.transform(alias) : self.transform(set.name.val());

    set.alias.val(alias);

    var parentUrl = trim(set.parentUrl.val(), '/');

    if(parentUrl!='') {
	parentUrl = '/'+parentUrl;
    }
    set.fullUrl.val(parentUrl + '/' + alias);
}

urlGenerator.prototype.change = function()
{
    var self = this;
    var set = self.settings;
    
    var alias = prompt('Address mast contain only latin or numbers or symbols _-', set.alias.val());
    if(alias===null) {
	return;
    }
    self.update(alias);
}

urlGenerator.prototype.transform = function(str)
{
    var newStr='';
    var arr = {'ё':'e','й':'i','ц':'c','у':'y','к':'k','е':'e','н':'n','г':'g','ш':'sh','щ':'sh','з':'z','х':'h','ъ':'','ф':'f','ы':'i','в':'v','а':'a','п':'p','р':'r','о':'o','л':'l','д':'d','ж':'j','э':'e','я':'ya','ч':'ch','с':'s','м':'m','и':'i','т':'t','ь':'','б':'b','ю':'u'};
    str = str.toLocaleLowerCase();
    for (i=0;i<str.length;i++)
    {
       if (typeof(arr[str.charAt(i)])!=='undefined') {
	   newStr += arr[str.charAt(i)];
       }
       else {
	   newStr += str.charAt(i);
       }
    }
    newStr = newStr.replace(/\s+/g,'-');
    newStr = newStr.replace(/-+/g,'-');
    newStr = newStr.replace(/[^a-z0-9_-]/g,'');
    return newStr;
}