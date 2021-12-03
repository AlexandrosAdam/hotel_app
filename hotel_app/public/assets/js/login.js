document.addEventListener("DOMContentLoaded", () => {


    const $email = document.querySelector("#email");
    const $errorEmail = document.querySelector(".email-error")

    const $password = document.querySelector("#password");
    const $errorPsw = document.querySelector(".password-error");
   
    const $form = document.querySelector("form");
    const $submit = document.querySelector("#login-btn");

    const togglePassword = document.querySelector("#togglePassword");
    const loader = document.querySelector(".preloader");

    // Functions 

    // Listener to show loading circle when page is reloading
    window.addEventListener("load", () => {
        loader.style.display = "none";

    });

    const getValidations = ({email, password}) => {

        let emailIsValid = false;
        let passwordIsValid = false;

        if (email !== "") {
            emailIsValid = true;
        }
        if (password !== "") {
            passwordIsValid = true;
        }

        return {
            emailIsValid,
            passwordIsValid
        }


    };




    
    $form.addEventListener("submit", (e) => {
        e.preventDefault();

        const {email, password} = e.target.elements; 

        const values = {
            email : email.value,
            password : password.value
        };

        
        const validations = getValidations(values);

        if (!validations.emailIsValid) {
            $email.classList.add("input-error");
            $errorEmail.classList.remove("d-none");
        } else {
            $email.classList.remove("input-error");
            $errorEmail.classList.add("d-none");
        }
        if (!validations.passwordIsValid) {
            $password.classList.add("input-error");
            $errorPsw.classList.remove("d-none");
        } else {
            $password.classList.remove("input-error");
            $errorPsw.classList.add("d-none");
        }

        if (validations.emailIsValid && validations.passwordIsValid) {
            $form.submit();
        }


    });

    togglePassword.addEventListener("click", function(e) {

        const type = $password.getAttribute("type") === "password" ? "text" : "password";
        $password.setAttribute("type", type);
        this.classList.toggle('fa-eye-slash');

    });



});