// Get the flash message element
const flashMessage = document.getElementById("flash-message");

// Check if the flash message element exists
if (flashMessage) {
  flashMessage.classList.add("animate__animated", "animate__slideInRight");

  // Set a timeout to remove the flash message after 5 seconds (5000 milliseconds)
  setTimeout(function () {
    flashMessage.remove();
  }, 5000);
}

const flashClose = document.getElementById("flash-close");
if (flashClose) {
  flashClose.addEventListener("click", () => {
    flashMessage.remove();
  });
}

const sideLinks = document.querySelectorAll(".side-menu li a:not(.logout)");

// Get the active URL path
const urlPath = window.location.pathname.replace("/", "");

// Remove any active class from the menu
sideLinks.forEach((item) => {
  const li = item.parentElement;
  li.classList.remove("active");

  // Check if the URL path matches the link's href attribute
  if (item.getAttribute("href").replace("/", "") === urlPath) {
    li.classList.add("active");
  }

  // Add click event listener to set the active class and store it in localStorage
  item.addEventListener("click", () => {
    li.classList.remove("active");

    // Remove active class from all items
    sideLinks.forEach((link) => link.parentElement.classList.remove("active"));

    // Add active class to the clicked item
    li.classList.add("active");

    // Store the active path in localStorage
    localStorage.setItem("activePath", item.getAttribute("href"));
  });
});

// Get the active path from localStorage and set the active class
const activePath = localStorage.getItem("activePath");
if (activePath) {
  sideLinks.forEach((item) => {
    if (item.getAttribute("href") === activePath) {
      item.parentElement.classList.add("active");
    }
  });
}

const menuBar = document.querySelector(".sideMenu");
const sideBar = document.querySelector(".sidebar");

menuBar.addEventListener("click", () => {
  if (sideBar.classList.contains("open")) {
    sideBar.classList.remove("open");
    sideBar.classList.add("close");
  } else {
    sideBar.classList.remove("close");
    sideBar.classList.add("open");
  }
});

// const searchBtn = document.querySelector(
//   ".content nav form .form-input button"
// );
// const searchBtnIcon = document.querySelector(
//   ".content nav form .form-input button .bx"
// );
// const searchForm = document.querySelector(".content nav form");

// searchBtn.addEventListener("click", function (e) {
//   if (window.innerWidth < 576) {
//     e.preventDefault;
//     searchForm.classList.toggle("show");
//     if (searchForm.classList.contains("show")) {
//       searchBtnIcon.classList.replace("bx-search", "bx-x");
//     } else {
//       searchBtnIcon.classList.replace("bx-x", "bx-search");
//     }
//   }
// });

window.addEventListener("resize", () => {
  if (window.innerWidth < 768) {
    sideBar.classList.add("close");
    sideBar.classList.remove("open");
  } else {
    sideBar.classList.add("open");
    sideBar.classList.remove("close");
  }
});

window.addEventListener("load", () => {
  if (window.innerWidth < 768) {
    sideBar.classList.add("close");
    sideBar.classList.remove("open");
  } else {
    sideBar.classList.add("open");
    sideBar.classList.remove("close");
  }
});

// const toggler = document.getElementById("theme-toggle");

// toggler.addEventListener("change", function () {
//   if (this.checked) {
//     document.body.classList.add("dark");
//   } else {
//     document.body.classList.remove("dark");
//   }
// });

function approveChama(data) {
  const url = `chama-approve?id=${data}`;
  fetch(url);
}

function rejectChama(data) {
  const url = `chama-reject?id=${data}`;
  fetch(url);
}
