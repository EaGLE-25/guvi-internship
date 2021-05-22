import {fetchGet} from "./common.js";

window.onload = (event) => {
    const headers = {
        "Authorization":`Bearer ${sessionStorage.getItem("accessToken")}`,
        "username":`${sessionStorage.getItem("username")}`
    }
    fetchGet("/dist/scripts/php/myprofile.php",headers).then(res=>{
        return res.json();
    }).then(data=>{
        if(data.code>=200 && data.code<=299){
            console.log(data);
        }else{
            sessionStorage.setItem("error",data.message);
            window.location.replace("/guvi internship/dist/html/signin.html");
        }
    })
    .catch(e=>console.error(e));
};