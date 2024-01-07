import { swalOptions } from "../swalOptions.js";

//function for validate form from front

document.addEventListener('DOMContentLoaded', function(){
    const formRegister = document.querySelector('#register');
    formRegister.onsubmit = (e) => {
        e.preventDefault();
        //define form variables
        const name = document.querySelector('#name').value;
        const email = document.querySelector('#email').value;
        const pass = document.querySelector('#password').value;
        const pass1 = document.querySelector('#password1').value;

        if(name == '' || email == '' || pass == '' || pass1 == '' ){    
            Swal.fire({
                width : swalOptions.width,
                background: swalOptions.background,
                color: swalOptions.color,
                icon : 'error',
                title: '<h3 class="text-amber-500">Oops...</h3>',
                html: '<h4>Todos los campos son obligatorios</h4>',
                confirmButtonColor: swalOptions.confirmButtonColor,
                confirmButtonText: '<h5>Aceptar</h5>'
            });
        }
        else if(pass != pass1) {
            Swal.fire({
                width : swalOptions.width,
                background: swalOptions.background,
                color: swalOptions.color,
                icon : 'error',
                title: '<h3 class="text-amber-500">Oops...</h3>',
                html: '<h4>Las contraseñas no coinciden</h4>',
                confirmButtonColor: swalOptions.confirmButtonColor,
                confirmButtonText: '<h5>Aceptar</h5>'
            });
            return false;
        }

        //send form info
        const formData = new FormData(formRegister);
        const url = base_url + '/register/store';
        fetch(url, {
            method: 'POST',
            headers: { contentType: 'application/json'},
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status){
                Swal.fire({
                    width : swalOptions.width,
                    background: swalOptions.background,
                    color: swalOptions.color,
                    icon : 'success',
                    title: '<h3 class="text-amber-500">Listo!</h3>',
                    html: '<h4>'+ data.msg +'</h4>',
                    confirmButtonColor: swalOptions.confirmButtonColor,
                    confirmButtonText: '<h5>Aceptar</h5>'
                })
                .then((result) => {
                    if(result.isConfirmed){
                        setTimeout(location.href = '../home', 3000);
                    }
                })
            }
            else{
                Swal.fire({
                    width : swalOptions.width,
                    background: swalOptions.background,
                    color: swalOptions.color,
                    icon : 'error',
                    title: '<h3 class="text-amber-500">Oops...</h3>',
                    html: '<h4>'+ data.msg +'</h4>',
                    confirmButtonColor: swalOptions.confirmButtonColor,
                    confirmButtonText: '<h5>Aceptar</h5>'
                });
            }
        })
        .catch(err => console.error(err));
    }
}, false);


//eye pass
let eye_1=document.querySelector(".eye_1");
let pass1=document.querySelector("#password");
let seteye_1=document.querySelector(".eye_1");

eye_1.addEventListener('click',function(){
   if(pass1.type=="password"){
       pass1.type="text";
       seteye_1.classList.remove('fa-eye');
       seteye_1.classList.add('fa-eye-slash');
   }
   else{
       pass1.type="password";
       seteye_1.classList.add('fa-eye');
       seteye_1.classList.remove('fa-eye-slash');
   }
});

//eye pass
let eye_2=document.querySelector(".eye_2");
let pass2=document.querySelector("#password1");
let seteye_2=document.querySelector(".eye_2");

eye_2.addEventListener('click',function(){
   if(pass2.type=="password"){
       pass2.type="text";
       seteye_2.classList.remove('fa-eye');
       seteye_2.classList.add('fa-eye-slash');
   }
   else{
       pass2.type="password";
       seteye_2.classList.add('fa-eye');
       seteye_2.classList.remove('fa-eye-slash');
   }
});