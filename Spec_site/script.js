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

$(document).ready(function(){
	let current_page = 1;
	update_grid();
	$(".left").click(function()
	{
		if(current_page != 1)
		{
			current_page--;
			update_grid();
		}
	});
	$(".right").click(function()
	{
		current_page++;
		update_grid();
	});
	
	function update_grid()
	{
		let res = "";
		for(var i = 1; i <= 6; i++)
		{
			if((current_page-1)*6+i < 10)
			{
				res += '<li class = "photo_li" id = "img_00'+((current_page-1)*6+i)+'"><div class = "photo"></div><div class = "name">Название</div></li>';
			}
			else
			{
				if((current_page-1)*6+i < 100)
				{
					res += '<li class = "photo_li" id = "img_0'+((current_page-1)*6+i)+'"><div class = "photo"></div><div class = "name">Название</div></li>'
				}
				else
				{
					res += '<li class = "photo_li" id = "img_'+((current_page-1)*6+i)+'"><div class = "photo"></div><div class = "name">Название</div></li>'	
				}
			}
		}
		$(".photos").html(res);
		$("#current_page").html(current_page);
	}

   let but1 = document.getElementById('mod_gallery');
   let but2 = document.getElementById('mod_finder');
   let gallery = document.querySelector('.photos');
   let buttons = document.querySelector('.left_right_but');
   let photos = document.querySelectorAll('.photo_li');

   $(document).on('click', 'li[class^="photo_li"]', function(e)
   {
      e.preventDefault();
      if (this.data("selected") != "1") 
      {
         this.data("selected") = "1";
         this.style.border = "1px solid blue";
      }
      else
      {
         this.data("selected") = "0";
         this.style.border = "none";
      }
   });

   $(but1).click(function()
   {
      but1.style.backgroundColor = "#24B47E";
      but2.style.backgroundColor = "#181818";
      gallery.style.display = "grid";
      buttons.style.display = "flex";
   });

   $(but2).click(function()
   {
      but1.style.backgroundColor = "#181818";
      but2.style.backgroundColor = "#24B47E";
      gallery.style.display = "none";
      buttons.style.display = "none";
   });
});