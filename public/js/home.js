/**
 * Created by apple on 2016/12/2.
 */

// easyUI tabs 只能按照 title index 标识 tabs 不能按照id进行唯一标识 ,因此title不能一样

function initMenu(_menus) {
    $(".menu").empty();
    $.each(_menus, function(i, n) {
        var menubox = "";
        menubox += '<ul>';
        if(n.children == undefined){
            n.children = new Array();
        }
        $.each(n.children, function(j, o) {
            menubox += '<li><div><div class="icon-s '+o.icon+'" >&nbsp;</div>&nbsp;&nbsp;<a id="handler-' + o.id + '" href="/handler/' + o.id + '" ><span>' + o.name + '</span></a></div></li> ';
        });
        menubox += '</ul></div>';
        $(".menu").accordion('add',{
            title:n.name,
            content:menubox,
            iconCls:n.icon
        });

    });
    $('.menu li a').click(function(){
        var tabTitle = $(this).text();
        var url = $(this).attr("href");
        var id = $(this).attr("id");
        openTab(tabTitle,url,id);
        $('.menu li div').removeClass("selected");
        $(this).parent().addClass("selected");
        return false;
    }).hover(function(){
        $(this).parent().addClass("hover");
    },function(){
        $(this).parent().removeClass("hover");
    });
    $(".menu").accordion('select',0);
}
// 工作面板添加新的tab页
function openTab(subtitle,url,id){
    if(!$('#work-panel').tabs('exists',subtitle)){
        $('#work-panel').tabs('add',{
            title:subtitle,
            href:url,
            closable:true,
            width:$('#work-panel').width()-10,
            height:$('#work-panel').height()-26
        });
    }else{
        $('#work-panel').tabs('select',subtitle);
    }
    window.location.hash = id;
}
