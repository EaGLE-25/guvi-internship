import {fetchPost,createFormData, showSnackbar} from "./common.js";

const signinForm = $(".signin-form");


signinForm.submit(function(e){
    e.preventDefault();
    if(signinForm.valid()){
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
                console.log(data.message);
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