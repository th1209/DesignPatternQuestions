<?php
namespace MyDesignPattern\Practice01;

//テストルーチン
$stringDisplayImpl = new StringDisplayImpl('hoge');
$randomDisplay = new randomDisplay($stringDisplayImpl);
$randomDisplay->randomDisplay(5);
$randomDisplay->randomDisplay(5);

//クラス定義
class Display{
	private $displayImpl;
	
	public function __construct(DisplayImpl $displayImpl){
		$this->displayImpl = $displayImpl;
	}
	
	public function open() {
		$this->displayImpl->rawOpen();
	}
	
	public function printStr(){
		$this->displayImpl->rawPrintStr();
	}
	
	public function close() {
		$this->displayImpl->rawClose();
	}
	
	public function display() {
		$this->open();
		$this->printStr();
		$this->close();
	}
}

class CountDisplay extends Display{
	public function __construct(DisplayImpl $displayImpl){
		parent::__construct($displayImpl);
	}
	
	public function multiDisplay($count){
		$this->open();
		for($i = 0; $i < $count; $i++){
			$this->printStr();
		}
		$this->close();
	}
}

class RandomDisplay extends Display{
	public function __construct(DisplayImpl $displayImpl){
		parent::__construct($displayImpl);
	}
	
	public function randomDisplay($maxCount){
		$this->open();
		$count = rand(1,$maxCount);
		for($i = 0; $i < $count; $i++){
			$this->printStr();
		}
		$this->close();
	}
}

abstract class DisplayImpl{
	abstract public function rawOpen();
	
	abstract public function rawPrintStr();
	
	abstract public function rawClose();
}

class StringDisplayImpl extends DisplayImpl{
	private $string;
	private $strWidth;
	
	public function __construct($string){
		$this->string = $string;
		$this->strWidth = strlen($string);//全角文字の場合、1文字2byteでカウントしたいので、strlenを使う。
	}
	
	public function rawOpen(){
		$this->printHeaderAndFooter();
	}
	
	public function rawPrintStr(){
		echo '|' . $this->string . '|' . PHP_EOL;
	}
	
	public function rawClose(){
		$this->printHeaderAndFooter();
	}
	
	private function printHeaderAndFooter(){
		echo '+';
		for($i = 0; $i < $this->strWidth; $i++){
			echo '-';
		}
		echo '+';
		echo PHP_EOL;
	}
}
