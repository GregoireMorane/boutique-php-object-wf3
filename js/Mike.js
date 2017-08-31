$(function()
{

	let filter = {price : undefined, categorie : undefined};

	function singleItem()
	{
		$.ajax(
		{
			url:"http://localhost/gregoire_morane/php-object/php-object-wf3/single/"+idItem,
			method:"POST"
		})
		.done(function(data)
		{
			data = JSON.parse(data);
			console.log(data);
			$("div.sp-wrap").html("");
			$('#tabs-3').html("");
			for(var i = 0; i < data.pictures.length; i++)
			{
				$("div.sp-wrap").append("<a href="+data.pictures[i].url+"><img src="+data.pictures[i].url+" alt=''></a>");
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

		});
	}

	function shopListItem()
	{
		$("span.ui-slider-handle.ui-state-default.ui-corner-all")
			.mouseup(function()
			{
				filter.price = $("#amount").val();
				filter.price = filter.price.replace("$", "");
				filter.price = filter.price.replace("$", "");
				filter.price = filter.price.replace("-", "and");
				runFilter();
			})

		$("li.shop-categories-item")
			.click(function()
			{
				filter.categorie = $(this).attr("id").split("-")[1];
				runFilter();
			})

		function runFilter()
		{
			$.ajax(
			{
				url:"http://localhost/gregoire_morane/php-object/php-object-wf3/shop-list",
				method:"POST",
				data:filter
			})
			.done(function(data)
			{
				data = JSON.parse(data);
				$("div.shop-list").html("");
				for(var i = 0; i < data.length; i++)
				{
					var html = "<div class='grid-item2 mb30'>  <div class='row'>  <div class='arrival-overlay col-md-4'> <a href='" + hostDomaine + "single/" + data[i].iditems + "'> <img src='" + data[i].url + "' alt=''> </a> </div>  <div class='col-md-8'> <div class='list-content'>  <h1> <a href='" + hostDomaine + "single/" + data[i].iditems + "'> " + data[i].libelle + " </a> </h1>  <div class='list-midrow'>  <ul> <li><span class='low-price'>" + data[i].price + "€</span></li> </ul>  <img src='upload/stars.png' alt=''>  <div class='reviews'><a href='#'>21 Rewiew(s)</a> / <a href='#'>Add a Review</a></div> <div class='clear'></div> </div>  <p class='list-desc'>" + data[i].description + "</p>  <div class='list-downrow'>  <a href='#' class='medium-button button-red add-cart' id='items-" + data[i].iditems + "'>Add to Cart</a>  <ul> <li><a href='#' class='wishlist'><i class='fa fa-heart'></i> Add to Wishlist</a></li> <li><a href='#' class='compare'><i class='fa fa-retweet'></i>Add to Compare</a></li> </ul> <div class='clear'></div>    </div>  </div> </div>  </div>  </div>";
					$("div.shop-list").append(html);
					$("a#items-" + data[i].iditems + ".medium-button.button-red.add-cart").data("item", data[i]);
				}
				listerEven();
			})
			.fail(function()
			{

			});
		}
	}

	switch (typePage)
	{
		case 1:
			singleItem();
		break;
		case 2:
			shopListItem();
		break;
		default:
			console.log("OK");
	}
	function listerEven()
	{
		$("a.medium-button.button-red.add-cart")
			.click(function(e)
			{
				e.preventDefault();
				var datalocal = localStorage.getItem("cart");
				datalocal = JSON.parse(datalocal);
				if(datalocal == null)
				{
					datalocal = [];
				}
				var item = $(this).data().item;
				console.log(item);
				var update = false;
				for(var i = 0; i < datalocal.length; i++)
				{
					if(datalocal[i].iditems == item.iditems)
					{
						datalocal[i].qte += 1;
						update = true;
						break;
					}
				}

				if(!update)
				{
					item.qte = 1;
					datalocal.push(item);
				}
				localStorage.setItem("cart", JSON.stringify(datalocal))
				console.log(update);
				console.log($(this).data());
			})
	}

	function listerCart()
	{
		var datalocal = localStorage.getItem("cart");
		datalocal = JSON.parse(datalocal);
		$("div.hover-cart").html("");
		var priceTotal = 0;
		for(var i = 0; i < datalocal.length; i++)
		{
			var html ="<div class='hover-box'> <a href='"+hostDomaine+"single/"+datalocal[i].url+"'><img src='"+datalocal[i].url+"' alt='' class='left-hover'></a> <div class='hover-details'> <p>"+datalocal[i].price+"</p> <span>"+datalocal[i].price*datalocal[i].qte+"$</span> <div class='quantity'>Quantity: "+datalocal[i].qte+"</div> </div> <a href='#' class='right-hover'><img src='<?php echo HOST.FOLDER ?>images/delete.png' alt=''></a> <div class='clear'></div> </div>";
			priceTotal += (datalocal[i].price*datalocal[i].qte);
			$("div.hover-cart").append(html);
		}
		$("div.hover-cart").append("<div class='subtotal'> Cart Subtotal: <span>"+priceTotal+"$</span> </div>  <button class='viewcard'> View Cart</button> <button class='proceedcard'> Proceed</button>");
	}

	$("div.card-icon").click(function()
	{
		listerCart();
	})

	listerEven();
	listerCart();
});