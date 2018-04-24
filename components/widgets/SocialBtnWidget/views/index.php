<div id="fb-root"></div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<script>!function(d,s,id){
    var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){
        js=d.createElement(s);
        js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
        fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
</script>
<script src="//platform.linkedin.com/in.js" type="text/javascript">
    lang: ru_RU
</script>


<div class="repost-icons">
    <a class="rep-tw" href="https://twitter.com/share" data-url="<?= Yii::$app->request->absoluteUrl ?>" data-dnt="true" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
    <a class="rep-fb" href="https://www.facebook.com/sharer/sharer.php?u=<?= Yii::$app->request->absoluteUrl ?>" data-layout="button" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
    <a class="rep-g" href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
</div>