$(function(){
    $.validator.addMethod("strongPassword",function(value,element){
      return this.optional(element)
      || value.length >=6
      && /\d/.test(value)
      && /[a-z]/i.test(value);
  },"Your password must be atleast 6 characters long and contain atleast one number and one character");

  $.validator.addMethod("mobile",function(value,element){
      return this.optional(element)
      || value.length == 10;
  },"Please enter a valid mobile number")

  $(".signup-form").validate({
    errorClass:"invalid",
    validClass:"valid",
    rules:{
        name:{
          required:true,
          lettersonly:true
        },
        email:{
          required:true,
          email:true
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
        email:"Please enter a valid email"
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
      const properInputHTML = `<i class="fas fa-check proper-input"></i>`;
      errorIndicator.html(properInputHTML);
    },
    highlight:function(element){
      const errorIndicator =  $(element).siblings(".invalid-input-indicator");
      const wrongInputHTML = `<i class="fas fa-times wrong-input"></i>`;
      errorIndicator.html(wrongInputHTML);
    },
    errorPlacement: function(error, element) {
      $(element).closest(".form-field").append(error);  
    },
    focusInvalid:false
  });
	
	
	$(".signin-form").validate({
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
      const properInputHTML = `<i class="fas fa-check proper-input"></i>`;
      errorIndicator.html(properInputHTML);
    },
    highlight:function(element){
      const errorIndicator =  $(element).siblings(".invalid-input-indicator");
      const wrongInputHTML = `<i class="fas fa-times wrong-input"></i>`;
      errorIndicator.html(wrongInputHTML);
    },
    errorPlacement: function(error, element) {
      $(element).closest(".form-field").append(error);  
    },
    focusInvalid:false
  })
})