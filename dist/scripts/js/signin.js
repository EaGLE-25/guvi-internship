import {fetchPost,createFormData, showSnackbar} from "./common.js";

const signinForm = $(".signin-form");


const signingInSpan = $(".signing-in-span");
const signInSpan = $(".sign-in-span");


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
                const username = data.username;

                sessionStorage.setItem("accessToken",accessToken);
                sessionStorage.setItem("username",username);

                const path = window.location.pathname;
                window.location.pathname = "/dist/html/myprofile.html";
            }else{
                throw new Error(data.message);
            }
        })
        .catch(e=>{
            siginFailed(e.message);
        });
    }
})

function siginFailed(message){
    showSnackbar(message,"error-snackbar");
}