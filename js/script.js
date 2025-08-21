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

// Hàm xử lý giỏ hàng
function initCart() {
  const quantityBtns = document.querySelectorAll(".quantity-btn");
  const quantityInputs = document.querySelectorAll(".quantity-input");

  // Xử lý nút tăng/giảm số lượng
  quantityBtns.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      const action = this.dataset.action;
      const productId = this.dataset.product;
      const input = this.parentNode.querySelector(".quantity-input");
      const currentValue = parseInt(input.value);
      const maxValue = parseInt(input.max);

      let newValue = currentValue;

      if (action === "increase" && currentValue < maxValue) {
        newValue = currentValue + 1;
      } else if (action === "decrease" && currentValue > 1) {
        newValue = currentValue - 1;
      }

      if (newValue !== currentValue) {
        input.value = newValue;
        updateProductSubtotal(input, productId);
        updateCartTotal();
        updateCartCount(); // Cập nhật số lượng trên header
      }
    });
  });

  // Xử lý input số lượng
  quantityInputs.forEach((input) => {
    input.addEventListener("change", function () {
      const productId =
        this.dataset.product || this.name.match(/\[(\d+)\]/)?.[1];
      if (productId) {
        updateProductSubtotal(this, productId);
        updateCartTotal();
        updateCartCount(); // Cập nhật số lượng trên header
      }
    });
  });

  // Xử lý nút xóa sản phẩm
  const removeBtns = document.querySelectorAll(".remove-btn");
  removeBtns.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      if (!confirm("Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?")) {
        e.preventDefault();
      } else {
        // Cập nhật số lượng sau khi xóa
        setTimeout(() => {
          updateCartCount();
        }, 100);
      }
    });
  });
}

// Cập nhật tạm tính của sản phẩm
function updateProductSubtotal(input, productId) {
  const row = input.closest(".cart-item-row");
  if (!row) return;

  const priceElement = row.querySelector(".price-value");
  const subtotalElement = row.querySelector(".subtotal-value");

  if (priceElement && subtotalElement) {
    const price = parseFloat(priceElement.textContent.replace(/[^\d]/g, ""));
    const quantity = parseInt(input.value);
    const subtotal = price * quantity;

    subtotalElement.textContent = subtotal.toLocaleString("vi-VN") + " VNĐ";
  }
}

// Cập nhật tổng giỏ hàng
function updateCartTotal() {
  const subtotalElements = document.querySelectorAll(".subtotal-value");
  let total = 0;

  subtotalElements.forEach((element) => {
    const value = parseFloat(element.textContent.replace(/[^\d]/g, ""));
    if (!isNaN(value)) {
      total += value;
    }
  });

  // Cập nhật hiển thị tổng
  const totalPriceElements = document.querySelectorAll(".total-price");
  totalPriceElements.forEach((element) => {
    element.textContent = total.toLocaleString("vi-VN") + " VNĐ";
  });

  // Cập nhật tạm tính
  const summaryValueElements = document.querySelectorAll(".summary-value");
  summaryValueElements.forEach((element) => {
    if (element.textContent.includes("VNĐ")) {
      element.textContent = total.toLocaleString("vi-VN") + " VNĐ";
    }
  });
}

// Hàm xử lý form giỏ hàng
function initCartForm() {
  const cartForm = document.querySelector('form[action*="update-cart"]');
  if (cartForm) {
    cartForm.addEventListener("submit", function (e) {
      const quantityInputs = this.querySelectorAll(".quantity-input");
      let hasError = false;

      // Kiểm tra số lượng hợp lệ
      quantityInputs.forEach((input) => {
        const value = parseInt(input.value);
        const min = parseInt(input.min);
        const max = parseInt(input.max);

        if (value < min || value > max) {
          hasError = true;
          input.style.borderColor = "#dc3545";
          input.style.boxShadow = "0 0 0 2px rgba(220, 53, 69, 0.2)";
        } else {
          input.style.borderColor = "#e0f6f1";
          input.style.boxShadow = "none";
        }
      });

      if (hasError) {
        e.preventDefault();
        alert("Vui lòng kiểm tra lại số lượng sản phẩm!");
      }
    });
  }
}

// Hàm xử lý responsive cho giỏ hàng
function initCartResponsive() {
  const cartTable = document.querySelector(".cart-table");
  const cartTableWrapper = document.querySelector(".cart-table-wrapper");

  if (cartTable && cartTableWrapper) {
    function checkTableOverflow() {
      if (cartTable.offsetWidth > cartTableWrapper.offsetWidth) {
        cartTableWrapper.style.overflowX = "auto";
      } else {
        cartTableWrapper.style.overflowX = "hidden";
      }
    }

    // Kiểm tra khi resize
    window.addEventListener("resize", checkTableOverflow);

    // Kiểm tra ban đầu
    checkTableOverflow();
  }
}

