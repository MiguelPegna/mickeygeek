    <div class="md:flex md:justify-center md:gap-4 md:items-center my-5">
        <label for="name" class="mb-2 block uppercase text-white font-bold">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> crear cuenta
        </label>
    </div>

    <div class="w-full max-w-xl m-auto rounded p-5 shadow-xl mt-4">   
        <!-- header -->
        <img class="w-40 mx-auto mb-5" src="<?= PUBLICDOCS;?>/img/icons/logo_name.png" />
        <!-- form -->
        <form name="register" id="register" autocomplete="off">
            <div>
                <label for="name" class="mb-2 block uppercase font-bold">
                    Nombre
                </label>
                <input type="text" name="name" id="name" class="text-[<?= txtColInput; ?>] shadow border p-3 mb-6 w-full rounded-lg"/>
            </div>
            <div>
                <label for="email" class="mb-2 block uppercase font-bold">
                    Email
                </label>
                <input type="email" name="email" id="email" placeholder="@" class="text-[<?= txtColInput; ?>] shadow border p-3 mb-6 w-full rounded-lg"/>
            </div>
            <div class="relative">
                <label for="password" class="mb-2 block uppercase font-bold">
                    Contraseña
                </label>
                <input type="password" name="password" id="password" class="text-[<?= txtColInput; ?>] shadow border p-3 mb-6 w-full rounded-lg"/>
                <i class="text-[<?= txtColInput; ?>] fa fa-eye eye_1 absolute top-10 right-3 cursor-pointer text-lg"></i>
            </div>
            <div class="relative">
                <label for="password1" class="mb-2 block uppercase font-bold">
                    Repetir Contraseña
                </label>
                <input type="password" name="password1" id="password1" class=" text-[<?= txtColInput; ?>] shadow border p-3 mb-6 w-full rounded-lg"/>
                <i class="text-[<?= txtColInput; ?>] fa fa-eye eye_2 absolute top-10 right-3 cursor-pointer text-lg"></i>
            </div>
            <div class="separar">
                <button type="submit" class="font-bold w-full p-3 cursor-pointer text-white bg-gradient-to-r from-blue-700 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-700 dark:focus:ring-blue-500 rounded-lg text-xl px-5 py-2.5 text-center mr-2 mb-2 shadow-xl mt-4">
                    Crear Cuenta
                </button>
            </div>       
        </form>
        <!-- footer --> 
        <a class="text-amber-500 hover:text-amber-400 text-sl float-left" href="recover">Recuperar contraseña</a>
        <a class="text-amber-500 hover:text-amber-400 text-sl float-right" href="login">Iniciar sesión</a>
        <div class="separar"> </div>
    </div>