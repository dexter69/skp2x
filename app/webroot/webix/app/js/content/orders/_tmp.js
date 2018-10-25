/*
{

url:function(details){
    return webix.ajax("data.php?filterByUser="+userId).then(function(data){
        var js = data.json();
        var new_js = [];

        for (key in js){
            new_js.push({
                id:key, 
                name:js[key].name
            });
        };

        return new_js;
    })
}

}
*/