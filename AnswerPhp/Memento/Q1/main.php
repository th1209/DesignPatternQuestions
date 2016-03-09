<?php
namespace MyDesignPattern\Practice01;

//テスト用ルーチン
$gamer = new Gamer(100);
$memento = $gamer->createMemento();

for($i=1; $i <= 100 ; $i++){
	echo $i . '回目' .PHP_EOL;
	
	$money = $gamer->getMoney();
	$gamer->bet();
	
	if($gamer->getMoney() > $money){
		$memento = $gamer->createMemento();
		
		echo 'Mementoを作成しました' . PHP_EOL;
		printGamerState($gamer);
	}
	
	if($gamer->getMoney() <= ($memento->getMoney() / 2)){
		echo 'MementoでGamerを復元しました' . PHP_EOL;
		printGamerState($gamer);
	}
}	
	
function printGamerState(Gamer $gamer){
	echo '所持金:' . $gamer->getMoney() . '円' . PHP_EOL;
	echo 'フルーツ:' ; 
	foreach($gamer->getFruits() as $fruit){ 
		echo $fruit . ' ';
	} 
	echo PHP_EOL;
	echo PHP_EOL;
}


//クラス定義
class Memento{
	private $money;
	private $fruits;
	
	public function __construct($money){
		$this->money = $money;
		$this->fruits = array();
	}
	
	public function getMoney(){
		return $this->money;
	}
	
	public function getFruits(){
		return $this->fruits;
	}
	
	public function setFruits(array $fruits){
		$this->fruits = $fruits;
	}
}

class Gamer extends Memento{
	const fruitName = array('Apple','Banana','Orange','Peach');
	private $money;
	private $fruits;
	private $memento;//委譲で持つようにしてみた(Mementoを継承してしまうと、他のクラスを継承できなくなるため)
	
	public function __construct($money){
		$this->money = $money;
		$this->fruits = array();
	}
	
	public function getMoney(){
		return $this->money;
	}

	public function getFruits(){
		return $this->fruits;
	}

	public function bet(){
		$random = rand(1,6);
		switch ($random) {
			case 1:
				$this->money += 100;
				break;
			case 2:
				$this->money = (int)($this->money /2);
				break;
			case 6:
				$this->fruits[] = self::fruitName[rand(0,3)];
				break;
			default:
				break;
		}
	}
	
	public function createMemento(){
		$memento = new Memento($this->money);
		$memento->setFruits($this->fruits);
		$this->memento = $memento;
		return $this->memento;
	}
	
	public function restoreMemento(){
		$this->money = $this->memento->getMoney();
		$this->fruits = $this->memento->getFruits();
	}
}
