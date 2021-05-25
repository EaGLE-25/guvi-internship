import {fetchPost,createFormData, showSnackbar,basePath,Operation} from "./common.js";

const signinForm = $(".signin-form");

const signin = signinOperation();


window.onload = showError;

signinForm.submit(function(e){
    e.preventDefault();
    if(signinForm.valid()){
        signin.start();

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
                signin.end();
                const accessToken = data.accessToken;
                const uuid= data.uuid;

                sessionStorage.setItem("accessToken",accessToken);
                sessionStorage.setItem("uuid",uuid);

                window.location.pathname = `${basePath}/html/myprofile.html`;
            }else{
                throw new Error(data.message);
            }
        })
        .catch(e=>{
            signin.end();
            showSnackbar(e.message,"error-snackbar");
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

function signinOperation(){
    const signinBtn = $(".signin-btn");
    const operation = new Operation(signinBtn,"Signingin","signing-in-span");

    return operation;
}