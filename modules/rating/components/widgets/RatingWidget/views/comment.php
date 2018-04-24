<div class="star-rating">
    <div class="star-rating__wrap">
        <?php for ($i = 5; $i>0; $i--):?>
            <input class="star-rating__input" id="star-<?=$comment->id?>-<?=$comment->id?>-<?=$i?>-<?=$comment->id?>" type="radio" value="<?=$i?>"
                <?php if (round($comment->rate) == $i){ echo 'checked="checked"';} else {echo 'disabled';}?>>
            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-<?=$comment->id?>-<?=$comment->id?>-<?=$i?>" title="<?=$i?> out of <?=$i?> stars"></label>
        <?php endfor;?>
    </div>
</div>