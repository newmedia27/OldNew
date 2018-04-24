<?php

namespace app\modules\cart\controllers;

use app\modules\cart\CartModule;
use app\modules\cart\components\LiqPay;
use app\modules\cart\components\services\OrderService;
use app\modules\cart\models\Order;
use app\modules\cart\models\OrderPaymentTypes;
use app\modules\cart\models\validation\OrderForm;
use app\modules\cart\models\OrderDelivery;
use Yii;


use yii\web\Response;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\base\Exception;
use yii\di\Container;
use yii\web\HttpException;
use yii\widgets\ActiveForm;

class CartController extends Controller
{
    private $container;
    private $form;
    private $request;
    private $orderService;
    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['cart', 'cartcheck', 'checkout', 'thanks', 'add', 'delete', 'setData', 'getProdCount'],
//                'rules' => [
//                    [
//                        'actions' => [],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//
//                ],
//            ]
//        ];
//    }

    public function __construct($id, CartModule $module, OrderService $orderService, $config = [])
    {
        $this->container = new Container;
        $this->form = ActiveForm::begin(['id' => 'delivery_form',
            'enableAjaxValidation' => true,
            'action' => ['/cart/checkout'],
            'validationUrl' => ['/cart'],
        ]);
        $this->request = Yii::$app->request;
        $this->orderService = $orderService;

        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $order = $_SESSION['order'];
        if (Yii::$app->request->isAjax) {

            return $this->renderPartial('summaryWidget', [
                'order' => $order,
            ]);
        }
        return $this->render('index', [
            'order' => $order,
        ]);
    }

    public function actionCheckout()
    {



        if ($this->orderService->getOrderSummary()['totalSum'] == 0 && !Yii::$app->request->isAjax) {
            return $this->redirect('/cart');
        }

        $order = $_SESSION['order'];
        if (!$order) {
            $this->goHome();
        }

        $orderForm = new OrderForm();
        $order_delivery = new OrderDelivery();

        if (Yii::$app->request->isAjax && $order_delivery->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($order_delivery);
        }

        return $this->render('checkout', [
            'order' => $order,
            'orderDelivery' => $order_delivery,
            'orderForm' => $orderForm,
            'payments' => OrderPaymentTypes::find()->all()
        ]);
    }

    public function actionCheckouts()
    {

        if (count($_SESSION['order']["products"]) <= 0) {
            return $this->redirect(['/cart/thanks']);
        }

        if (!$this->request->isAjax) {
            throw new HttpException(400, 'Bad request.');
        }


        $order_delivery = new OrderDelivery();
        if ($order_delivery->load(Yii::$app->request->post()) && $order_delivery->save()) {

            $post['OrderForm']['address'] =
                Yii::$app->request->post()["OrderDelivery"]["country"] . ', ' .
                Yii::$app->request->post()["OrderDelivery"]["city"] . ', ' .
                Yii::$app->request->post()["OrderDelivery"]["street"] . ', ' .
                Yii::$app->request->post()["OrderDelivery"]["house"] . ', ' .
                Yii::$app->request->post()["OrderDelivery"]["number"] . ', ' .
                Yii::$app->request->post()["OrderDelivery"]["index"];
        }

        $post['OrderForm']['phone'] = Yii::$app->request->post()["OrderForm"]["phone"];
        $post['OrderForm']['payment_type'] = Yii::$app->request->post()["OrderForm"]["payment_type"];
        $post['OrderForm']['FIO'] = Yii::$app->request->post()["OrderForm"]["FIO"];

        if ($this->orderService->checkout($post)) {

            return $this->redirect(['/cart/thanks']);
        } else {
            throw new Exception('Can`t save order.');
        }
    }

