// Phân trang động cho trang category (3 hàng 3 cột)
document.addEventListener("DOMContentLoaded", function () {
  // Kiểm tra nếu có biến categoryProducts (danh sách sản phẩm từ PHP)
  if (typeof categoryProducts !== "undefined") {
    const perPage = 9; // Số sản phẩm mỗi trang (3x3)
    let currentPage = 1; // Trang hiện tại
    const totalProducts = categoryProducts.length; // Tổng số sản phẩm
    const totalPages = Math.ceil(totalProducts / perPage); // Tổng số trang
    const listEl = document.getElementById("category-list"); // Vùng hiển thị sản phẩm
    const pagEl = document.getElementById("category-pagination"); // Vùng hiển thị nút phân trang

    // Hàm render sản phẩm và nút phân trang cho trang hiện tại
    function renderCategory(page) {
      listEl.innerHTML = "";
      // Tính vị trí bắt đầu và kết thúc của sản phẩm trên trang này
      const start = (page - 1) * perPage;
      const end = Math.min(start + perPage, totalProducts);
      // Tạo HTML cho từng sản phẩm
      for (let i = start; i < end; i++) {
        const p = categoryProducts[i];
        const item = document.createElement("div");
        item.className = "content-item";
        item.innerHTML = `
          <img src="img/Banner.jpg" alt="notfound">
          <p class="name">${p.product_name}</p>
          <span class="price">
            <p>Giá:</p>
            <p class="price-value">${Number(p.price).toLocaleString()} VNĐ</p>
          </span>
        `;
        listEl.appendChild(item);
      }
      // Tạo các nút phân trang
      pagEl.innerHTML = "";
      // Nút Prev
      if (page > 1) {
        const prev = document.createElement("a");
        prev.className = "button-more button-more-page";
        prev.textContent = "Prev";
        prev.href = "#";
        prev.onclick = function (e) {
          e.preventDefault();
          renderCategory(page - 1);
        };
        pagEl.appendChild(prev);
      }
      // Nút số trang
      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("a");
        btn.className = "button-more button-more-page";
        btn.textContent = i;
        btn.href = "#";
        if (i === page) btn.style.background = "#07484a";
        btn.onclick = function (e) {
          e.preventDefault();
          renderCategory(i);
        };
        pagEl.appendChild(btn);
      }
      // Nút Next
      if (page < totalPages) {
        const next = document.createElement("a");
        next.className = "button-more button-more-page";
        next.textContent = "Next";
        next.href = "#";
        next.onclick = function (e) {
          e.preventDefault();
          renderCategory(page + 1);
        };
        pagEl.appendChild(next);
      }
      currentPage = page;
    }
    // Hiển thị trang đầu tiên khi load trang
    renderCategory(1);
  }
});

// Hàm khởi tạo slideshow cho từng khối (dùng cho Sản phẩm Hot, Tiny Room dạng slide)
function initSlideshow(itemSelector, prevId, nextId, showCount = 3) {
  const items = document.querySelectorAll(itemSelector); // Lấy tất cả item slide
  const prevBtn = document.getElementById(prevId); // Nút prev
  const nextBtn = document.getElementById(nextId); // Nút next
  let current = 0; // Vị trí bắt đầu
  function updateSlide() {
    items.forEach((item, idx) => {
      // Hiện showCount sản phẩm, ẩn các sản phẩm còn lại
      if (idx >= current && idx < current + showCount) {
        item.style.display = "block";
      } else {
        item.style.display = "none";
      }
    });
  }
  if (prevBtn && nextBtn) {
    prevBtn.addEventListener("click", function () {
      if (current > 0) {
        current--;
      } else {
        current = items.length - showCount < 0 ? 0 : items.length - showCount;
      }
      if (prevBtn && nextBtn) {
        prevBtn.addEventListener("click", function () {
          if (current > 0) {
            current--;
          } else {
            current =
              items.length - showCount < 0 ? 0 : items.length - showCount;
          }
          updateSlide();
        });
        nextBtn.addEventListener("click", function () {
          if (current < items.length - showCount) {
            current++;
          } else {
            current = 0;
          }
        });
        nextBtn.addEventListener("click", function () {
          if (current < items.length - showCount) {
            current++;
          } else {
            current = 0;
          }
          updateSlide();
        });
      }
    });
  }
  updateSlide();
}

// Khởi tạo slideshow cho các khối khi trang đã load
document.addEventListener("DOMContentLoaded", function () {
  // Sản phẩm hot
  initSlideshow(".slide-item", "slide-prev", "slide-next", 3);
  // Sản phẩm tiny room
  initSlideshow(".slide-item-tiny", "slide-prev-tiny", "slide-next-tiny", 3);
});
