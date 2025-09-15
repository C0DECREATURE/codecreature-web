// collection of snailfish species
const speciesList = {
	mariana: {
		name: `Mariana Hadal Snailfish`,
		scientificName: `Pseudoliparis swirei`,
		icon: `photos/icons/mariana_snailfish.png`,
		iconAlt: `The smiling face of a snailfish. It is pale with tiny dark eyes, a wide cat-shaped mouth, and many large pores on its face.`,
		discovered: `2014`,
		depth: `8,076 meters`,
		location: `Mariana Trench`,
		photo: `photos/polaroids/mariana_snailfish_01.png`,
		photoCaption: `Little guy looking for crustaceans`,
		info: `
			<p>The most famous hadal snailfish! Since 2017, when it became the first fish from such extreme depths to have its genome sequenced, the MHS has been extremely important for our understanding of how vertebrates survive the trenches. It has tons of extra copies of certain genes, while others (like the ones that produce skin color) are totally gone!</p>
			<p>Gene analysis indicates that the Mariana snailfish likely has severely degraded vision, as is typical for deep sea animals, but may be able to see dim blue light. This could be an indicator that bioluminescence exists somewhere in the trench! <a href="https://www.researchgate.net/publication/353605156_Insights_into_the_vision_of_the_hadal_snailfish_Pseudoliparis_swirei_through_proteomic_analysis_of_the_eye">(source)</a>
		`
	},
	hadal: {
		name: `Hadal Snailfish`,
		scientificName: `Pseudoliparis amblystomopsis`,
		icon: `photos/icons/snailfish_01.png`,
		discovered: `1955`,
		depth: `7,579 meters`,
		location: `Izu-Ogasawara and Japan Trenches`,
		info: ``
	},
	blue: {
		name: `Blue Atacama Snailfish`,
		scientificName: `Paraliparis selti`,
		icon: `photos/icons/blue_snailfish.jpg`,
		discovered: `2022`,
		depth: `6,714 meters`,
		location: `Atacama Trench`,
		photo: `photos/polaroids/blue_snailfish_01.jpg`,
		photoAlt: `A blue snailfish on the ocean floor.`,
		photoCaption: `Bluer than your average snailfish`,
		videos: [
			{
				src: 'https://www.youtube.com/embed/sZYXomGHGJ0',
				title: 'New species discovered in the Atacama Trench'
			},
			{
				src: 'https://www.youtube.com/embed/txSOP_9yLCI',
				title: 'Newcastle University discover new species'
			}
		],
		info: `
			<p>With its large eyes, blue skin, and comparatively small arm fins, the blue snailfish doesn't look like any other known hadal species. After genetic analysis, it was found to have evolved from a totally independent genus of shallower-sea fish! This discovery shows that the snailfish family don't dominate the trenches because they got lucky; their biology is so well-suited to adapting to the extreme deep that they've gone through the process at least two separate times.</p>
			
			<p>This species is also notable for having more bones than most snailfish. Unclear what it's doing with those extra vertebrae (65 total, twice as many as humans!)</p>
			
			<p>Its two known Atacama cousins, nicknamed the pink and purple snailfish, were first spotted during the same expedition that discovered this species in 2022. They have not yet been officially described.</p>
			
			<p>Sources:</p>
			<p><a href="https://link.springer.com/article/10.1007/s12526-022-01294-0">Species description by Thomas D. Linley et al (2022)</a></p>
		`
	},
	kermadec: {
		name: `Kermadec Snailfish`,
		scientificName: `Notoliparis kermadecensis`,
		icon: `photos/icons/kermadec_snailfish.jpg`,
		discovered: ``,
		depth: ``,
		location: ``,
		photo: `polaroids/kermadec_snailfish_01.jpg`,
		photoAlt: ``,
		photoCaption: ``,
		info: `
			<p>Second-deepest fish in the southern hemisphere</p>
		`
	},
	atacama: {
		name: `Atacama Snailfishes`,
		scientificName: `multiple species`,
		icon: `photos/icons/snailfish_01.png`,
		discovered: `2018`,
		depth: `7,500 meters`,
		location: `Atacama Trench`,
		videos: [
			{
				src: 'https://www.youtube.com/embed/txSOP_9yLCI',
				title: 'Newcastle University discover new species'
			}
		],
		info: `
			<img src="atacama_snailfish_01.jpg" alt="">
			<p>a group of atacama snailfish feeding on a fish carcass in the Atacama trench</p>
		`
	},
	ethereal: {
		name: `Ethereal Snailfish`,
		scientificName: `undescribed species`,
		icon: `photos/icons/snailfish_01.png`,
		discovered: `2016`,
		depth: `8,145 meters
			<a class="source-link" href="https://www.sciencedirect.com/science/article/pii/S0967063716300656?via%3Dihub"></a>`,
		location: `Mariana Trench`,
		info: `Probable close relative of the Mariana Snailfish. I believe it holds the depth record for fish in the Mariana trench!`
	},
	izu: {
		name: `Izu-Ogasawara Snailfish`,
		scientificName: `Pseudoliparis sp`,
		icon: `photos/icons/snailfish_01.png`,
		discovered: `2022`,
		depth: `8,336 meters (Aug 2022)`,
		location: `Izu-Ogasawara Trench`,
		info: `This unidentified juvenile snailfish is the current record holder for deepest fish ever recorded as of 2023!
			<a class="source-link" href="https://www.bbc.com/news/science-environment-65148876"></a>`
	},
	threadfin: {
		name: `Threadfin Snailfish`,
		scientificName: `Careproctus longifilis`,
		icon: `photos/icons/threadfin_snailfish.png`,
		discovered: `1892`,
		depth: `5,500 meters`,
		location: ``,
		photo: `photos/polaroids/threadfin_snailfish_02.gif`,
		photoAlt: `GIF of a small gray snailfish swimming`,
		photoCaption: `Filmed in its natural habitat!`,
		info: `The threadfin snailfish is a benthopelagic fish found on the sea floor. Despite living thousands of meters above the trenches, it shares many features in common with its deeper hadal cousins, including its prominent facial sensory pores.`
	}
}

