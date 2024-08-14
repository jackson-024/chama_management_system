document.addEventListener("DOMContentLoaded", function () {
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
      sideLinks.forEach((link) =>
        link.parentElement.classList.remove("active")
      );

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

  function showModal(type, message) {
    const flashMessageModal = document.getElementById("flash-message");

    if (flashMessageModal) {
      // Set a timeout to remove the flash message after 5 seconds (5000 milliseconds)
      setTimeout(function () {
        flashMessageModal.remove();
      }, 5000);
    }

    if (type === "success") {
      flashMessageModal.innerHTML = `
              <div class="flash-message-wrapper">
                <div class="flash-message-box flash-message-box-success">
                    <div class="flash-message-content">
                        <div class="flash-message-inner">
                            <div class="icon-container">
                                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flash-message-text">
                                ${message}
                            </div>
                            <div class="close-button-container">
                                <button type="button" id="flash-close" class="close-button">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      `;
    } else {
      flashMessageModal.innerHTML = `
              <div class="flash-message-wrapper">
                <div class="flash-message-box flash-message-box-error">
                    <div class="flash-message-content">
                        <div class="flash-message-inner">
                            <div class="icon-container">
                                <svg class="icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flash-message-text">
                                ${message}
                            </div>
                            <div class="close-button-container">
                                <button type="button" id="flash-close" class="close-button">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      `;
    }
  }

  function approveJoin(data) {
    const apprButton = document.getElementById("join-approve");

    apprButton.classList.add("loading");

    const url = `join-chama-approve?id=${data}`;
    fetch(url).then((res) => {
      console.log(res);

      if (res.ok) {
        apprButton.classList.remove("loading");
        showModal("success", "Join Request Approved");
        // window.location.href = res.url;
      } else {
        showModal("error", "Approval error, contact admin");
        // window.location.reload;
      }
    });
  }

  function rejectJoin(data) {
    const apprButton = document.getElementById("join-reject");

    apprButton.classList.add("loading");
    const url = `join-chama-reject?id=${data}`;
    fetch(url).then((response) => {
      if (response.ok) {
        apprButton.classList.remove("loading");
        showModal("success", "User rejected");
        // window.location.href = res.url;
      } else {
        showModal("error", "Reject Failed");
        // window.location.reload;
      }
    });
  }

  function approveChama(data) {
    const url = `chama-approve?id=${data}`;
    fetch(url)
      .then((res) => {
        console.log(res);
        // window.location.href = res.url;
        showModal("success", "Chama Approved");
      })
      .catch((err) => {
        console.log(err);
      });
  }

  function rejectChama(data) {
    const url = `chama-reject?id=${data}`;
    fetch(url);
  }

  function accountLogin(data) {
    fetch("login-user-account", {
      method: "POST",
      body: JSON.stringify(data),
    }).then((res) => {
      console.log(res);
    });
  }

  function clearStorage() {
    console.log("activePath");
    localStorage.removeItem("activePath");
  }

  // date display logic
  // get the all start and end date elements using id
  const yearElemStart = document.querySelector("#select_year_start");
  const dayElemStart = document.querySelector("#select_day_start");
  const monthElemStart = document.querySelector("#select_month_start");

  const yearElemEnd = document.querySelector("#select_year_end");
  const dayElemEnd = document.querySelector("#select_day_end");
  const monthElemEnd = document.querySelector("#select_month_end");

  const startValue = document.querySelector("#start_date");
  const endValue = document.querySelector("#end_date");

  let today = new Date();
  let days = 31; // maximum number of days
  let months = 12; // maximum number of months

  let yearStart = 2010;
  let yearEnd = today.getFullYear();

  // //  populate date from 1st of month
  // for (let d = 1; d < days; d++) {
  //   const optDayStart = document.createElement("option"); // create a new option element for start
  //   optDayStart.value = d; // set option value
  //   optDayStart.innerText = d; // set what will be displayed
  //   dayElemStart.appendChild(optDayStart); // attach to actual element

  //   const optDayEnd = document.createElement("option"); // create a new option element for end
  //   optDayEnd.value = d;
  //   optDayEnd.innerText = d;
  //   dayElemEnd.appendChild(optDayEnd);
  // }

  // Generate months
  for (let m = 0; m < months; m++) {
    // Get the month's full name (e.g., "January")
    const monthName = new Date(0, m).toLocaleString("en-US", { month: "long" });

    // Create the option element for the start month selector
    const optMonthStart = document.createElement("option");
    optMonthStart.value = m + 1; // Adjusting for zero-indexing
    optMonthStart.innerText = monthName;
    monthElemStart.appendChild(optMonthStart);

    // Create the option element for the end month selector
    const optMonthEnd = document.createElement("option");
    optMonthEnd.value = m + 1; // Adjusting for zero-indexing since january is represented as inde 0
    optMonthEnd.innerText = monthName;
    monthElemEnd.appendChild(optMonthEnd);
  }

  // generate years from yearstart upto the current year
  for (let y = yearStart; y <= yearEnd; y++) {
    // Create the option element for the start year selector
    const optYearStart = document.createElement("option");
    optYearStart.value = y;
    optYearStart.innerText = y;
    yearElemStart.appendChild(optYearStart);

    // Create the option element for the end year selector
    const optYearEnd = document.createElement("option");
    optYearEnd.value = y;
    optYearEnd.innerText = y;
    yearElemEnd.appendChild(optYearEnd);
  }

  // generate days according to month selected
  function generateDays() {
    const monthStart = parseInt(monthElemStart.value); // Convert monthStart value to zero
    const year = parseInt(yearElemStart.value);

    const daysInMonthStart = new Date(year, monthStart, 0).getDate();

    dayElemStart.innerHTML = ""; // Clear the day options

    for (let d = 1; d <= daysInMonthStart; d++) {
      const optDayStart = document.createElement("option");
      optDayStart.value = d;
      optDayStart.innerText = d;
      dayElemStart.appendChild(optDayStart);
    }
  }

  // generate days according to month selected
  function generateEndDays() {
    const monthEnd = parseInt(monthElemEnd.value); // Convert monthEnd value to zero
    const yearEnd = parseInt(yearElemEnd.value);

    const daysInMonthEnd = new Date(yearEnd, monthEnd, 0).getDate();

    console.log(yearEnd);
    console.log(monthEnd);
    console.log(daysInMonthEnd);

    dayElemEnd.innerHTML = ""; // Clear the day options

    for (let d = 1; d <= daysInMonthEnd; d++) {
      const optDayEnd = document.createElement("option");
      optDayEnd.value = d;
      optDayEnd.innerText = d;
      dayElemEnd.appendChild(optDayEnd);
    }
  }

  // add event listener to month
  monthElemStart.addEventListener("click", (e) => {
    monthElemStart.value = e.target.value;

    generateDays();
  });

  // add event listener to month
  monthElemEnd.addEventListener("click", (e) => {
    console.log(e.target.value);
    console.log(yearElemEnd.value);

    monthElemEnd.value = e.target.value;
    if (yearElemEnd.value && monthElemEnd.value) {
      generateEndDays();
    }
  });

  dayElemStart.addEventListener("click", (e) => {
    let startYearV = parseInt(yearElemStart.value);
    let startMonthV = parseInt(monthElemStart.value);
    let startDateV = parseInt(dayElemStart.value);

    startValue.value = `${startYearV}-${startMonthV}-${startDateV}`;
    startValue.innerText = `${startYearV}-${startMonthV}-${startDateV}`;
  });

  dayElemEnd.addEventListener("click", (e) => {
    let endYearV = parseInt(yearElemEnd.value);
    let endMonthV = parseInt(monthElemEnd.value);
    let endDateV = parseInt(dayElemEnd.value);

    let date = new Date(
      parseInt(yearElemEnd.value),
      parseInt(monthElemEnd.value),
      parseInt(dayElemEnd.value)
    );

    endValue.value = `${endYearV}-${endMonthV}-${endDateV}`;
    endValue.innerText = `${endYearV}-${endMonthV}-${endDateV}`;
  });

  // end of date generation
  document
    .querySelector("#page-filter")
    .addEventListener("submit", function (e) {
      e.preventDefault(); // Prevent the default form submission behavior

      // Get the current URL path
      const currentUrlPath = window.location.pathname;

      // Get the values from the start and end date inputs
      const startYear = yearElemStart.value;
      const startMonth = String(monthElemStart.value).padStart(2, "0"); // Ensure month is two digits
      const startDay = String(dayElemStart.value).padStart(2, "0"); // Ensure day is two digits

      const endYear = yearElemEnd.value;
      const endMonth = String(monthElemEnd.value).padStart(2, "0"); // Ensure month is two digits
      const endDay = String(dayElemEnd.value).padStart(2, "0"); // Ensure day is two digits

      // Format the dates as "YYYY-MM-DD"
      const startDate = startValue.value;
      const endDate = endValue.value;

      // Generate the URL with the current path and query parameters
      const url = `${window.location.origin}${currentUrlPath}?start_date=${startDate}&end_date=${endDate}`;

      // Redirect to the generated URL
      window.location.href = url;
    });

  // handle filter form submission
});
