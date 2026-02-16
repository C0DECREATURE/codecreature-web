/*
        
        FILL IN THESE VARIABLES BASED ON THE GUIDE AT https://drawbox.nekoweb.org
        
        
				      /`·.¸
				     /¸...¸`:·
				 ¸.·´  ¸   `·.¸.·´)
				: © ):´;      ¸  {
				 `·.¸ `·  ¸.·´\`·¸)
				     `\\´´\¸.·´
        
*/
const DISPLAY_IMAGES = true;

/*
        
        DONT EDIT BELOW THIS POINT IF YOU DONT KNOW WHAT YOU ARE DOING.
        
*/

let canvas = document.getElementById("drawboxcanvas");
let context = canvas.getContext("2d");
context.fillStyle = "white";
context.fillRect(0, 0, canvas.width, canvas.height);

let restore_array = [];
let start_index = -1;
let stroke_color = "black";
let stroke_width = document.getElementById("stroke-width").value;
let is_drawing = false;

function change_stroke_width(num) {
	stroke_width = num;
	document.getElementById("stroke-width-preview").style.width = num + "px";
	document.getElementById("stroke-width-preview").style.height = num + "px";
}

function change_color(element) {
  stroke_color = element.style.background;
	document.getElementById("stroke-width-preview").style.background = stroke_color;
}

function start(event) {
  is_drawing = true;
  context.beginPath();
  context.moveTo(getX(event), getY(event));
  event.preventDefault();
}

function draw(event) {
  if (!is_drawing) return;
  context.lineTo(getX(event), getY(event));
  context.strokeStyle = stroke_color;
  context.lineWidth = stroke_width;
  context.lineCap = "round";
  context.lineJoin = "round";
  context.stroke();
  event.preventDefault();
}

function stop(event) {
  if (!is_drawing) return;
  context.stroke();
  context.closePath();
  is_drawing = false;
  restore_array.push(context.getImageData(0, 0, canvas.width, canvas.height));
  start_index++;
  event.preventDefault();
}

function getX(event) {
  return event.pageX
    ? event.pageX - canvas.offsetLeft
    : event.targetTouches[0].pageX - canvas.offsetLeft;
}

function getY(event) {
  return event.pageY
    ? event.pageY - canvas.offsetTop
    : event.targetTouches[0].pageY - canvas.offsetTop;
}

canvas.addEventListener("touchstart", start, false);
canvas.addEventListener("touchmove", draw, false);
canvas.addEventListener("touchend", stop, false);
canvas.addEventListener("mousedown", start, false);
canvas.addEventListener("mousemove", draw, false);
canvas.addEventListener("mouseup", stop, false);
canvas.addEventListener("mouseout", stop, false);

function Restore() {
  if (start_index <= 0) {
    Clear();
  } else {
    start_index--;
    restore_array.pop();
    context.putImageData(restore_array[start_index], 0, 0);
  }
}

function Clear() {
  context.fillStyle = "white";
  context.clearRect(0, 0, canvas.width, canvas.height);
  context.fillRect(0, 0, canvas.width, canvas.height);
  restore_array = [];
  start_index = -1;
}

context.drawImage = function() {
	console.warn("noo >:(");
};

document.getElementById("submit").addEventListener("click", async function () {
  const submitButton = document.getElementById("submit");
  const statusText = document.getElementById("status");

  submitButton.disabled = true;
  statusText.textContent = "Uploading...";

  const imageData = canvas.toDataURL("image/png");
  const blob = await (await fetch(imageData)).blob();
	
  try {
    imageUploadRequest("drawing", blob)

    statusText.textContent = "Upload successful!";
    alert("Image uploaded and submitted successfully ☻");
    location.reload();
  } catch (error) {
    console.error(error);
    statusText.textContent = "Error uploading image.";
    alert("Error uploading image or submitting to PostImages.");
  } finally {
    submitButton.disabled = false;
  }
});

function imageUploadRequest(fileName, img) {
	const formObject = {
			key: '915bc6f3865bd2f868ff294a1ff8f78c',
			gallery: 'pmcJDyn',
			o: '2b819584285c102318568238c7d4a4c7',
			m: '59c2ad4b46b0c1e12d5703302bff0120',
			version: '1.0.1',
			portable: '1',
			name: fileName.split('.')[0],
			type: fileName.split('.')[1],
			image: img
	};

	const formBody = Object.keys(formObject)
			.map(property => `${encodeURIComponent(property)}=${encodeURIComponent(formObject[property])}`)
			.join("&");

	return {
			method: 'POST',
			url: 'https://api.postimage.org/1/upload',
			headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
			},
			body: formBody
	};
};

async function fetchImages() {
  if (!DISPLAY_IMAGES) {
    console.log("Image display is disabled.");
    return;
  }

  try {
    const response = await fetch(GOOGLE_SHEET_URL);
    const csvText = await response.text();
    const rows = csvText.split("\n").slice(1);

    const gallery = document.getElementById("gallery");
    gallery.innerHTML = "";
    rows.reverse().forEach((row) => {
      const columns = row.split(",");
      if (columns.length < 2) return;

      const timestamp = columns[0].trim();
      const imgUrl = columns[1].trim().replace(/"/g, "");

      if (imgUrl.startsWith("http")) {
        const div = document.createElement("div");
        div.classList.add("image-container");

        div.innerHTML = `
                    <img src="${imgUrl}" alt="drawing">
                    <p>${timestamp}</p>
                `;
        gallery.appendChild(div);
      }
    });
  } catch (error) {
    console.error("Error fetching images:", error);
    document.getElementById("gallery").textContent = "Failed to load images.";
  }
}

fetchImages();