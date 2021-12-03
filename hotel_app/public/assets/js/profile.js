document.addEventListener("DOMContentLoaded", () => {


    const loader = document.querySelector(".preloader");

      // Functions 

      // Listener to show loading circle when page is reloading
      window.addEventListener("load", () => {
          loader.style.display = "none";

      });


});