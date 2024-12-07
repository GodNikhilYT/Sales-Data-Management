document.addEventListener("DOMContentLoaded", function () {
    // Handle input field focus, blur, and keyup events
    document.querySelectorAll(".form input, .form textarea").forEach(function (input) {
      input.addEventListener("keyup", toggleLabel);
      input.addEventListener("blur", toggleLabel);
      input.addEventListener("focus", toggleLabel);
    });
  
    function toggleLabel(e) {
      var label = this.previousElementSibling;
  
      if (e.type === "keyup") {
        if (this.value === "") {
          label.classList.remove("active", "highlight");
        } else {
          label.classList.add("active", "highlight");
        }
      } else if (e.type === "blur") {
        if (this.value === "") {
          label.classList.remove("active", "highlight");
        } else {
          label.classList.remove("highlight");
        }
      } else if (e.type === "focus") {
        if (this.value !== "") {
          label.classList.add("highlight");
        }
      }
    }
  
    // Handle tab switching
    document.querySelectorAll(".tab a").forEach(function (tabLink) {
      tabLink.addEventListener("click", function (e) {
        e.preventDefault();
        this.parentElement.classList.add("active");
        Array.from(this.parentElement.parentElement.children).forEach(function (sibling) {
          if (sibling !== tabLink.parentElement) {
            sibling.classList.remove("active");
          }
        });
  
        let target = this.getAttribute("href");
        document.querySelectorAll(".tab-content > div").forEach(function (content) {
          content.style.display = "none";
        });
  
        document.querySelector(target).style.display = "block";
      });
    });
  
    // Initialize: show only the active tab's content
    document.querySelector("#signup").style.display = "block";
    document.querySelector("#login").style.display = "none";
  });
  