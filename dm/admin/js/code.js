function ExpandTree(el,getsubgrid) {    
    //event.preventDefault();
    var currentId = $(el).attr('id').substr(1);    
    if ($('#subgrid'+currentId).css('display')=='none') {
        $.ajax({url: getsubgrid+"?id="+currentId,success:function(result){
            $('#subgrid'+currentId).html(result);                
            }});            
        $('#subgrid'+currentId).show();
        $(el).html("-");
        $(el).removeClass("inline-button tree").addClass("inline-button-selected");
        $('tr#'+currentId+" td").css("font-weight","bold");
    }
    else {
        $('#subgrid'+currentId).hide();
        $(el).html("+");
        $(el).removeClass("inline-button-selected").addClass("inline-button tree");
        $('tr#'+currentId+" td").css("font-weight","normal");
        //$(el).css("background-color", "rgb(200,200,200)")
    }

} 