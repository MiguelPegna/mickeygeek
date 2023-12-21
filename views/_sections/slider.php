<div class="slider-container">
    <?php for($r=0; $r <= count($data); $r++){ ?>
        <input type="radio" id="isr<?= $r;?>" class="rbs" name="img-slide" hidden />
    <?php }?>

    <div class="slide">
        <?php for($s1=0; $s1 <count($data); $s1++){ ?>
            <div class="item-slide w-full">
                <img src="<?= '../public/img/banners/'.$data[$s1]['image'];?>" class="w-full">
            </div>
        <?php }?>
    </div>
</div>
<div class="pagination mt-4">
    <?php for($l=1; $l <= count($data); $l++){ ?>
        <label for ="isr<?= $l;?>" class="pagination-item">
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-blue-700 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
            </span>
        </label>
    <?php } ?>
</div>

<div>
    <h1 class="emoticon font-mark text-3xl text-center text-amber-500 font-bold mt-10 mb-1" title="Elige una imagen">
        ¯\_( ͡❛ ₒ ͡❛)_/¯
    </h1>
</div>