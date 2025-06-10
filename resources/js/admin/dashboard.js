document.addEventListener('DOMContentLoaded', function () {
  const toggleMenu = document.querySelector(".toggle-menu");
  const sidebar = document.querySelector(".sidebar");
  const mainContainer = document.querySelector(".main-container");
  const backdropFilter = document.querySelector(".backdrop-filter");
  const logo = document.querySelector(".logo")
  const logoImgLg = document.querySelector(".logo .lg-logo")
  const logoImgSm = document.querySelector(".logo .sm-logo")


 // TOGGLE ITEMS FUNCTION
  const toggleItems = () => {
  logo.classList.toggle("activeLogo")
  logoImgLg.classList.toggle("activeLogoLgImg")
  logoImgSm.classList.toggle("activeLogoSmImg")
  sidebar.classList.toggle("active");
  mainContainer.classList.toggle("active");
  backdropFilter.classList.toggle("active");
};
  // TOGGLE MENU EVENT CLICK
toggleMenu.addEventListener("click", toggleItems);
  // BACKDROP FILTER EVENT CLICK
backdropFilter.addEventListener("click", toggleItems);

/*...........................Picture Admin............................ */

const profileImg = document.getElementById("profileImg");
    const dropdownMenu = document.getElementById("dropdownMenu");

    // إظهار القائمة عند الضغط على الصورة
    profileImg.addEventListener("click", function () {
        dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
    });

    // إخفاء القائمة عند الضغط خارجها
    document.addEventListener("click", function (event) {
        if (!profileImg.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = "none";
        }
    });

// charts

const barColors = [
    "rgb(92, 103, 247)",
    "#08fa81",
    "rgb(227, 84, 212)",
    "#fa0828",
];
const douColors = [
    "rgb(92, 103, 247)",
    "rgb(227, 84, 212)",
    "rgb(255, 93, 159)",
];

// جلب البيانات من الخادم
async function fetchStatistics() {
    try {
        const response = await fetch('/statistics');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log(data); // تحقق من البيانات في الكونسول
        return data;
    } catch (error) {
        console.error('Error fetching statistics:', error);
    }
}

// تحميل الرسوم البيانية
async function loadCharts() {
    const data = await fetchStatistics();

    // الرسم البياني الشريطي
    new Chart("barChart", {
        type: "bar",
        data: {
            labels: data.barXValues,
            datasets: [{
                backgroundColor: barColors,
                data: data.barYValues,
            }],
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: "Car Center Charts 2025",
            },
        },
    });

    // الرسم البياني الدائري
    new Chart("douChart", {
        type: "doughnut",
        data: {
            labels: data.douXValues,
            datasets: [{
                backgroundColor: douColors,
                data: data.douYValues,
            }],
        },
        options: {
            title: {
                display: true,
                text: "Total 30,000",
            },
        },
    });
}

// تحميل الرسوم البيانية عند تحميل الصفحة
loadCharts();


    const initSortingDropdown = () => {
    const sortingDropdown = document.querySelector('.sort-dropdown');
    if (!sortingDropdown) return;

    // Init sorting dropdown with the current value
    const url = new URL(window.location.href);
    const sortValue = url.searchParams.get('sort');
    if (sortValue) {
      sortingDropdown.value = sortValue;
    }

    sortingDropdown.addEventListener('change', (ev) => {
      const url = new URL(window.location.href);
      url.searchParams.set('sort', ev.target.value);
      window.location.href = url.toString();
    });

    const statusFilter = document.querySelector('.status-filter');
    if (statusFilter) {
        statusFilter.addEventListener('change', (ev) => {
            const url = new URL(window.location.href);
            if (ev.target.value) {
                url.searchParams.set('status', ev.target.value);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        });
    }

    }

    initSortingDropdown();

});