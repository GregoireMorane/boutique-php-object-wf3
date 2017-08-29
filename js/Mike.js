$(function()
{
	$.ajax(
	{
		url:"http://localhost/gregoire_morane/php-object/php-object-wf3/single/"+idItem,
		method:"POST"
	})
	.done(function(data)
	{
		var data = JSON.parse(data);
		$('#listPicture').html("");
		$('#tabs-3').html("");
		for(var i = 0; i < data.pictures.length; i++)
		{
			$('#listPicture').append("<a href="+data.pictures[i].url+"><img src="+data.pictures[i].url+" alt=''></a>");
		}
		for(var i = 0; i < data.reviews.length; i++)
		{
			$('#tabs-3').append("<p><strong>Username: "+data.reviews[i].username+"</strong></p>");
			$('#tabs-3').append("<p>Reviews: "+data.reviews[i].commentaire+"</p>");
			$('#tabs-3').append("<p>Note: "+data.reviews[i].note+" Stars</p></br>");
		}
	})
	.fail(function()
	{

	})
});