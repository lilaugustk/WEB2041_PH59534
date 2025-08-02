  // Phân trang động cho trang category (3 hàng 3 cột)
document.addEventListener("DOMContentLoaded", function () {
  if (typeof categoryProducts !== "undefined") {
    const perPage = 9;
    let currentPage = 1;
    const totalProducts = categoryProducts.length;
    const totalPages = Math.ceil(totalProducts / perPage);
    const listEl = document.getElementById("category-list");
    const pagEl = document.getElementById("category-pagination");

    function renderCategory(page) {
      listEl.innerHTML = "";
      const start = (page - 1) * perPage;
      const end = Math.min(start + perPage, totalProducts);
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
      pagEl.innerHTML = "";
      if (page > 1) {
        const prev = document.createElement("a");
        prev.className = "button-more";
        prev.textContent = "Prev";
        prev.href = "#";
        prev.onclick = function (e) {
          e.preventDefault();
          renderCategory(page - 1);
        };
        pagEl.appendChild(prev);
      }
      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("a");
        btn.className = "button-more";
        btn.textContent = i;
        btn.href = "#";
        if (i === page) btn.style.background = "#07484a";
        btn.onclick = function (e) {
          e.preventDefault();
          renderCategory(i);
        };
        pagEl.appendChild(btn);
      }
      if (page < totalPages) {
        const next = document.createElement("a");
        next.className = "button-more";
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
    renderCategory(1);
  }
});
// Hàm khởi tạo slideshow cho từng khối
function initSlideshow(itemSelector, prevId, nextId, showCount = 3) {
  const items = document.querySelectorAll(itemSelector);
  const prevBtn = document.getElementById(prevId);
  const nextBtn = document.getElementById(nextId);
  let current = 0;
  function updateSlide() {
    items.forEach((item, idx) => {
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
      updateSlide();
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
  updateSlide();
}

document.addEventListener("DOMContentLoaded", function () {
  // Sản phẩm hot
  initSlideshow(".slide-item", "slide-prev", "slide-next", 3);
  // Sản phẩm tiny room
  initSlideshow(".slide-item-tiny", "slide-prev-tiny", "slide-next-tiny", 3);
});
