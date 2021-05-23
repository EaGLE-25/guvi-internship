import {fetchGet} from "./common.js";

const logoutBtn = $(".logout-btn");
const editBtn = $(".edit-btn");

window.onload = (event) => {
    const headers = {
        "Authorization":`Bearer ${sessionStorage.getItem("accessToken")}`,
        "X-Email":`${sessionStorage.getItem("email")}`
    }
    fetchGet("/dist/scripts/php/myprofile.php",headers).then(res=>{
        return res.json();
    }).then(data=>{
        if(data.code>=200 && data.code<=299){
            fillInputFields(data.userProfile);
            $(".loader").addClass("hidden");
        }else{
            sessionStorage.setItem("error",data.message);
            window.location.replace("/dist/html/signin.html");
        }
    })
    .catch(e=>console.error(e));
};

logoutBtn.click(function(e){
    e.preventDefault();
    sessionStorage.removeItem("accessToken");
    sessionStorage.removeItem("email");

    window.location.replace("/dist/html/signin.html");
})

function fillInputFields(userProfile){
    const inputFields = $(".myProfile-form input");

    inputFields.each(function(index,element){
        element.value = userProfile[element.name];
    })
}