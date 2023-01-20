function flipflop( id ) {

   // id -- идентификатор элемента, который надо скрыть или показать

   // получаем этот элемент
   element = document.getElementById( id );

   // если таковой в документе существует
   if( element )   
    // меняем ему видимость
    element.style.display = element.style.display == "none" ? "" : "none";   
}

var result_tags = [];
var result_tags_invers = [];
var size = '3x2';
var pre_podborka = [];
var podborka = [];
var selected_in_podborka = [];
var mod = 'gallery';
function check_invers() {
  for (var i = 0; i < result_tags.length; i++) {
    e = document.getElementById(result_tags[i]);
    if($(e).data("inversed") == 0)
    {
      $(e).css("backgroundColor","#24B47E");
    }
    else
    {
      $(e).css("backgroundColor","rgb(228, 79, 79)"); 
    }
  }
}

function tag_invers(e)  {
  if(event.target.tagName == "LI")
  {
    var index = $(e).data("index");
    if ($(e).data("inversed") == 0)
    {
       $(e).data("inversed",1);
       $(e).attr("data-inversed",1)
       $(e).css("backgroundColor","rgb(228, 79, 79)");
       result_tags_invers[index] = 1;
    }
    else
    {
       $(e).data("inversed",0);
       $(e).attr("data-inversed",0);
       $(e).css("backgroundColor","#24B47E");
       result_tags_invers[index] = 0;
    }
    load();
  }
}

function load()  {
  var current_page = Number($('#current_page').data('val'));
  var ajaxurl = 'ajax.php';
  var result_tags_string = "";
  var result_tags_invers_string = "";
  var pre_podborka_string = "";
  var podborka_string = "";
  var selected_in_podborka_string = "";
  for (var i = 0; i < result_tags.length; i++) {
    result_tags_string += result_tags[i]+"|";
    result_tags_invers_string += result_tags_invers[i]+"|";
  }
  for(var i = 0; i < pre_podborka.length; i++)
  {
    pre_podborka_string += pre_podborka[i]+"|";
  }
  for (var i = 0; i < podborka.length; i++) {
    podborka_string += podborka[i]+"|";
  }
  for(var i = 0; i < selected_in_podborka.length; i++)
  {
    selected_in_podborka_string += selected_in_podborka[i]+"|";
  }
  data =  {'action': 'update_grid', 'current_page': current_page,'size':size,'result_tags':result_tags_string,'result_tags_invers':result_tags_invers_string,'pre_podborka':pre_podborka_string,'podborka':podborka_string,'selected_in_podborka': selected_in_podborka_string,'mod':mod}; 
  $.post(ajaxurl, data).done(function (response) {
    if(response != 'error') {
      $('#wrapping').html(response);
      $('#current_page').data('val',current_page).html(current_page).attr('data-val',current_page);
    }
    else {
      current_page-=1;
      $('#current_page').data('val',current_page).html(current_page).attr('data-val',current_page);
      load();
    } 
  });
}

function tag_delete(e)
{
  var index = result_tags.indexOf($(e).data("tag"));
  result_tags.splice(index, 1);
  result_tags_invers.splice(index, 1);
  $(".wrap").html("");
    for (var i = 0; i <=result_tags.length - 1; i++) {
      $(".wrap").append('<li class = "choose_item" id="'+result_tags[i]+'" data-inversed = '+result_tags_invers[i]+' data-index='+i+' onclick="tag_invers($(this))">'+result_tags[i]+'<button data-tag = "'+result_tags[i]+'" onclick="tag_delete($(this))">×</button></li>');
    }
  check_invers();
  load();
}

