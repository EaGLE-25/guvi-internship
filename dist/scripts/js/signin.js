import {fetchPost,createFormData} from "./common.js";

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
        fetchPost(url,null,headers).then(res=>{
            if(res.ok){
                res.json();
            }else{
                throw new Error(res.statusText);
            }
        }).then(data=>console.log(data))
        .catch(e=>console.error(e));
    }
})

