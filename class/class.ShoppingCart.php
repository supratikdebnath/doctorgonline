<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class ShoppingCart{
var $cart;
var $pIds;
var $cartId;
var $uId;
var $pDetails;
var $toPay;

public function __construct($userId){
 $this->cartId = $this->generateCartId();
 $this->uId= $userId;
 $this->pIds=array();
 $this->pDetails = array("id"=>array(),"qty"=>array(),"price"=>array(),"totalprice"=>array());
 $this->updateCartData();
} 

public function addToCart($pId){
if(!in_array($pId,$this->pIds)){
	    $this->pIds[]=$pId;
		
}
$this->updateCart($pId);
}

public function updateCart($id){
if(in_array($id,$this->pDetails['id'])){	
		$pIdKey=array_keys($this->pDetails['id'],$id);
		$pIdKey=$pIdKey[0];
		$this->pDetails['qty'][$pIdKey]=$this->pDetails['qty'][$pIdKey]+1;
		$this->pDetails['totalprice'][$pIdKey]=number_format($this->pDetails['qty'][$pIdKey]*$this->pDetails['totalprice'][$pIdKey], 2, '.', ' ');;
		}
else
	{
		$this->pDetails['id'][]=$id;
		$this->pDetails['qty'][]=1;
		$this->pDetails['price'][]="100.00";
		$this->pDetails['totalprice'][]="100.00";	
	}	
$this->updateCartData();
}

public function updateCartData(){
	$this->cart['id']=$this->cartId;
	$this->cart['id']=$this->cartId;
	$this->cart['uid']=$this->uId;
	$this->cart['details']=$this->pDetails;
	$this->cart['time']=time();
}

public function generateCartId(){
$id = substr(number_format(time() * rand(),0,'',''),0,10);
return $id;	
}

public function totalPriceToPay(){
$toPay="00.00";
foreach($this->pDetails['totalprice'] as $keys=>$vals)
	{
		$toPay = number_format($toPay + $vals,"2",".","");
	}
return $toPay;	
}

public function __destruct(){
echo "Total Price to pay ".$this->totalPriceToPay();
unset($this->uId);
unset($this->pDetails);
unset($this->pIds);
unset($this->cartId);
}

}

echo "<pre>";
$cart=new ShoppingCart('1001');
print_r($cart->cart);

$cart->addToCart('101');
$cart->addToCart('102');
$cart->addToCart('101');
print_r($cart->cart);

echo "<pre>";
?>