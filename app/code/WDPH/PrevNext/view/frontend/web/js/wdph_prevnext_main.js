require(["jquery"], function ($)
{
	$(document).ready(function()
	{
		$(".wdph-prev-next .wdph-prev, .wdph-prev-next .wdph-next").on('mouseenter', function()
		{
			if(!$(this).hasClass('visible'))
			{
				$(this).addClass('visible');
			}
		});
		$(".wdph-prev-next .wdph-prev, .wdph-prev-next .wdph-next").on('mouseleave', function()
		{
			if($(this).hasClass('visible'))
			{
				$(this).removeClass('visible');
			}
		});
	});
});