// Hàm cập nhật số lượng giỏ hàng trên header
function updateCartCount() {
  const cartCountElement = document.querySelector(".cart-count");
  if (!cartCountElement) return;

  // Tính số loại sản phẩm từ bảng giỏ hàng
  const cartRows = document.querySelectorAll(".cart-item-row");
  let productTypesCount = cartRows.length;

  if (productTypesCount > 0) {
    cartCountElement.textContent =
      productTypesCount > 99 ? "99+" : productTypesCount;
    cartCountElement.style.display = "flex";

    // Thêm animation
    cartCountElement.style.animation = "none";
    setTimeout(() => {
      cartCountElement.style.animation = "cartCountPulse 0.3s ease-in-out";
    }, 10);
  } else {
    cartCountElement.style.display = "none";
  }
}

// Hàm cập nhật số lượng giỏ hàng từ session (cho các trang không phải cart)
function updateCartCountFromSession() {
  const cartCountElement = document.querySelector(".cart-count");
  if (!cartCountElement) return;

  // Lấy số lượng từ data attribute hoặc tính từ các element có sẵn
  const cartItems = document.querySelectorAll("[data-cart-item]");
  let count = 0;

  if (cartItems.length > 0) {
    count = cartItems.length;
  } else {
    // Fallback: kiểm tra các element khác có thể chứa thông tin giỏ hàng
    const cartBadges = document.querySelectorAll(
      ".cart-badge, .cart-item-count"
    );
    if (cartBadges.length > 0) {
      count = parseInt(cartBadges[0].textContent) || 0;
    }
  }

  if (count > 0) {
    cartCountElement.textContent = count > 99 ? "99+" : count;
    cartCountElement.style.display = "flex";
  } else {
    cartCountElement.style.display = "none";
  }
}

// Hàm xử lý chọn số lượng sản phẩm trong trang chi tiết
function initQuantitySelector() {
  const quantityDown = document.querySelector(".quantity-down");
  const quantityUp = document.querySelector(".quantity-up");
  const quantityInput = document.querySelector(".quantity-input");

  if (quantityDown && quantityUp && quantityInput) {
    // Xử lý nút giảm số lượng
    quantityDown.addEventListener("click", function () {
      const currentValue = parseInt(quantityInput.value);
      const minValue = parseInt(quantityInput.min);

      if (currentValue > minValue) {
        quantityInput.value = currentValue - 1;
      }
    });

    // Xử lý nút tăng số lượng
    quantityUp.addEventListener("click", function () {
      const currentValue = parseInt(quantityInput.value);
      const maxValue = parseInt(quantityInput.max);

      if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
      }
    });

    // Xử lý input số lượng (cho phép nhập trực tiếp)
    quantityInput.addEventListener("input", function () {
      let value = parseInt(this.value) || 0;
      const min = parseInt(this.min);
      const max = parseInt(this.max);

      // Đảm bảo giá trị hợp lệ
      if (isNaN(value) || value < min) {
        value = min;
      } else if (value > max) {
        value = max;
      }

      this.value = value;
    });

    // Xử lý khi focus vào input
    quantityInput.addEventListener("focus", function () {
      this.removeAttribute("readonly");
    });

    // Xử lý khi blur khỏi input
    quantityInput.addEventListener("blur", function () {
      this.setAttribute("readonly", "readonly");
    });
  }
}

// Khởi tạo slideshow cho các khối khi trang đã load
document.addEventListener("DOMContentLoaded", function () {
  // Sản phẩm hot
  initSlideshow(".slide-item", "slide-prev", "slide-next", 3);
  // Sản phẩm tiny room
  initSlideshow(".slide-item-tiny", "slide-prev-tiny", "slide-next-tiny", 3);

  // Khởi tạo giỏ hàng nếu đang ở trang cart
  if (document.querySelector(".cart-container")) {
    initCart();
    initCartForm();
    initCartResponsive();
  }

  // Cập nhật số lượng giỏ hàng trên tất cả các trang
  updateCartCountFromSession();

  // Khởi tạo chọn số lượng nếu đang ở trang chi tiết sản phẩm
  if (document.querySelector(".quantity-selector")) {
    initQuantitySelector();
  }
});
