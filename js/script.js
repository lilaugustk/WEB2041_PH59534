// Slideshow cho 3 sản phẩm nằm ngang
document.addEventListener("DOMContentLoaded", function () {
  const items = document.querySelectorAll(".slide-item");
  const prevBtn = document.getElementById("slide-prev");
  const nextBtn = document.getElementById("slide-next");
  let current = 0;
  const showCount = 3;

  function updateSlide() {
    items.forEach((item, idx) => {
      if (idx >= current && idx < current + showCount) {
        item.style.display = "block";
      } else {
        item.style.display = "none";
      }
    });
  }

  prevBtn.addEventListener("click", function () {
    if (current > 0) {
      current--;
      updateSlide();
    }
  });

  nextBtn.addEventListener("click", function () {
    if (current < items.length - showCount) {
      current++;
      updateSlide();
    }
  });

  updateSlide();
});
