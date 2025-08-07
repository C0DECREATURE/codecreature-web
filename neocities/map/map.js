window.addEventListener('load', function() {
	var navLinks = document.getElementById('nav').getElementsByClassName('jump-link');
	for (var i = 0; i < navLinks.length; i++) {
		var navLink = navLinks[i];
		var name = navLink.dataset.name;
		
		navLink.innerHTML = name;
		navLink.id = name+"-jump-link";
		
		// create section for properties
		var propertiesEl = document.createElement('div');
		propertiesEl.classList.add('properties');
		propertiesEl.ariaLabel = navLink.innerHTML + " page properties: ";
		// add properties element to parent of nav link
		navLink.parentNode.appendChild(propertiesEl);
		
		var properties = navLink.dataset.properties.split(" ");
		
		// for each property in this links data-properties
		properties.forEach(function(prop){
			// if property is not empty
			if (prop) {
				var propEl = document.createElement('button');
				propEl.classList.add("property-icon"); // add base property class
				propEl.classList.add(prop); // add property as class
				
				// add corresponding image to property element
				var img = document.createElement('img');
				img.src = prop + ".png";
				img.alt = prop.replaceAll('-',' ');
				img.title = prop.replaceAll('-',' ');
				propEl.appendChild(img);
				
				// add property element to properties section
				propertiesEl.appendChild(propEl);
			}
		});
		
		// nav links focus corresponding map element on click
		navLink.addEventListener('click', function() {
			var id = this.dataset.name.replaceAll(' ','-');
			window.location.hash = id;
			document.getElementById(id).focus();
		});
	}
	
	// set up map links
	var mapLinks = document.getElementById('map').getElementsByClassName('link');
	for (var i = 0; i < mapLinks.length; i++) {
		var a = mapLinks[i];
		a.ariaLabel = a.id.replaceAll(' ','-');
		a.addEventListener('focus', function() {
			// scroll into view when focused
			this.scrollIntoView({block:'center'});
			// put pointer on corresponding jump link
			var jumpLink = document.getElementById(this.id+"-jump-link");
			jumpLink.insertBefore(document.getElementById('pointer'),jumpLink.firstChild);
		});
	}
	
	// if the page url points to an element, focus that element
	var hashId = window.location.hash.replaceAll("#","");
	if (hashId && hashId != "") {
		var focusEl = document.getElementById(hashId);
		if (focusEl) { focusEl.focus(); }
	}
	
}, true);