$(document).ready(function(){

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
	let current_list = 1;
	update_grid();
	$(".left").click(function()
	{
		if(current_list!=1)
		{
			current_list--;
			update_grid();
		}
	});
	$(".right").click(function()
	{
		current_list++;
		update_grid();
	});
	
	function update_grid()
	{
		let res = "";
		for(var i = 1; i <= 6; i++)
		{
			if((current_list-1)*6+i < 10)
			{
				res += '<li class = "photo_li" id = "img_00'+((current_list-1)*6+i)+'"><div class = "photo"></div><div class = "name">Название</div></li>';
			}
			else
			{
				if((current_list-1)*6+i < 100)
				{
					res += '<li class = "photo_li" id = "img_0'+((current_list-1)*6+i)+'"><div class = "photo"></div><div class = "name">Название</div></li>'
				}
				else
				{
					res += '<li class = "photo_li" id = "img_'+((current_list-1)*6+i)+'"><div class = "photo"></div><div class = "name">Название</div></li>'	
				}
			}
		}
		$(".photos").html(res);
		$("#current_page").html(current_list);
	}
});