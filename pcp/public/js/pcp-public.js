	document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('apply-filter-btn').addEventListener('click', function() {
			var size_checkboxes = document.querySelectorAll('.size-filter:checked');
			var color_checkboxes = document.querySelectorAll('.color-filter:checked');
			var size_filterValues = [];
			var color_filterValues = [];
			size_checkboxes.forEach(function(checkbox) {
				size_filterValues.push(checkbox.getAttribute("data-size"));
			});
			color_checkboxes.forEach(function(checkbox) {
				color_filterValues.push(checkbox.getAttribute("data-color"));
			});
			var size = size_filterValues;
			var color = color_filterValues;
			var params = 'size_filterValues=' + size + '&color_filterValues=' + color +  '&action=apply_filters' + '&security=' + pcp_ajax_object.nonce;
			var ajaxURL = pcp_ajax_object.ajax_url;
			var xhr = new XMLHttpRequest();
			xhr.open('POST', ajaxURL, true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status === 200) {
					var jsonObject = JSON.parse(xhr.responseText);
					var elements = document.getElementsByClassName("flex-item");
					while (elements.length > 0) {
							elements[0].parentNode.removeChild(elements[0]);
					}
					var elements = document.getElementsByClassName("flex-container");
					for (var i = 0; i < elements.length; i++) {
							elements[i].innerHTML += jsonObject.html;
					}
				}
			};
			xhr.send(params);
			
			});
	});