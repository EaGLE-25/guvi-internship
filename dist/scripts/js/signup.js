import {signupValidator} from "./validations.js";
import {fetchPost,createFormData,showSnackbar,basePath,Operation} from "./common.js";

const signupForm = $(".signup-form");

let createAcc = createAccOperation();


signupForm.submit(function(e){
    e.preventDefault();
    if(signupForm.valid()){
        
        createAcc.start();

        const url = $(this).attr("action");
        const formData = createFormData(".signup-form");
        
        fetchPost(url,formData).then(res=>{
            if(res.status >=200 && res.status<=299){
                return res.json();
            }else{
                throw new Error(res.statusText);
            }
        })
        .then(data=>{
            const message = data.message;
            signupSuccess(message);
        })
        .catch(e=>{
            showSnackbar(e.message,"error-snackbar");
            createAcc.end();
        });
    } 
})




function signupSuccess(message){
    const errorIndingIcons =  document.querySelectorAll(".invalid-input-indicator i");

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