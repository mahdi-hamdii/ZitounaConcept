// For Articles
let bigPic = document.querySelector("#big-pic");
let defaultPic = document.querySelector("#default-pic");
let pic2 = document.querySelector("#pic-2");
let pic3 = document.querySelector("#pic-3");

// Create the default element
let img = document.createElement("img");
img.src = defaultPic.src;
bigPic.appendChild(img);

// Append it to the dom when clicking

defaultPic.addEventListener("click", (e) => {
  img.src = defaultPic.src;
  bigPic.appendChild(img);
});

pic2.addEventListener("click", (e) => {
  img.src = pic2.src;
  bigPic.appendChild(img);
});

pic3.addEventListener("click", (e) => {
  img.src = pic3.src;
  bigPic.appendChild(img);
});
