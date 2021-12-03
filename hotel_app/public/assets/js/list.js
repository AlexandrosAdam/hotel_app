document.addEventListener("DOMContentLoaded", () => {


      // Initializations
      const $scrollToTop = document.querySelector(".scroll-top");
      const $container = document.querySelector(".container");
      const $sliderOne = document.querySelector("#slider-1");
      const $sliderTwo = document.querySelector("#slider-2");
      const $firstVal = document.querySelector("#range1");
      const $secondVal = document.querySelector("#range2");
      const minGap = 0;
      const $sliderTrack = document.querySelector(".slider-track");
      const sliderMaxValue = document.querySelector("#slider-1").max;
      const $formSearch = document.querySelector(".form-search");
      const containerSearch = document.querySelector("#search-results-container");
      const loader = document.querySelector(".preloader");

      // Functions 

      // Listener to show loading circle when page is reloading
      window.addEventListener("load", () => {
          loader.style.display = "none";

      });


      // Function to go to the top of the page
      const scrollToTop = () => {
        $container.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth"
        });
      }
      // Checks if user scrolls more than 150 px then show the button
      $scrollToTop.style.display = "none";
      const handleScroll = () => {
          if ( $container.scrollTop > 150) {
              $scrollToTop.style.display = "block";
          } else {
              $scrollToTop.style.display = "none";
          }
      }
      // Check-in Check-out date function
      $(function() {
    
        /* global setting */
      let datepickersOpt = {
          dateFormat: 'yy-mm-dd',
          minDate   : 0
      }
  
      $("#checkin").datepicker($.extend({
          onSelect: function() {
              let minDate = $(this).datepicker('getDate');
              minDate.setDate(minDate.getDate() + 1); 
              $("#checkout").datepicker( "option", "minDate", minDate);
          }
      },datepickersOpt));
  
      $("#checkout").datepicker($.extend({
          onSelect: function() {
              let maxDate = $(this).datepicker('getDate');
              maxDate.setDate(maxDate.getDate());
              $("#checkin").datepicker( "option", "maxDate", maxDate );
          }
      },datepickersOpt));
  
    }); 

    const submitSearch = (e) => {

      // Preventing page from reloading
      e.preventDefault();

      // Get the input data from the form
      let myForm = e.target;
      const formData = new FormData(myForm);

      
      // url to make the ajax request
      const url = 'http://localhost/hotel_app/public/ajax/search_results.php';

       // create Request object
       let req = new Request(url, {
        method: 'POST',
        body: formData,     
      });
      
      fetch(req)
          .then(function (response) {
            if (response.status === 200){
              // The API call was successful
              return response.text();
            }else {
                throw new Error('Something went wrong..');
            }
          }).then(function(data) {
              // clear the container
              containerSearch.innerHTML = '';
              // Convert data string to object
              let doc = document.createRange().createContextualFragment(data);
              // append the data to container
              containerSearch.appendChild(doc);
              // Push url state
              let queryString = new URLSearchParams(formData).toString();
              history.pushState({}, '', 'http://localhost/hotel_app/public/list.php?' + queryString);

          }).catch(function(err) {
              // There was an error
              console.warn('Something went wrong.', err);
          });

    };


    // AddEventListeners
    $scrollToTop.addEventListener("click", scrollToTop);
    $container.addEventListener("scroll", handleScroll);
    $formSearch.addEventListener("submit", submitSearch);
      
    // Slider functionality
    $sliderOne.addEventListener('input', (e) => {
  
      if (parseInt($sliderTwo.value, 10) - parseInt($sliderOne.value, 10) <= minGap) {
          $sliderOne.value = parseInt($sliderTwo.value, 10) - minGap;
        }
        $firstVal.value = $sliderOne.value;
        fillColor();
        
    });
  
    $sliderTwo.addEventListener('input', (e) => {
  
      if (parseInt($sliderTwo.value, 10) - parseInt($sliderOne.value, 10) <= minGap) {
          $sliderTwo.value = parseInt($sliderOne.value, 10) + minGap;
        }
        $secondVal.value = $sliderTwo.value;
  
        fillColor();
    });
    // First and second box functionality
    $firstVal.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        $sliderOne.value = parseInt($firstVal.value, 10) - minGap;
        e.preventDefault();
      }
      fillColor();
  
    });
    $secondVal.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        $sliderTwo.value = parseInt($secondVal.value, 10) + minGap;
        e.preventDefault();
      }
      fillColor();
    });




});