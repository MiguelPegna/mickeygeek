$('.js-addwish-b2').each(function(){
    //var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
    $(this).on('click', function(){
        //let key = Date.now(); //para los div de productos relacionados
        let id = this.getAttribute('id');
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/productos/favorites';
        let formData = new FormData();
        formData.append('id',id);
        //console.log(id);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    Swal.fire({
                       width: '35%',
                       icon:'success',
                       //title: '<h3>'+nameProduct+'</h3>',
                       html: '<h4>'+objData.msg+'</h4>',
                       confirmButtonColor: '#13322B',
                       confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    if(objData.result ==1){
                        document.querySelector('.'+id).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>`;
                    }
                    else{
                        document.querySelector('.'+id).innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>`;
                    }
                }
               else{
                    Swal.fire({
                       width: '35%',
                       icon:'error',
                       title: '<h3>Oops...</h3>',
                       html: '<h4>'+objData.msg+'</h4>',
                       confirmButtonColor: '#13322B',
                       confirmButtonText: '<h5>Aceptar</h5>'
                    });
                }
            }    
        }   // end request function
        return false;
        //$(this).addClass('js-addedwish-b2');
        //$(this).off('click');
    });
});

//AGREGAR A FAVORITOS
$('.js-addwish-detail').each(function(){
    //var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

    $(this).on('click', function(){
        let id = this.getAttribute('id');
       /////////
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/productos/favorites'; 
        let formData = new FormData();
        formData.append('id',id);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    Swal.fire({
                       width: '35%',
                       icon:'success',
                       //title: '<h3>'+nameProduct+'</h3>',
                       html: '<h4>'+objData.msg+'</h4>',
                       confirmButtonColor: '#13322B',
                       confirmButtonText: '<h5>Aceptar</h5>'
                    });
                    if(objData.result ==1){
                        document.querySelector('.divFav').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>`;
                    }
                    else{
                        document.querySelector('.divFav').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>`;
                    }
                }
               else{
                    Swal.fire({
                       width: '35%',
                       icon:'error',
                       title: '<h3>Oops...</h3>',
                       html: '<h4>'+objData.msg+'</h4>',
                       confirmButtonColor: '#13322B',
                       confirmButtonText: '<h5>Aceptar</h5>'
                    });
                }
            }   
           return false;
       }   // end request function 

        //$(this).addClass('js-addedwish-detail');
        //$(this).off('click');
    });
});

/*---------------------------------------------*/
//AGREGAR PRODDUCTO a CARRITO
$('.js-addcart-detail').each(function(){
    let nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
    let quantity =1;
    $(this).on('click', function(){
        let id = this.getAttribute('id');
        if(document.querySelector('#quantity')){
            quantity = document.querySelector('#quantity').value;
        }
        if(this.getAttribute('prpz')){
            quantity = this.getAttribute('prpz');
        }
        //fin validacion form
        
        //////////
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/productos/addCarrito'; 
	    let formData = new FormData();
        let talla = document.querySelector('input[type=radio][name=talla]:checked').value;
        let gender = document.querySelector('#gender').value;
	    formData.append('id',id);
	    formData.append('quantity',quantity);
	    formData.append('talla',talla);
	    formData.append('gender',gender);
	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
	        	let objData = JSON.parse(request.responseText);
	        	if(objData.status){
		            document.querySelector('#itemsCart').innerHTML = objData.html;
                    document.querySelector('#itemsP').setAttribute('data-notify', objData.totalPr);
                    Swal.fire({
                        width: '35%',
                        icon:'success',
                        html: '<h4>Agregado al carrito</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                }
                else{
                    Swal.fire({
                        width: '35%',
                        icon:'error',
                        title: '<h3>Oops...</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                }
            }   
            return false;
        }   // end request function 
    });
});

//borrar elemento del carrito de compras
function dropItem(element){
    let option = element.getAttribute('op');
    let idpr = element.getAttribute('idpr');
    let idnm = element.getAttribute('sp');
    let idtl = element.getAttribute('tl');
    let idgen = element.getAttribute('gc');
    //let talla = document.querySelector('.talla').innerText;
    let talla = document.querySelector('#tl'+idnm+'-'+idtl).value;
    let gender = document.querySelector('#gd'+idnm+'-'+idgen).value;
    if(option ==1 || option == 2){
        //////////
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/productos/delCarrito'; 
	    let formData = new FormData();
	    formData.append('id',idpr);
	    formData.append('talla',talla);
	    formData.append('gender',gender);
	    formData.append('option', option);
	    request.open("POST",ajaxUrl,true);
	    request.send(formData);
	    request.onreadystatechange = function(){
	        if(request.readyState != 4) return;
	        if(request.status == 200){
	        	let objData = JSON.parse(request.responseText);
	        	if(objData.status){
                    if(option == 1){
                        document.querySelector('#itemsCart').innerHTML = objData.html;
                        document.querySelector('#itemsP').setAttribute('data-notify', objData.totalPr);
                    }
                }
                else{
                    Swal.fire({
                        width: '35%',
                        icon:'error',
                        title: '<h3>Oops...</h3>',
                        html: '<h4>'+objData.msg+'</h4>',
                        confirmButtonColor: '#13322B',
                        confirmButtonText: '<h5>Aceptar</h5>'
                    });
                }
            }   
            return false;
        }   // end request function 
    }
}