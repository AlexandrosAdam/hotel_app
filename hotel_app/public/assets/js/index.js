document.addEventListener("DOMContentLoaded", () => {

    const $form = document.querySelector("form");
    const $cityOption = document.querySelector(".city-drop");
    const $errorMsg = document.querySelector(".text-danger");
    const loader = document.querySelector(".preloader");


    
    // Listener to show loading circle when page is reloading
    window.addEventListener("load", () => {
        loader.style.display = "none";
    });
    

    const getValidations = ({city, checkin, checkout}) => {

        let cityIsValid = false;
        let checkinIsValid = false;
        let checkoutIsValid = false;

    

        if (city !== "" && checkin !== "" && checkout !== "" && checkin !== "Check-in" && checkout !== "Check-out") {
            cityIsValid = true;
            checkinIsValid = true;
            checkoutIsValid = true;
        }
        return {
            cityIsValid,
            checkinIsValid,
            checkoutIsValid,
        };

        

    }; 

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
    
    

    $form.addEventListener("submit", (e) => {

        e.preventDefault();
        const {city,room_type, checkin, checkout} = e.target.elements;
        const values = {
            city : city.value,
            room_type : room_type.value,
            checkin: checkin.value,
            checkout: checkout.value,
        };
        const validations = getValidations(values);

        if (!validations.cityIsValid) {
            $errorMsg.classList.remove("d-none");
        } else {
            $errorMsg.classList.add("d-none");
        }
        if (validations.cityIsValid && validations.checkinIsValid && validations.checkoutIsValid) {
           $form.submit();
        }
    });

    $errorMsg.classList.add("d-none");

    

});