    public function actionThanks()
    {
        $order = Order::find()->where(['id' => $_SESSION['order_id']])->one();
        return $this->render('success', [
            'order_number' => $_SESSION['order_id'],
            'order' => $order
        ]);
    }

//    public function actionPay()
//    {
//
//        if (isset($_POST['data']) && isset($_POST['signature'])) {
//            $data = $_POST['data'];
//
//            $liqpay = new LiqPay('i70331547031', 'WA1tf2oY8LONy6MAXOKini63cQi0bfqZPbl8oiOo');
//            $decode = $liqpay->decode_params($data);
//
//            $signature = base64_encode(sha1('WA1tf2oY8LONy6MAXOKini63cQi0bfqZPbl8oiOo' . $decode . 'WA1tf2oY8LONy6MAXOKini63cQi0bfqZPbl8oiOo'));
//
//            if ($signature === $_POST['signature']) {
//
//                /**
//                 * работаем с данными
//                 */
//                echo '<pre>';
//                print_r($_POST);
//                echo '</pre>';die;
//
//            } else {
//
//                throw new Exception("Bad signature");
//            }
//
//
//        }
//
//
//    }


    public function actionAddToCart()
    {
        $idProd = $this->request->post('idProd');
        $count = $this->request->post('count');
        if (!$count) {
            $this->orderService->addProduct($idProd);
        } else {
            $this->orderService->addProducts($idProd,$count);
        }

        return $this->renderPartial('summaryWidget', [
            'orderData' => $_SESSION['order'],
        ]);
    }

    public function actionRepeat()
    {
        $id = $this->request->post('id');
        $order = Order::findOne(['id' => $id]);
        foreach ($order->orderProds as $prod) {
            $this->orderService->addProducts($prod->id_prod, $prod->quantity);
        }

        return $this->redirect('/cart');
    }

    public function actionCancel()
    {
        $id = $this->request->post('id');
        $order = Order::findOne(['id' => $id]);
        $order->status = '404';
        if ($order->save()) {
            return $this->redirect('/profile/history');
        };
    }

    public function actionClean()
    {
        unset($_SESSION['order']);
        return $this->renderPartial('summaryWidget', [
            'orderData' => $_SESSION['order'],
        ]);
    }

//    public function actionMinus()
//    {
//        $idProd = $this->request->post('idProd');
//        $quantity = $this->request->post('quantity');
//        $this->orderService->addProducts($idProd, 0,$quantity);
//        if ($this->request->post('type') == 'cart') {
//            return $this->renderPartial('summaryCartWidget', [
//                'orderData' => $_SESSION['order'],
//            ]);
//        }
//        return $this->renderPartial('summaryWidget', [
//            'orderData' => $_SESSION['order'],
//        ]);
//    }

    public function actionTouch()
    {
        $idProd = $this->request->post('idProd');
        $quantity = $this->request->post('quantity');
        $this->orderService->addProduct($idProd, $quantity);

        if ($this->request->post('type') == 'cart') {
            return $this->renderPartial('summaryCartWidget', [
                'orderData' => $_SESSION['order'],
            ]);
        }
        return $this->renderPartial('summaryWidget', [
            'orderData' => $_SESSION['order'],
        ]);
    }

    public function actionDeleteProduct()
    {
        $idProd = $this->request->post('idProd');
        $force = $this->request->post('force');
        $this->orderService->deleteProduct($idProd, $force);

        if ($this->request->post('type') == 'cart') {
            return $this->renderPartial('summaryCartWidget', [
                'orderData' => $_SESSION['order'],
            ]);
        }
        return $this->renderPartial('summaryWidget', [
            'orderData' => $_SESSION['order'],
        ]);
    }

    public function actionGetProductCount()
    {
        if (!$this->request->isAjax) {
            throw new HttpException(500, 'Invalid request!');
        }

        echo $this->orderService->getTotalProductsCount();

        Yii::$app->end();
    }

    public function actionGetProductSumm()
    {
        if (!$this->request->isAjax) {
            throw new HttpException(500, 'Invalid request!');
        }

        echo $this->orderService->getOrderSummary()['totalSum'];

        Yii::$app->end();
    }

    public function actionSetData()
    {
        $this->orderService->setData($this->request->post());
        Yii::$app->end();
    }

    public function actionGetDelivery()
    {
        return $this->renderPartial('deliveryWidget', [
            'order' => $_SESSION['order'],
            'form' => $this->form,
        ]);
    }

}