$(document).ready(function(){

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

  $('.wrap').on("click",".tag_group .group_name .kword_solo",function (){
    var index = result_tags.indexOf($(this).data("tag"));
    if (index >= 0) {
      result_tags.splice(index, 1);
      result_tags_invers.splice(index, 1);
    }
    else{
      result_tags.push($(this).data("tag"));
      result_tags_invers.push(0);
    }
    $("").html("");
    for (var i = 0; i <=result_tags.length - 1; i++) {
      $(".wrap").append('<li class = "choose_item" id="'+result_tags[i]+'" data-inversed = '+result_tags_invers[i]+' data-index='+i+' onclick="tag_invers($(this))">'+result_tags[i]+'<button data-tag = "'+result_tags[i]+'" onclick="tag_delete($(this))">×</button></li>');
    }
    check_invers();
    load();
  });

  $('.wrap ').on("click", ".tag_list li a",function (){
    var index = result_tags.indexOf($(this).data("tag"));
    if (index >= 0) {
      result_tags.splice(index, 1);
      result_tags_invers.splice(index, 1);
    }
    else{
      result_tags.push($(this).data("tag"))
      result_tags_invers.push(0);
    }
    $("").html("");
    for (var i = 0; i <=result_tags.length - 1; i++) {
      $(".wrap").append('<li class = "choose_item" id="'+result_tags[i]+'" data-inversed = '+result_tags_invers[i]+' data-index='+i+' onclick="tag_invers($(this))">'+result_tags[i]+'<button data-tag = '+result_tags[i]+'onclick="tag_delete($(this))">×</button></li>');
    }
    check_invers();
    load();
  });



   let but1 = document.getElementById('mod_gallery');
   let but2 = document.getElementById('mod_finder');
   let gallery = document.getElementById('gal_ins');
   let finder = document.getElementById('fin_ins');
   let size1 = document.getElementById('size_small');
   let size2 = document.getElementById('size_normal');
   let size3 = document.getElementById('size_big');
   let wrap = document.getElementById('wrapping');

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
      load();
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
      load();
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
      load();
   });

    $('.button').click(function (){
      var clickBtnValue = $(this).data('val');
      var current_page = Number($('#current_page').data('val'));
      if(clickBtnValue == "right") current_page+=1;
      else if (current_page!=1) current_page-=1;
      $('#current_page').data('val',current_page).attr('data-val',current_page);
      load();
    });
    
  $('#wrapping ').on("click",".photo_li", function(){
    var pic_id = $(this).data('id');
    if(mod == 'gallery')
    {
      var index = pre_podborka.indexOf(pic_id);
      if(podborka.indexOf(pic_id) < 0)
      {
        if(index>=0)
        {
          pre_podborka.splice(index,1);
          $(this).css('outline','none');
        }
        else
        {
          pre_podborka.push(pic_id);
          $(this).css('outline','3px solid red');
          $(this).css('outline-offset','-3px');
        }  
      }
    }
    else
    {
      var index = selected_in_podborka.indexOf(pic_id);
      if(index>=0)
      {
        selected_in_podborka.splice(index,1);
        $(this).css('outline','none');
      }
      else
      {
        selected_in_podborka.push(pic_id);
        $(this).css('outline','3px solid red');
        $(this).css('outline-offset','-3px');
      }  
    }
  });

  $('#mod_finder').click(function(){
    mod = "podborka";
    show_podborki();
    load();
  });

  $('#mod_gallery').click(function(){
    mod = "gallery";
    show_kwords();
    load();
  });
  $('#add_to_podborka').click(function(){
    for (var i = 0; i < pre_podborka.length; i++) {
      podborka.push(pre_podborka[i]);
    }
    pre_podborka = [];
    load();
  });

  $(".select_all").click(function(){
    var pictures = document.querySelectorAll('.photo_li');
    for (var i = 0; i < pictures.length; i++) {
      var pic_id = $(pictures[i]).data('id');
      var index = pre_podborka.indexOf(pic_id);
      if(podborka.indexOf(pic_id) < 0 || mod=='podborka')
      {
        if(index < 0)
        {
          if(mod == "gallery") pre_podborka.push(pic_id);
          else selected_in_podborka.push(pic_id);
          $(pictures[i]).css('outline','3px solid red');
          $(pictures[i]).css('outline-offset','-3px'); 
        }
      }  
    }
  });
  $(".unselect_all").click(function(){
    var pictures = document.querySelectorAll('.photo_li');
    for (var i = 0; i < pictures.length; i++) {
      var pic_id = $(pictures[i]).data('id');
      var index = pre_podborka.indexOf(pic_id);
      if(podborka.indexOf(pic_id) < 0 || mod=='podborka')
      {
        if(index>=0)
        {
          if(mod == "gallery") pre_podborka.splice(index,1);
          else selected_in_podborka.splice(index,1);
          $(pictures[i]).css('outline','none');
        }
      }  
    }
  });

  $("#delete_from_podborka").click(function(){
    var index = 0;
    for (var i = 0; i < selected_in_podborka.length; i++) {
      index = podborka.indexOf(selected_in_podborka[i]);
      podborka.splice(index,1);
    }
    selected_in_podborka = [];
    load();
  });

  $("#save_podborka").click(function(){
    if(podborka.length > 1)
    {
      $("#name_podborka_form_back").css('display','flex');  
    }
    else
    {
      alert("Невозможно сохранить пустую подборку или подборку из одного изображения");
    }

  });
  $("#name_podborka_form_back").click(function(event){
    if(event.target == this) {
      $("#name_podborka_form_back").css('display','none');
    }
  });

  $("#create_podborka").click(function(){
      var ajaxurl = 'ajax.php';
      var podborka_string = [];
      for(var i = 0; i < podborka.length;i++)
      {
        podborka_string+=podborka[i]+"|";
      }
     data =  {'action': 'save_podborka','name_podborka':$('#podborka_name').val(), 'podborka': podborka_string}; 
     $.post(ajaxurl, data).done(function (response) {
      $("#response").html(response);
     });
  });

  function show_podborki()
  {
    alert("КАЙФ");
   var ajaxurl = 'ajax.php';
   data =  {'action': 'show_podborki','active_podborka':""}; 
   $.post(ajaxurl, data).done(function (response) {
    $(".list_of_groups").html(response);
   });
  }
  
  function show_kwords()
  {
    var ajaxurl = 'ajax.php';
    data =  {'action': 'show_kwords'}; 
    $.post(ajaxurl, data).done(function (response) {
      $(".list_of_groups").html(response);
    }); 
  }

  show_kwords();
  load();
});