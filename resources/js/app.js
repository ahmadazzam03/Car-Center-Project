import axios from 'axios';
import './bootstrap';

document.addEventListener("DOMContentLoaded", function () {

  const iframe = document.querySelector('iframe[data-src]');
    if (iframe) {
        iframe.src = iframe.dataset.src;
    }
  // ------------------- وظائف الصور -------------------
  const initImagePicker = () => {
      const fileInput = document.querySelector("#carFormImageUpload");
      const imagePreview = document.querySelector("#imagePreviews");
      if (!fileInput) {
        return;
      }
      fileInput.onchange = (ev) => {
        imagePreview.innerHTML = "";
        const files = ev.target.files;
        for (let file of files) {
          readFile(file).then((url) => {
            const img = createImage(url);
            imagePreview.append(img);
          });
        }
      };
  
      function readFile(file) {
        return new Promise((resolve, reject) => {
          const reader = new FileReader();
          reader.onload = (ev) => {
            resolve(ev.target.result);
          };
          reader.onerror = (ev) => {
            reject(ev);
          };
          reader.readAsDataURL(file);
        });
      }
  
      function createImage(url) {
        const a = document.createElement("a");
        a.classList.add("car-form-image-preview");
        a.innerHTML = `
          <img src="${url}" />
        `;
        return a;
      }
    };
  
    const imageCarousel = () => {
      const carousel = document.querySelector('.car-images-carousel');
      if (!carousel) {
        return;
      }
      const thumbnails = document.querySelectorAll('.car-image-thumbnails img');
      const activeImage = document.getElementById('activeImage');
      const prevButton = document.getElementById('prevButton');
      const nextButton = document.getElementById('nextButton');
  
  
      let currentIndex = 0;
  
      // Initialize active thumbnail class
      thumbnails.forEach((thumbnail, index) => {
        if (thumbnail.src === activeImage.src) {
          thumbnail.classList.add('active-thumbnail');
          currentIndex = index;
        }

      });
  
      // Function to update the active image and thumbnail
      const updateActiveImage = (index) => {
        activeImage.src = thumbnails[index].src;
        thumbnails.forEach(thumbnail => thumbnail.classList.remove('active-thumbnail'));
        thumbnails[index].classList.add('active-thumbnail');
      };
  
      // Add click event listeners to thumbnails
      thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', () => {
          currentIndex = index;
          updateActiveImage(currentIndex);
        });
      });
  
      // Add click event listener to the previous button
      prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
        updateActiveImage(currentIndex);
      });
  
      // Add click event listener to the next button
      nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % thumbnails.length;
        updateActiveImage(currentIndex);
      });
    }

  // ------------------- وظائف البحث والتصفية -------------------
  const initMobileFilters = () => {
      const filterButton = document.querySelector('.show-filters-button');
      const sidebar = document.querySelector('.search-cars-sidebar');
      const closeButton = document.querySelector('.close-filters-button');
  
      if (!filterButton) return;
  
      console.log(filterButton.classList)
      filterButton.addEventListener('click', () => {
        if (sidebar.classList.contains('opened')) {
          sidebar.classList.remove('opened')
        } else {
          sidebar.classList.add('opened')
        }
      });
  
      if (closeButton) {
        closeButton.addEventListener('click', () => {
          sidebar.classList.remove('opened')
        })
      }
    }
  
    const initCascadingDropdown = (parentSelector, childSelector) => {
      const parentDropdown = document.querySelector(parentSelector);
      const childDropdown = document.querySelector(childSelector);
  
      if (!parentDropdown || !childDropdown) return;
  
      hideModelOptions(parentDropdown.value)
  
      parentDropdown.addEventListener('change', (ev) => {
        hideModelOptions(ev.target.value)
        childDropdown.value = ''
      });
  
      function hideModelOptions(parentValue) {
        const models = childDropdown.querySelectorAll('option');
        models.forEach(model => {
          if (model.dataset.parent === parentValue || model.value === '') {
            model.style.display = 'block';
          } else {
            model.style.display = 'none';
          }
        });
      }
    }

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
    }

  // ------------------- وظائف القائمة المفضلة -------------------

    const initAddToWishList = () => {
      // Select add to watchlist buttons
      const buttons = document.querySelectorAll('.btn-heart');
      if(!buttons) return; 
      // Iterate over these buttons and add click event listener
      buttons.forEach((button) => {
        button.addEventListener('click', ev => {
          // Get the button element on which click happened
  const button = ev.currentTarget;
  // We added data-url attribute to the button in blade file
  // get the url
  const url = button.dataset.url;
  // Make request on the URL to add or remove the car from watchlist
  axios.post(url).then((response) => {
    // Select both svg tags of the button
    const toShow = button.querySelector('svg.hidden');
    const toHide = button.querySelector('svg:not(.hidden)');

    // Which was hidden must be displayed
    toShow.classList.remove('hidden')
    // Which was displayed must be hidden
    toHide.classList.add('hidden')
    // Show alert to the user
      Swal.fire({
          title: response.data.message,
          icon: 'success',
          confirmButtonText: 'OK'
      });
  })
    .catch(error => 
      {
        console.error(error.response)
        if(error?.response.status === 401)
        {
          Swal.fire({
            title: 'Please authenticate first to add cars into watchlist',
            icon: 'info',
            confirmButtonText: 'OK'
        });
          // alert("Please authenticate first to add cars into watchlist.")
        }
        else 
        {
          Swal.fire({
            title: 'Internal Server Error. Please Try again later!',
            icon: 'info',
            confirmButtonText: 'OK'
        });
          // alert("Internal Server Error. Please Try again later!")
        }
      })
    })
  })
  }
  // ------------------- وظائف عرض رقم الهاتف -------------------
  const initShowPhoneNumber = () => {
    // Select the element we need to listen to click
  const span = document.querySelector('.car-details-phone-view');
    if(span)
    {
      span.addEventListener('click', ev => {
        ev.preventDefault();
        // Get the url on which we should make Ajax request
        const url = span.dataset.url;
    
        // Make the request
        axios.post(url).then(response => {
          // Get response from backend and take actual phone number
          const phone = response.data.phone;
          // Find the <a> element
          const a = span.parentElement;
          // and update its href attribute with full phone number received from backend
          a.href = 'tel:' + phone;
          // Find the element which contains obfuscated text and update it
          const phoneEl = a.querySelector('.text-phone')
          phoneEl.innerText = phone;
        })
      });
    }
    else 
    {
      console.error('Element with class "car-details-phone-view" not found');

    }
  }

    // ------------------- وظائف التنقل -------------------

    const overlay = document.querySelector("[data-overlay]");
    const navbar = document.querySelector("[data-navbar]");
    const navToggleBtn = document.querySelector("[data-nav-toggle-btn]");
    const navbarLinks = document.querySelectorAll("[data-nav-link]");
    
    const navToggleFunc = function () {
        navToggleBtn.classList.toggle("active");
        navbar.classList.toggle("active");
        overlay.classList.toggle("active");
        };
    
    if(navToggleBtn) navToggleBtn.addEventListener("click", navToggleFunc);
    if(overlay) overlay.addEventListener("click", navToggleFunc);
    
    navbarLinks.forEach(link => link.addEventListener("click", navToggleFunc));
    

      // ------------------- وظائف التمرير -------------------

      const header = document.querySelector("[data-header]");

      if(header)
      {
        window.addEventListener("scroll", function () {
          header.classList.toggle("active", window.scrollY >= 10);
        });
      }
        // ------------------- وظائف العرض -------------------

        let sr = ScrollReveal({
          duration:2500,
          distance: "60px",
          origin:'top',
          delay :400
        });
        
        sr.reveal(".hero-banner,.navbar-list ",{origin:"right"});
        sr.reveal(".hero-content ,.hero-form " ,{origin:"left" , delay:700});
        sr.reveal('.service-card,.service-banner',{interval:100});

          // ------------------- وظائف السلايدر -------------------
          let currentIndex = 0;
          const slides = document.querySelectorAll('.slide');
          const dots = document.querySelectorAll('.dot');
          
          function showSlide(index) {
              const slider = document.querySelector('.slider');
              if(!slider) return;

              if (index >= slides.length) currentIndex = 0;
              if (index < 0) currentIndex = slides.length - 1;
              slider.style.transform = `translateX(-${currentIndex * (100 / slides.length)}%)`;
              updateDots();
          }
          
          function updateDots() {
              dots.forEach((dot, i) => {
                  dot.classList.toggle('active', i === currentIndex);
              });
          }
          if(dots.length>0)
          {
            dots.forEach((dot, i) => {
                dot.addEventListener('click', () => {
                    currentIndex = i;
                    showSlide(i);
                });
              });

              setInterval(() => {
                currentIndex++;
                showSlide(currentIndex);
            }, 4000);

            showSlide(currentIndex);
          }
          
            // ------------------- وظائف الفريق -------------------

            const teamMembers = document.querySelectorAll(".team-member");

            teamMembers.forEach(member => {
                member.addEventListener("mouseenter", () => {
                  const glassEffect = member.querySelector(".glass-effect");
                  if (glassEffect) glassEffect.style.boxShadow = "0px 15px 35px rgba(255, 255, 255, 0.3)";
                });
          
                member.addEventListener("mouseleave", () => {
                  const glassEffect = member.querySelector(".glass-effect");
                  if (glassEffect) glassEffect.style.boxShadow = "0px 10px 30px rgba(0, 0, 0, 0.3)";
                });
            });
          
              // ------------------- وظائف الوضع الليلي -------------------
              const toggleBtn = document.getElementById("toggle-theme");
              const body = document.body;
              if(toggleBtn)
              {
                const icon = toggleBtn.querySelector("i");

                if (localStorage.getItem("theme") === "dark") {
                    body.classList.add("dark-mode");
                    icon.classList.replace("bx-moon", "bx-sun");
                }

                toggleBtn.addEventListener("click", function () {
                  body.classList.toggle("dark-mode");
            
            
                  if (body.classList.contains("dark-mode")) {
                      localStorage.setItem("theme", "dark");
                      icon.classList.replace("bx-moon", "bx-sun");
                  } else {
                      localStorage.setItem("theme", "light");
                      icon.classList.replace("bx-sun", "bx-moon");
                  }
                });
              }
              // ------------------- تهيئة الوظائف -------------------
    initImagePicker();
    imageCarousel();
    initCascadingDropdown('#makerSelect', '#modelSelect');
    initCascadingDropdown('#stateSelect', '#citySelect');
    initSortingDropdown();
    initAddToWishList();
    initShowPhoneNumber();
    initMobileFilters();

      // ------------------- وظائف إضافية -------------------

    document.getElementById('cridt_card_number').addEventListener('input', function (e) {
      let value = e.target.value.replace(/\s/g, '');
        if (value.length > 0) {
          value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
      }
        e.target.value = value;
    });
  });


  
  
