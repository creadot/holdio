function fancyInput() {
	$('.input-fancy')
		.focusin(function(){
			$(this).addClass('has-value');
		})
		.focusout(function(){
			if(!$(this).find(".input").val().length > 0) {
				$(this).removeClass('has-value');
			}
		});

	$('.input-fancy').each(function(index, el) {
		if($(el).find(".input").val().length > 0) {
			$(el).addClass('has-value');
		}
	});

	$('.input-fancy').each(function(index, el) {
		if($(el).find(".input").val().length > 0) {
			$(el).addClass('has-value');
		}
	});
}

fancyInput();


// // Textarea
// function calcHeight(value) {
//   let numberOfLineBreaks = (value.match(/\n/g) || []).length;
//   // min-height + lines x line-height + padding + border
//   let newHeight = 25 + numberOfLineBreaks * 20 + 10 + 5;
//   return newHeight;
// }

// let textarea = document.querySelector(".wpcf7-textarea");

// if (textarea) {
//   textarea.addEventListener("keyup", () => {
//     textarea.style.height = calcHeight(textarea.value) + "px";
//     textarea.style.maxHeight = calcHeight(textarea.value) + "px";
//   });
// };

// // checkbox
// $(function() {
  
//   var span = $('.wpcf7-list-item span');
  
//   //span click event
//   span.on('click', function() {
//     var checkbox = $(this).parent().find('input[type="checkbox"]');
//     checkbox.prop('checked', !checkbox.prop('checked'))
//   });
  
//   //checkbox click event
//   $('input[type="checkbox"]').on('click', function() {
//     $(this).parent().prop('checked', !$(this).prop('checked'))
//   });
  
// });