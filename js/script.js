// Hàm khởi tạo slideshow cho từng khối (dùng cho Sản phẩm Hot, Tiny Room dạng slide)
function initSlideshow(itemSelector, prevId, nextId, showCount = 3) {
  const items = document.querySelectorAll(itemSelector); // Lấy tất cả item slide
  const prevBtn = document.getElementById(prevId); // Nút prev
  const nextBtn = document.getElementById(nextId); // Nút next

  // Nếu không tìm thấy các phần tử cần thiết, không thực hiện gì cả
  if (items.length === 0 || !prevBtn || !nextBtn) {
    return;
  }

  let current = 0; // Vị trí bắt đầu

  function updateSlide() {
    items.forEach((item, idx) => {
      // Hiện showCount sản phẩm, ẩn các sản phẩm còn lại
      item.style.display =
        idx >= current && idx < current + showCount ? "block" : "none";
    });
  }

  prevBtn.addEventListener("click", function () {
    if (current > 0) {
      current--;
    } else {
      // Quay về slide cuối
      current = items.length - showCount > 0 ? items.length - showCount : 0;
    }
    updateSlide();
  });

  nextBtn.addEventListener("click", function () {
    if (current < items.length - showCount) {
      current++;
    } else {
      // Quay về slide đầu
      current = 0;
    }
    updateSlide();
  });

  // Hiển thị slide ban đầu
  updateSlide();
}

// Khởi tạo slideshow cho các khối khi trang đã load
document.addEventListener("DOMContentLoaded", function () {
  // Sản phẩm hot
  initSlideshow(".slide-item", "slide-prev", "slide-next", 3);
  // Sản phẩm tiny room
  initSlideshow(".slide-item-tiny", "slide-prev-tiny", "slide-next-tiny", 3);
});
