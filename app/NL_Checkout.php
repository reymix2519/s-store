<?php

namespace App;

class NL_Checkout
{
  // Địa chỉ thanh toán hoá đơn của NgânLượng.vn
  public $nganluong_url = 'https://www.nganluong.vn/checkout.php';
  // Mã website của bạn đăng ký trong chức năng tích hợp thanh toán của NgânLượng.vn.
  public $merchant_site_code = '61498'; //100001 chỉ là ví dụ, bạn hãy thay bằng mã của bạn
  // Mật khẩu giao tiếp giữa website của bạn và NgânLượng.vn.
  public $secure_pass= '1923362bbe67560ad438ed7876981ce5'; //d685739bf1 chỉ là ví dụ, bạn hãy thay bằng mật khẩu của bạn
  // Nếu bạn thay đổi mật khẩu giao tiếp trong quản trị website của chức năng tích hợp thanh toán trên NgânLượng.vn, vui lòng update lại mật khẩu này trên website của bạn
  public $affiliate_code = ''; //Mã đối tác tham gia chương trình liên kết của NgânLượng.vn

  public function buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency = 'vnd', $quantity = 1, $tax = 0, $discount = 0, $fee_cal = 0, $fee_shipping = 0, $order_description = '', $buyer_info = '', $affiliate_code = '')
  {
    if ($affiliate_code == "") $affiliate_code = $this->affiliate_code;
    $arr_param = array(
      'merchant_site_code'=>  strval($this->merchant_site_code),
      'return_url'    =>  strval(strtolower($return_url)),
      'receiver'      =>  strval($receiver),
      'transaction_info'  =>  strval($transaction_info),
      'order_code'    =>  strval($order_code),
      'price'       =>  strval($price),
      'currency'      =>  strval($currency),
      'quantity'      =>  strval($quantity),
      'tax'       =>  strval($tax),
      'discount'      =>  strval($discount),
      'fee_cal'     =>  strval($fee_cal),
      'fee_shipping'    =>  strval($fee_shipping),
      'order_description' =>  strval($order_description),
      'buyer_info'    =>  strval($buyer_info), //"Họ tên người mua *|* Địa chỉ Email *|* Điện thoại *|* Địa chỉ nhận hàng"
      'affiliate_code'  =>  strval($affiliate_code)
    );

    $secure_code ='';
    $secure_code = implode(' ', $arr_param) . ' ' . $this->secure_pass;
    //var_dump($secure_code). "<br/>";
    $arr_param['secure_code'] = md5($secure_code);
    //echo $arr_param['secure_code'];
    /* */
    $redirect_url = $this->nganluong_url;
    if (strpos($redirect_url, '?') === false) {
      $redirect_url .= '?';
    } else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false) {
      $redirect_url .= '&';
    }

    /* */
    $url = '';
    foreach ($arr_param as $key=>$value) {
      $value = urlencode($value);
      if ($url == '') {
        $url .= $key . '=' . $value;
      } else {
        $url .= '&' . $key . '=' . $value;
      }
    }
    //echo $url;
    // die;
    return $redirect_url.$url;
  }

  public function buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price)
  {

    // Bước 1. Mảng các tham số chuyển tới nganluong.vn
    $arr_param = array(
      'merchant_site_code'=>  strval($this->merchant_site_code),
      'return_url'    =>  strtolower(urlencode($return_url)),
      'receiver'      =>  strval($receiver),
      'transaction_info'  =>  strval($transaction_info),
      'order_code'    =>  strval($order_code),
      'price'       =>  strval($price)
    );
    $secure_code ='';
    $secure_code = implode(' ', $arr_param) . ' ' . $this->secure_pass;
    $arr_param['secure_code'] = md5($secure_code);

    /* Bước 2. Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào*/
    $redirect_url = $this->nganluong_url;
    if (strpos($redirect_url, '?') === false)
    {
      $redirect_url .= '?';
    }
    else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false)
    {
      // Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
      $redirect_url .= '&';
    }

    /* Bước 3. tạo url*/
    $url = '';
    foreach ($arr_param as $key=>$value)
    {
      if ($key != 'return_url') $value = urlencode($value);

      if ($url == '')
        $url .= $key . '=' . $value;
      else
        $url .= '&' . $key . '=' . $value;
    }
    return $redirect_url.$url;
  }

  public function verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code)
  {
    // Tạo mã xác thực từ chủ web
    $str = '';
    $str .= ' ' . strval($transaction_info);
    $str .= ' ' . strval($order_code);
    $str .= ' ' . strval($price);
    $str .= ' ' . strval($payment_id);
    $str .= ' ' . strval($payment_type);
    $str .= ' ' . strval($error_text);
    $str .= ' ' . strval($this->merchant_site_code);
    $str .= ' ' . strval($this->secure_pass);

    // Mã hóa các tham số
    $verify_secure_code = '';
    $verify_secure_code = md5($str);

    // Xác thực mã của chủ web với mã trả về từ nganluong.vn
    if ($verify_secure_code === $secure_code) return true;
    else return false;
  }
  function GetTransactionDetails($order_code){

    ###################### BEGIN #####################
    $checksum = $order_code."|".$this->secure_pass;
    //echo $checksum;
    $params = array(
      'merchant_id' =>  $this->merchant_site_code ,
      'checksum'  =>  MD5($checksum),
      'order_code'  =>  $order_code
    );

    $api_url = "https://sandbox.nganluong.vn:8088/nl35/service/order/checkV2";
    $post_field = '';
    foreach ($params as $key => $value){
      if ($post_field != '') $post_field .= '&';
      $post_field .= $key."=".$value;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$api_url);
    curl_setopt($ch, CURLOPT_ENCODING , 'UTF-8');
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);
    $result = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    if ($result != '' && $status==200){
      return $result;
    }
    return false;
  }
}
?>
