function flipflop( id )
{

   // id -- идентификатор элемента, который надо скрыть или показать

   // получаем этот элемент
   element = document.getElementById( id );

   // если таковой в документе существует
   if( element )   
    // меняем ему видимость
    element.style.display = element.style.display == "none" ? "" : "none";   
}

function tag_invers(e)
{
  if ($(e).data("selected") == "0")
  {
     $(e).data("selected",1);
     $(e).attr("data-selected",1)
     $(e).css("backgroundColor","rgb(228, 79, 79)");
  }
  else
  {
     $(e).data("selected",0);
     $(e).attr("data-selected",0);
     $(e).css("backgroundColor","#24B47E");
  }
}

$(document).ready(function(){
    var result_tags = [];
    $(".pic img").click(function(){
        $("#bigPic").fadeIn(100);
        $("#bigPic div img").attr("src",$(this).attr("src"));
    });
    $("#bigPic div").click(function(arg) {
      if(this == arg.target)
      {
        $("#bigPic").fadeOut(100);
      }
    });

  $('.tag_list li a').click(function(){
    var index = result_tags.indexOf($(this).data("tag"));
    if (index >= 0) {
      result_tags.splice(index, 1);
    }
    else{
      result_tags.push($(this).data("tag"))
    }
    $(".wrap").html("");
    for (var i = 0; i <=result_tags.length - 1; i++) {
      $(".wrap").append('<li class = "choose_item" data-selected = "0" onclick="tag_invers($(this))">'+result_tags[i]+'</li>');
    }
  });

   let but1 = document.getElementById('mod_gallery');
   let but2 = document.getElementById('mod_finder');
   let gallery = document.getElementById('gal_ins');
   let finder = document.getElementById('fin_ins');
   let size1 = document.getElementById('size_small');
   let size2 = document.getElementById('size_normal');
   let size3 = document.getElementById('size_big');
   let wrap = document.getElementById('wrapping');

   var size = '3x2';

   $(but1).click(function()
   {
      but1.style.backgroundColor = "#24B47E";
      but2.style.backgroundColor = "#181818";
      finder.style.display = "none";
      gallery.style.display = "block";
   });

   $(but2).click(function()
   {
      but1.style.backgroundColor = "#181818";
      but2.style.backgroundColor = "#24B47E";
      gallery.style.display = "none";
      finder.style.display = "block";
   });



   $(size1).click(function()
   {
      size1.style.backgroundColor = "#24B47E";
      size2.style.backgroundColor = "#181818";
      size3.style.backgroundColor = "#181818";
      wrap.style.gridTemplateColumns = "repeat(5, 1fr)";
      wrap.style.gridTemplateRows = "repeat(4, 1fr)";
      limit_of_pages = 20;
      $(".name").css("padding-bottom", "2px" );
      size = '5x4';
      preload();
   });

   $(size2).click(function()
   {
      size2.style.backgroundColor = "#24B47E";
      size1.style.backgroundColor = "#181818";
      size3.style.backgroundColor = "#181818";
      wrap.style.gridTemplateColumns = "repeat(4, 1fr)";
      wrap.style.gridTemplateRows = "repeat(3, 1fr)";
      limit_of_pages = 12;
      $(".name").css("padding-bottom", "6px");
      size='4x3';
      preload();
   });

   $(size3).click(function()
   {
      size3.style.backgroundColor = "#24B47E";
      size1.style.backgroundColor = "#181818";
      size2.style.backgroundColor = "#181818";
      wrap.style.gridTemplateColumns = "repeat(3, 1fr)";
      wrap.style.gridTemplateRows = "repeat(2, 1fr)";
      limit_of_pages = 6;
      $(".name").css("padding-bottom", "8px");
      size='3x2';
      preload();
   });

    $('.button').click(function (){
           var clickBtnValue = $(this).data('val');
           var current_page = Number($('#current_page').data('val'));
           if(clickBtnValue == "right") current_page+=1;
           else if (current_page!=1) current_page-=1;
           var ajaxurl = 'ajax.php';
           data =  {'action': 'update_grid', 'current_page': current_page,'size':size};
           $.post(ajaxurl, data, function (response) {
              if(response != 'error') {
                alert(response);
                $('#wrapping').html(response);
                $('#current_page').data('val',current_page).html(current_page).attr('data-val',current_page);
              }
              else {
                current_page-=1;
              } 
           });
    });
    function preload()
    {
      var current_page = Number($('#current_page').data('val'));
      $('#current_page').data('val',current_page).html(current_page).attr('data-val',current_page);
      var ajaxurl = 'ajax.php';
      data =  {'action': 'update_grid', 'current_page': current_page,'size':size};   
      $.post(ajaxurl, data, function (response) {
        if(response != 'error') $('#wrapping').html(response);
        else {
          $('#current_page').data('val',current_page-1).html(current_page-1).attr('data-val',current_page-1);
          preload();
        } 
      });
    }
    preload();
});