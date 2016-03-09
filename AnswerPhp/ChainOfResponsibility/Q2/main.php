<?php
namespace MyDesignPattern\Practice01;
//テストルーチン
$limit     = new LimitSupport('リミットさん',50);
$odd       = new OddSupport('キスーさん');
$special   = new SpecialSupport('スペシャルさん',77);
$noSupport = new Nosupport('ムノーさん');

$special->setNext($odd)->setNext($noSupport)->setNext($limit);

for($i =0; $i < 100; $i++){
	$trouble= new Trouble(rand(1,100));
	$special->resolve($trouble);
}




//クラス定義
class Trouble{
	private $number; 
	
	public function __construct($number){
		$this->number = $number;
	}
	
	public function getNumber(){
		return $this->number;
	}
}
abstract class Support{
	private $name;
	private $next;//Support型
	
	public function __construct($name){
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	//MEMO メソッドチェーンを実現する為に、このメソッドをよく覚えておくこと
	public function setNext(Support $support) {
		$this->next = $support;
		return $support;
	}
	
	abstract public function resolve (Trouble $trouble);
	
	public function done(Trouble $trouble) {
		echo $trouble->getNumber() . ' is resolved by ' . $this->getName() . PHP_EOL;
	}
	
	public function fail(Trouble $trouble) {
		echo $trouble->getNumber() . ' can\'t resolve by chain of responsibility. ' . $this->getName() . PHP_EOL;
	}
	public function throwTroubleToNext($trouble){
		if(isset($this->next)){
			$this->next->resolve($trouble);
		//解決できるConcreteHandlerがいなかった
		}else{
			$this->fail($trouble);
		}
	}
}
class LimitSupport extends Support{
	private $limitNumber;
	
	public function __construct($name, $limitNumber){
		parent::__construct($name);
		$this->limitNumber = $limitNumber;
	}
	
	public function resolve (Trouble $trouble){
		//このConcreteHandlerで解決できる
		if($trouble->getNumber()< $this->limitNumber){
			$this->done($trouble);
		}
		//次のConcreteHandlerにたらい回す
		$this->throwTroubleToNext($trouble);
	}
}
class OddSupport extends Support{
	public function resolve (Trouble $trouble){
		//TODO この箇所、判定箇所だけが特化してるから、上手く切り出したい
		if(($trouble->getNumber() / 2) !== 0){
			$this->done($trouble);
		}
		$this->throwTroubleToNext($trouble);
	}
}
class SpecialSupport extends Support{
	private $specialNumber;
	
	public function __construct($name, $specialNumber){
		parent::__construct($name);
		$this->specialNumber = $specialNumber;
	}
	public function resolve (Trouble $trouble){
		if($trouble->getNumber() === $this->specialNumber){
			$this->done($trouble);
		}
		$this->throwTroubleToNext($trouble);
	}
}
class NoSupport extends Support{
	public function resolve (Trouble $trouble){
		//必ず次のConcreteHandlerにたらい回す
		$this->throwTroubleToNext($trouble);
	}
}