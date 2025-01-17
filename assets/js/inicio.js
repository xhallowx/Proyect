const mask = document.getElementById("mask");
const mouseCursor = (Event) => {
  const rect = mask.getBoundingClientRect();
  const mouseX = Event.clientX - rect.left - 80;
  const mouseY = Event.clientY - rect.top - 80;
  mask.style.maskPosition = `${mouseX}px ${mouseY}px`;
};

mask.addEventListener("mousemove", mouseCursor);
const nav = document.querySelector(".nav");
window.addEventListener("scroll", function () {
  nav.classList.toggle("active", window.scrollY > 0);
});
const perfumeCards = document.querySelectorAll(".perfume-card");

window.addEventListener("scroll", function () {
  const scrollPos = window.scrollY + window.innerHeight;

  perfumeCards.forEach(function (card) {
    if (scrollPos > card.offsetTop + card.offsetHeight / 2) {
      card.classList.add("visible");
      card.classList.remove("hidden");
    } else {
      card.classList.remove("visible");
      card.classList.add("hidden");
    }
  });
});
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();

    document.querySelector(this.getAttribute("href")).scrollIntoView({
      behavior: "smooth",
    });
  });
});
