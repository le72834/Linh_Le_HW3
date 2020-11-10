import { SendMail } from "./components/mail.js";

(() => {

    let mailSubmit = document.querySelector('.submit-button');
    

    //function go in the middle
    // var onloadCallback = function() {
    //     alert("grecaptcha is ready!");
    //   };
    
    function processMailFailure(result) {
        //show a failure message in the UI
        console.table(result);
        alert(result.message);
    }
    function processMailSuccess(result) {
        //show a success message in the UI
        //table shows an object in table form
        console.table(result);
        //let user know the mail attempt was successful
        alert(result.message);
    }

    function processMail(event) {
        //block the default submit behaviour
        event.preventDefault();

        SendMail(this.parentNode)
            .then(data => processMailSuccess(data))
            .catch(err => processMailFailure(err));
    }



    //eventListener go here
    mailSubmit.addEventListener("click", processMail);
})();