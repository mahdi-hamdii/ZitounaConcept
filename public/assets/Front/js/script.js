// For Articles
let bigPic = document.querySelector("#big-pic");
let pics = Array.from(document.querySelectorAll(".small-pic img"));

// Create the default element
let img = document.createElement("img");
img.src = pics[0].src;
bigPic.appendChild(img);

// Append it to the dom when clicking

pics.map((pic) =>
  pic.addEventListener("click", (e) => {
    img.src = pic.src;
    bigPic.appendChild(img);
  })
);