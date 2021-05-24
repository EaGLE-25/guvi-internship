 $.validator.addMethod("strongPassword",function(value,element){
      return this.optional(element)
      || value.length >=6
      && /\d/.test(value)
      && /[a-z]/i.test(value);
  },"Your password must be atleast 6 characters long and contain atleast one number and one character");

  $.validator.addMethod("mobile",function(value,element){
    return this.optional(element)
    || value.length == 10
    && /^\d*$/.test(value);
  },"Please enter a valid mobile number")

  let signupValidator = $(".signup-form").validate({
    errorClass:"invalid",
    validClass:"valid",
    rules:{
        name:{
          required:true,
          lettersonly:true
        },
        email:{
          required:true,
          email:true,
          remote:{
            url:"/dist/scripts/php/isEmailAvailable.php",
            type: "get",
            data:{
              email:function(){
                return $("#email").val();
              },
              for:"signup"
            }
          }
        },
        password:{
          required:true,
          strongPassword:true
        },
        mob:{
          required:true,
          mobile:true,
          digits:true
        }
    },
    messages:{
      name:{
        required:"Pleae enter your name",
      },
      email:{
        required:"Please enter your email",
        email:"Please enter a valid email",
        remote:"This email is already associated with a account.Would like to <a href='/dist/html/signin.html'>login</a>"
      },
      password:{
        required:"Please enter a password"
      },
      mob:{
        required:"Please enter your mobile number",
        digits:"Digits only please"
      }
    },
    success:function(label,input){  
      const errorIndicator = $(input).siblings(".invalid-input-indicator");
      const wrongInputIcon = errorIndicator.children(".wrong-input");
      const properInputIcon = errorIndicator.children(".proper-input");

      wrongInputIcon.removeClass("show");
      properInputIcon.addClass("show");
    },
    highlight:function(element){
      $(element).removeClass("valid");
      $(element).addClass("invalid");
      const errorIndicator =  $(element).siblings(".invalid-input-indicator");
      const wrongInputIcon = errorIndicator.children(".wrong-input");
      const properInputIcon = errorIndicator.children(".proper-input");

      properInputIcon.removeClass("show");
      wrongInputIcon.addClass("show");
    },
    unhighlight:function(element){
      $(element).removeClass("invalid");
      $(element).addClass("valid");
    },
    errorPlacement: function(error, element) {
      $(element).closest(".form-field").append(error);  
    },
    focusInvalid:false
  });
	
	
	let signinValidator = $(".signin-form").validate({
    errorClass:"invalid",
    validClass:"valid",
    rules:{
        email:{
          required:true,
          email:true
        },
        password:{
          required:true
        }
    },
    messages:{
      email:{
        required:"Please enter your email",
        email:"Please enter a valid email"
      },
      password:{
        required:"Please enter a password"
      }
    },
    success:function(label,input){  
      const errorIndicator = $(input).siblings(".invalid-input-indicator");
      const wrongInputIcon = errorIndicator.children(".wrong-input");

      wrongInputIcon.removeClass("show");
    },
    highlight:function(element){
      $(element).removeClass("valid");
      $(element).addClass("invalid");
      const errorIndicator =  $(element).siblings(".invalid-input-indicator");
      const wrongInputIcon = errorIndicator.children(".wrong-input");
      
      wrongInputIcon.addClass("show");
    },
    unhighlight:function(element){
      $(element).removeClass("invalid");
      $(element).addClass("valid");
    },
    errorPlacement: function(error, element) {
      $(element).closest(".form-field").append(error);  
    },
    focusInvalid:false
  })

  let myProfileValidator = $(".myProfile-form").validate({
    errorClass:"invalid",
    validClass:"valid",
    rules:{
        name:{
          required:true,
          lettersonly:true
        },
        email:{
          required:true,
          email:true,
          remote:{
            url:"/dist/scripts/php/isEmailAvailable.php",
            type: "get",
            data:{
              email:function(){
                return $("#email").val();
              },
              for:"update"
            },
            beforeSend: function(request) {
              request.setRequestHeader("X-Uuid", sessionStorage.getItem("uuid"));
            }
          }
        },
        mobile:{
          required:true,
          mobile:true,
          digits:true
        }
    },
    messages:{
      name:{
        required:"Please enter your name",
      },
      email:{
        required:"Please enter your email",
        email:"Please enter a valid email",
        remote:"This email is already associated with a account"
      },
      mobile:{
        required:"Please enter your mobile number",
        digits:"Digits only please"
      }
    },
    highlight:function(element){
      $(element).removeClass("valid");
      $(element).addClass("invalid");
    },
    unhighlight:function(element){
      $(element).removeClass("invalid");
      $(element).addClass("valid");
    },
    errorPlacement: function(error, element) {
      $(element).closest(".form-field").append(error);  
    },
    focusInvalid:false
  });

  export {signupValidator,myProfileValidator};