var speciesDetails, speciesPolaroid, speciesPhoto, speciesCaption;

//set up the page
function initSnailfish() {
	speciesDetails = document.getElementById('species-details');
	speciesPolaroid = speciesDetails.querySelector('.polaroid');
	speciesPhoto = speciesPolaroid.querySelector('.photo');
	speciesCaption = speciesPolaroid.querySelector('.caption');
	
	loadSpecies('mariana');
}

// loads the given species into the species box
function loadSpecies(s) {
	if (typeof(s) === 'string') s = speciesList[s];
	if (s) {
		console.log("Loading species info for " + s.name);
		if (s.icon) {
			let icon = speciesDetails.querySelector('.icon');
			icon.src = s.icon;
			if (s.iconAlt) icon.alt = s.iconAlt;
			else icon.alt = '';
		}
		// basics
		if (s.name) speciesDetails.querySelector('.common-name').innerHTML = s.name;
		if (s.scientificName) speciesDetails.querySelector('.scientific-name').innerHTML = s.scientificName;
		
		// photo
		if (s.photo) {
			speciesPolaroid.classList.remove('hidden');
			speciesPhoto.src = s.photo;
			
			if (s.photoAlt) speciesPhoto.alt = s.photoAlt;
			else speciesPhoto.alt = ''; 
			
			if (s.photoCaption) speciesCaption.innerHTML = s.photoCaption;
			else speciesCaption.innerHTML = ''; 
		}
		else { speciesPolaroid.classList.add('hidden'); }
		//if (s.discovered) speciesDetails.querySelector('#species-discovered').innerHTML = `discovered: ` + s.discovered;
		//if (s.depth) speciesDetails.querySelector('#species-depth').innerHTML = `depth record: ` + s.depth;
		//if (s.location) speciesDetails.querySelector('#species-location').innerHTML = `location: ` + s.location;
		
		// details section
		speciesDetails.querySelector('.info').innerHTML = s.info;
		
		// update the content of all links to source material
		//updateSourceLinks(speciesDetails);
		
		if (window.location.hash) { showPage(window.location.hash.replace('#','')); }
	}
}

// show the page with the given id
function showPage(id) {
	for (let page of Array.from(document.getElementsByClassName('full-page'))) {
		if (page.id == id) page.classList.remove('hidden');
		else page.classList.add('hidden');
	}
}