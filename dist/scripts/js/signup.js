import {signupValidator} from "./validations.js";
import {fetchPost,createFormData,showSnackbar,basePath,Operation} from "./common.js";

const signupForm = $(".signup-form");

// intialize createAccOperation to be called on account creation.
let createAcc = createAccOperation();


signupForm.submit(function(e){
    e.preventDefault();
    // check for form validity
    if(signupForm.valid()){
        // disable create account btn with loading visual
        createAcc.start();

        const url = $(this).attr("action");
        // serialize input values as formData
        const formData = createFormData(".signup-form");
        
        fetchPost(url,formData).then(res=>{
            return res.json();
        })
        .then(data=>{
            if(data.code >=200 && data.code<=299){
                const message = data.message;
                signupSuccess(message);
            }else{
                throw new Error(data.message);
            }
        })
        .catch(e=>{
            showSnackbar(e.message,"error-snackbar");
            // stop loading visual also enable create account btn
            createAcc.end();
        });
    } 
})




function signupSuccess(message){
    const errorIndingIcons =  document.querySelectorAll(".input-validity-indicator i");

    createAcc.end();
    // reset the validators
    signupValidator.resetForm();
    // reset all the input fields
    signupForm[0].reset();
    // remove error indicators
    errorIndingIcons.forEach(icon=>icon.remove());
    // show success message
    showSnackbar(message,"success-snackbar");
}

 function createAccOperation(){
    const createAccountBtn = $(".create-account");
    const operation = new Operation(createAccountBtn,"Creating","creating-account-span");

    return operation;
}