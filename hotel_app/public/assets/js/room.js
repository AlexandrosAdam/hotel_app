document.addEventListener("DOMContentLoaded", () => {

    
    // Initializations
    const $scrollToTop = document.querySelector(".scroll-top");
    const $mainContainer = document.querySelector(".main-container");
    const $reviewForm = document.querySelector(".reviewForm");
    const  $rate = document.querySelectorAll('input[name="rate"]');
    const reviewContainer = document.getElementById('room-reviews-container');
    const $favoriteForm = document.querySelector(".favoriteForm");
    const loader = document.querySelector(".preloader");
    // Functions 

    // Listener to show loading circle when page is reloading
    window.addEventListener("load", () => {
        loader.style.display = "none";

    });



    // Function to go to the top of the page
    const scrollToTop = () => {

        $mainContainer.scrollTo({
            top: 0,
            left: 0,
            behavior: "smooth"
        });
    }
    $scrollToTop.style.display = "none";
    // Checks if user scrolls more than 150 px then show the button
    const handleScroll = () => {
       
        if ( $mainContainer.scrollTop > 150) {
            $scrollToTop.style.display = "block";
        } else {
            $scrollToTop.style.display = "none";
        }
    }

   // Function to make the ajax request to submit review form
   const reviewSubmit = (e) => {

        // Preventing page from reloading
        e.preventDefault();

        for (let i = 0; i < $rate.length; i++) {
            if ($rate[i].checked) {
                validRadio = true;
                break;
            }
        }
        // Check if at least one star is selected
        if (validRadio) {    
        // Get the input data from the form
        let myForm = e.target;
        const formData = new FormData(myForm);

        // url to make the ajax request
        const url = 'http://localhost/hotel_app/public/ajax/room_review.php';
       
        // create Request object
        let req = new Request(url, {
            method: 'POST',
            body: formData,     
        });
        // fetch the data
        fetch(req)
            .then(function (response){
                if (response.status === 200){
                    // The API call was successful
                    return response.text();
                }else {
                    throw new Error('Something went wrong..');
                }
                
            }).then(function(data){
                let doc = document.createRange().createContextualFragment(data);
                // Append the result on container
                reviewContainer.appendChild(doc);
                // Reset review form 
                myForm.reset();
            }).catch(function(err) {
                // There was an error
                console.warn('Something went wrong.', err);
            });
        }
   }

   // Function to make the ajax request to submit favorite form
   const favoriteSubmit = (e) => {

        let isFavorite = document.querySelector('input[name="is_favorite"]');
        let heart = document.querySelector(".star");
        // Preventing page from reloading
        e.preventDefault();
        // get input data from the form
        const formData = new FormData($favoriteForm);
        // url to make the ajax request
        const url = 'http://localhost/hotel_app/public/ajax/room_favorite.php';
         // create Request object
         let req = new Request(url, {
            method: 'POST',
            body: formData,     
        });

        // fetch the data
        fetch(req)
            .then(function (response){
                if (response.status === 200){
                    // The API call was successful
                    return response.json();
                }else {
                    throw new Error('Something went wrong..');
                }
                
            }).then(function(data){
                if (data.status){
                    isFavorite.value = data.is_favorite ? 1 : 0;
                    heart.classList.toggle('selected');
                }
            }).catch(function(err) {
                // There was an error
                console.warn('Something went wrong.', err);
            });


               


   }

    // AddEventListeners
    $scrollToTop.addEventListener("click", scrollToTop);
    $mainContainer.addEventListener("scroll", handleScroll);
    $reviewForm.addEventListener("submit", reviewSubmit);
    $favoriteForm.addEventListener("click", favoriteSubmit);
    

});

