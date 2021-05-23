import {fetchPost,createFormData, showSnackbar} from "./common.js";

const signinForm = $(".signin-form");


const signingInSpan = $(".signing-in-span");
const signInSpan = $(".sign-in-span");

window.onload = showError;

signinForm.submit(function(e){
    e.preventDefault();
    if(signinForm.valid()){
        signInSpan.removeClass("show");
        signInSpan.addClass("hide");
        signingInSpan.removeClass("hide");
        signingInSpan.addClass("show");


        const emailField = $(".signin-form #email")[0];
        const passwordField = $(".signin-form #password")[0];

        const email = emailField.value.trim();
        const password = passwordField.value.trim();

        const emailPassword = `${email}:${password}`;
        const base64emailPassword = btoa(emailPassword);
        const authHeaderValue = "Basic "+base64emailPassword;

        const headers = {
            "Authorization":authHeaderValue
        }

        const url = signinForm.attr("action");
        fetchPost(url,null,headers).then(res=>res.json())
        .then(data=>{
            if(data.code>=200 && data.code<=299){
                const accessToken = data.accessToken;
                const email= data.email;

                sessionStorage.setItem("accessToken",accessToken);
                sessionStorage.setItem("email",email);

                window.location.pathname = "/guvi internship/dist/html/myprofile.html";
            }else{
                throw new Error(data.message);
            }
        })
        .catch(e=>{
            siginFailed(e.message);
        });
    }
})

function showError(){
    const err = sessionStorage.getItem("error");

    if(err){
        showSnackbar(err,"error-snackbar");
        sessionStorage.removeItem("error");
    }
}

function siginFailed(message){
    signInSpan.removeClass("hide");
    signInSpan.addClass("show");
    signingInSpan.removeClass("show");
    signingInSpan.addClass("hide");

    showSnackbar(message,"error-snackbar");
}