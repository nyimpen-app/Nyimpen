function textBlur(element, defaultValue, classname) {

	var currentValue = jQuery.trim($(element).val());
	
	$(element).focus(function() {
		currentValue = jQuery.trim($(this).val());

		if (currentValue == defaultValue || currentValue.length == 0) {
			$(this).val('');
			//$(this).removeClass('mm_watermark');
			$(this).removeClass(classname);
		}
	});

	$(element).blur(function() {
		currentValue = jQuery.trim($(this).val());

		if (currentValue.length == 0) {
			$(this).val(defaultValue);
			//$(this).addClass('mm_watermark');
			$(this).addClass(classname);
		}
	});
}
