<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\cart\components\widgets\OrderSummary\OrderSummary;

\app\assets\CartAsset::register($this);

$this->title = 'Оформление заказа';
$this->registerMetaTag(['content' => 'Оформление заказа', 'name' => 'description']);
$this->registerMetaTag(['content' => 'Оформление заказа', 'name' => 'keywords']);

$this->params['breadcrumbs'][] = 'Оформление заказа';
?>
<!--CHECHOUT-->
<div class="basket-page">
    <?php $form = ActiveForm::begin([
        'id' => 'form-address',
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'options' => [
                'tag' => false,
            ],
        ],
        'options'=>[
                'class'=>"order-form"
        ]]);?>

    <?= $form->field($orderDelivery, 'id_user')->hiddenInput(['value'=> Yii::$app->user->identity->id])->label(false) ?>

    <div class="container-big">
            <h2>Оформление заказа</h2>

            <div class="shipping-wrap">
                <div class="shipping">
                    <p>Доставка</p>
                    <fieldset>
                        <ul>
                            <li class="input-wrap">
                                <label for="in1">ФИО<span>*</span></label>
                                <?= $form->field($orderForm, 'FIO')->textInput(['value'=>(\Yii::$app->user->isGuest?'':\Yii::$app->user->getIdentity()->surname." ".\Yii::$app->user->getIdentity()->username." ".\Yii::$app->user->getIdentity()->secondname)])->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="in2">Номер телефона<span>*</span></label>
                                <?= $form->field($orderForm, 'phone')->textInput(['class'=>"phone-masked-input",'value'=>(\Yii::$app->user->isGuest?'':\Yii::$app->user->getIdentity()->phone)])->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="country_select">Страна<span>*</span></label>
                                <?= $form->field($orderDelivery, 'country')->textInput()->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="in3">Город<span>*</span></label>
                                <?= $form->field($orderDelivery, 'city')->textInput()->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="in4">Адрес доставки<span>*</span></label>
                                <?= $form->field($orderDelivery, 'street')->textInput()->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="in5">Номер здания<span>*</span></label>
                                <div class="order-house-number-wrap">
                                    <div class="order-house-number flex">
                                        <?= $form->field($orderDelivery, 'house')->textInput()->label(false) ?>
                                        <div class="order-office-number">
                                            <label for="in6">Офис</label>
                                            <?= $form->field($orderDelivery, 'number')->textInput()->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="input-wrap">
                                <label for="in7">Индекс</label>
                                <div class="order-house-number">
                                    <?= $form->field($orderDelivery, 'index')->textInput()->label(false) ?>
                                </div>
                            </li>
                        </ul>
                    </fieldset>
                </div>

                <div class="payment">
                    <div class="payment-select">
                        <p>Оплата</p>
                        <div class="check-filter">
                            <?php foreach ($payments as $type){
                                $pay[$type->id] = $type->name;
                                $ids[] = $type->id;
                            } ?>
                            <?= $form->field($orderForm, 'payment_type')->radioList($pay,
                                ['item' => function($index, $label, $name, $checked, $value) {
                                    $return = '<label>';
                                    $return .= '<input type="radio" ' . ( $value == 2 ? 'onchange="shipping(\'show\');"' : 'onchange="shipping(\'hide\');"' ) . ' name="' . $name. '" value="' . $value . '">';
                                    $return .= '<span>' . ucwords($label) . '</span>';
                                    $return .= '</label>';
                                    return $return;
                                },'data-id'=> 'radio']
                            )->label(false) ?>
                        
                        </div>


                        <div class="shipping shipping_people hidden">
                            <fieldset>
                            <ul>
                               <li class="input-wrap">
                                <label for="in1">Название компании<span>*</span></label>
                                <?= $form->field($orderForm, 'company')->textInput()->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="in1">ЕДРПОУ<span>*</span></label>
                                <?= $form->field($orderForm, 'edrpou')->textInput()->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="in1">Банк<span>*</span></label>
                                <?= $form->field($orderForm, 'bank')->textInput()->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="in1">МФО<span>*</span></label>
                                <?= $form->field($orderForm, 'mfo')->textInput()->label(false) ?>
                            </li>
                            <li class="input-wrap">
                                <label for="in1">Расчетный счет<span>*</span></label>
                                <?= $form->field($orderForm, 'rr')->textInput()->label(false) ?>
                            </li>
                        </ul>
                        </fieldset>
                    </div>
                    </div>
                    <p class="payment-desc"></p>
                </div>

            </div>

            <h2>Корзина</h2>
            <div class="bp-items">
                <?= OrderSummary::widget(['orderData' => $order,'view'=>'checkout']) ?>

               

                <div class="bp-table">
                    <div class="cart-buttons-wrap">
                        <div class="cart-buttons flex">
                            <a class="continue-to-bye" href="<?= \Yii::$app->urlManager->createUrl('/catalog'); ?>"><?=Yii::t('trans', 'dont_stop_buy')?></a>
                            <a class="main-button" id="submit-order-button" href="javascript:void(0)"><?=Yii::t('trans', 'go_to_cart')?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<!--END CHECHOUT-->

<script>
    function shipping(val) {
        if (val == 'show') {
            $('.shipping_people').removeClass('hidden');
        } else {
         $('.shipping_people').addClass('hidden'); 
     }
 }
</script>

<style type="text/css">
.shipping_people {
    width: auto;
    padding-right: 0;
    padding-left: 0;
    margin-right: 0;
    display: block;
    padding-top: 30px;
}
.shipping_people fieldset label , .shipping_people fieldset input {
    display: block;
    width: 100%;
    margin: 0;
    text-align: left;
}
.shipping_people fieldset input {
    margin: 10px 0 25px;
}
.shipping_people.hidden {
    display: none;
}
</style>