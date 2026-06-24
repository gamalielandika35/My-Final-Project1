document.addEventListener("DOMContentLoaded", function(){
  const slides = document.querySelectorAll(".slide");
  const bullets = document.querySelector(".bullets");
  let current = 0;

  slides.forEach((_, i) => {
    const b = document.createElement("span");
    b.addEventListener("click", () => showSlide(i));
    bullets.appendChild(b);
  });

  function showSlide(i){
    slides[current].style.display = "none";
    bullets.children[current].classList.remove("active");
    current = i;
    slides[current].style.display = "block";
    bullets.children[current].classList.add("active");
  }

  function autoSlide(){
    let next = (current + 1) % slides.length;
    showSlide(next);
  }

 
  if(slides.length > 0){
    slides[0].style.display = "block";
    bullets.children[0].classList.add("active");
    setInterval(autoSlide, 4000); 
  }
});
