<?php
namespace MyDesignPattern\Practice01;

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
		$this->next = null;
	}
	
	public function getName() {
		return $this->name;
	}
	
	//MEMO メソッドチェーンを実現する為に、このメソッドをよく覚えておくこと
	public function setNext(Support $support) {
		$this->next = $support;
		return $support;
	}
	
	public function support(Trouble $trouble){
		if($this->resolve($trouble)){
			$this->done($trouble);
		}else if($this->next){
			$this->next->support($trouble);
		}else{
			$this->fail($trouble);
		}
	}
	
	abstract public function resolve (Trouble $trouble);
	
	public function done(Trouble $trouble) {
		echo $trouble->getNumber() . ' is resolved by ' . $this->getName() . PHP_EOL;
	}
	
	public function fail(Trouble $trouble) {
		echo $trouble->getNumber() . ' can\'t resolve by chain of responsibility. ' . $this->getName() . PHP_EOL;
	}
}
class LimitSupport extends Support{
	private $limitNumber;
	
	public function __construct($name, $limitNumber){
		parent::__construct($name);
		$this->limitNumber = $limitNumber;
	}
	
	public function resolve (Trouble $trouble){
		return ($trouble->getNumber()< $this->limitNumber) ? true : false;
	}
}

class OddSupport extends Support{
	public function resolve (Trouble $trouble){
		return (($trouble->getNumber() % 2) !== 0)  ? true : false;
	}
}

class SpecialSupport extends Support{
	private $specialNumber;
	
	public function __construct($name, $specialNumber){
		parent::__construct($name);
		$this->specialNumber = $specialNumber;
	}
	public function resolve (Trouble $trouble){
		return ($trouble->getNumber() === $this->specialNumber)  ? true : false;
	}
}

class NoSupport extends Support{
	public function resolve (Trouble $trouble){
		return false;
	}
}

//テストルーチン
$limit     = new LimitSupport('リミットさん',50);
$odd       = new OddSupport('キスーさん');
$special   = new SpecialSupport('スペシャルさん',77);
$noSupport = new Nosupport('ムノーさん');

$special->setNext($odd)->setNext($noSupport)->setNext($limit);

for($i =0; $i < 100; $i++){
	$trouble= new Trouble(rand(1,100));
	$special->support($trouble);
}