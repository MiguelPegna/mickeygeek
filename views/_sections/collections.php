   
    <div>
        <h1 class="font-mark text-3xl text-center text-amber-500 font-bold mt-5 mb-1">
            GEEK - COLLECTIONS
        </h1>
    </div>

    
    
    <div class="carouselTrack mx-auto items-center justify-center">
        <div class="glide px-16 py-2">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                    <?php for($c=0; $c <count($data); $c++){ ?>
                    <li class="glide__slide hover:scale-95 transition duration-500">
                        <a href="../collections/<?= $data[$c]['url'];?>">
                            <div class="flex z-20 relative flex-col items-center" >
                                <img src="../public/img/icons/collections/<?php echo $data[$c]['picture'];?>" alt="<?= $data[$c]['collection'];?>" class="object-cover object-center w-48 sm:w-64" />
                                <div class="flex h-full absolute items-end pb-1">
                                    <h3 class="text-xl lg:text-2xl font-semibold leading-5 lg:leading-6 text-amber-500">
                                        <?= $data[$c]['collection'];?>
                                    </h3>
                                </div>    
                            </div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left left-4 group focus:outline-none" data-glide-dir="<">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-blue-700 group-hover:bg-blue-900 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-blue-200 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>

                <button class="glide__arrow glide__arrow--right right-4 group focus:outline-none" data-glide-dir=">">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-blue-700 group-hover:bg-blue-900 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-blue-200 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </div>
    </div>