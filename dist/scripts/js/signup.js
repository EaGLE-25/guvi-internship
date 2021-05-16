import {signupValidator} from "./validations.js";
import {fetchPost,createFormData,showSnackbar} from "./common.js";

const signupForm = $(".signup-form");
const createAccountBtn = $(".create-account");

const creatingAccSpan = $(".creating-account-span");
const createAccSpan = $(".create-account-span");


signupForm.submit(function(e){
    e.preventDefault();
    if(signupForm.valid()){
        createAccSpan.removeClass("show");
        createAccSpan.addClass("hide");
        creatingAccSpan.removeClass("hide");
        creatingAccSpan.addClass("show");

        const url = $(this).attr("action");
        const formData = createFormData(".signup-form");
        
        fetchPost(url,formData).then(res=>{
            if(res.ok){
                res.json();
            }else{
                throw new Error(res.statusText);
            }
        })
        .then(data=>{
            signupSuccess();
        })
        .catch(e=>console.error(e))
    } 
})




function signupSuccess(){
    const createAccountHTML = createAccountBtn.html();
    const errorIndingIcons =  document.querySelectorAll(".invalid-input-indicator i");

    // reset create account btn
    createAccSpan.removeClass("hide");
    createAccSpan.addClass("show");
    creatingAccSpan.addClass("hide");
    createAccountBtn.blur();
    
    // reset the validators
    signupValidator.resetForm();
    // reset all the input fields
    signupForm[0].reset();
    // remove error indicators
    errorIndingIcons.forEach(icon=>icon.remove());
    // show success message
    showSnackbar();
}