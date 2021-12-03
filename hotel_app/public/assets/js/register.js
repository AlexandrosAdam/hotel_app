document.addEventListener("DOMContentLoaded", () => {

    // Initialize variables

    const $name = document.querySelector("#name");
    const $errorName = document.querySelector(".name-error");

    const $email = document.querySelector("#email");
    const $errorEmail = document.querySelector(".email-error");

    const $confirmEmail = document.querySelector("#email_repeat");
    const $errorConfirmEmail = document.querySelector(".confirm-email-error");

    const $password = document.querySelector("#password");
    const $passwordValidation = document.querySelector(".password-validation");
    const togglePassword = document.querySelector("#togglePassword");

    const $form = document.querySelector("form");
    const loader = document.querySelector(".preloader");

    // Functions 

    // Listener to show loading circle when page is reloading
    window.addEventListener("load", () => {
        loader.style.display = "none";

    });

    const getValidations = ({name, email, email_repeat, password}) => {

        let nameIsValid = false;
        let emailIsValid = false;
        let confirmEmailIsValid = false;
        let passwordIsValid = false;

        // Check name validation    
        const regName = /^[a-zA-Z]+ [a-zA-Z]+$/;
        if (name !== "" && regName.test(name)){
            nameIsValid = true;
        }

        // Check email validation    
        const mailFormat = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email !== "" && mailFormat.test(email) ){
            emailIsValid = true;
        }
        // Confirm email validation
        if (email_repeat !== "" && email_repeat === email){
            confirmEmailIsValid = true;
        }

        // Check password validation
        const upperCaseLetters = /[A-Z]/g;
        const numbers = /[0-9]/g;
        const specialCharacter = /[^A-Za-z0-9]/;
        if (password.length >= 8 && password !== "" && upperCaseLetters.test(password) && numbers.test(password) && specialCharacter.test(password)){
            passwordIsValid = true;
        }

        return {
            nameIsValid,
            emailIsValid,
            confirmEmailIsValid,
            passwordIsValid
        }

    };

   
   
    // Event Listeners
    togglePassword.addEventListener("click", function(e) {

        const type = $password.getAttribute("type") === "password" ? "text" : "password";
        $password.setAttribute("type", type);
        this.classList.toggle('fa-eye-slash');

    });
 

    console.log("Inside javascript file!");

    $form.addEventListener("submit", (e) => {

        e.preventDefault();
        const {name, email, email_repeat, password} = e.target.elements;
        const values = {
            name : name.value,
            email: email.value,
            email_repeat: email_repeat.value,
            password : password.value
        };

        const validations = getValidations(values);

        if (!validations.nameIsValid){
            $name.classList.add("input-error");
            $errorName.classList.remove("d-none");
        }else {
            $name.classList.remove("input-error");
            $errorName.classList.add("d-none");
        }
        if (!validations.emailIsValid){
            $email.classList.add("input-error");
            $errorEmail.classList.remove("d-none");
        } else {
            $email.classList.remove("input-error");
            $errorEmail.classList.add("d-none");
        }
        if (!validations.confirmEmailIsValid){
            $confirmEmail.classList.add("input-error");
            $errorConfirmEmail.classList.remove("d-none");
        } else {
            $confirmEmail.classList.remove("input-error");
            $errorConfirmEmail.classList.add("d-none");
        }
        if (!validations.passwordIsValid) {
            $password.classList.add("input-error");
            $passwordValidation.classList.remove("d-none");
        } else {
            $password.classList.remove("input-error");
            $passwordValidation.classList.add("d-none");
        }

        if (validations.nameIsValid && validations.emailIsValid && validations.confirmEmailIsValid && validations.passwordIsValid){
            $form.submit();
        }
    });
        $errorName.classList.add("d-none");
        $errorEmail.classList.add("d-none");
        $errorConfirmEmail.classList.add("d-none");
        $passwordValidation.classList.add("d-none");

});