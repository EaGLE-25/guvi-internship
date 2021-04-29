const signupForm = $(".signup-form");


signupForm.submit(function(e){
    e.preventDefault();
    const formData = createFormData(".signup-form");
    const url = $(this).attr("action");
    fetch(url,{
        method:'POST',
        mode:'same-origin',
        body: formData
    }).then(res=> res.json())
    .then(data=>console.log(data));
})

function createFormData(formClassname){
    const inputFields = $(formClassname+" input");
    const formData = new FormData();
    inputFields.each(function(index,element){
        if(element.value){
            formData.append(element.name,element.value);
        }
    })
    return formData;
}