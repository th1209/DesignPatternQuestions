<?php
namespace MyDesignPattern\Practice01;

//以下、メインルーチン
//部署毎にファイルを保存しているイメージ
$rootDir = new Directory('root');

$generalAccountingDir = new Directory('generalAccounting');
$humanResourcesDir = new Directory('humanResources');
$engineeringDir = new Directory('engineering');
$rootDir->add($generalAccountingDir);
$rootDir->add($humanResourcesDir);
$rootDir->add($engineeringDir);

$gaDir1 = new Directory('gaDir1');
$generalAccountingDir->add($gaDir1);
$gaFile1 = new File('gaFile1', 1024);
$gaFile2 = new File('gaFile2', 512);
$gaDir1->add($gaFile1);
$gaDir1->add($gaFile2);
$gaFile3 = new File('gaFile2', 1536);
$generalAccountingDir->add($gaFile3);

$hrDir1 = new Directory('hrDir1');
$humanResourcesDir->add($hrDir1);

$enFile1 = new File('enFile1', 1024);
$engineeringDir->add($enFile1);
$enDir1 = new Directory('enDir1');
$engineeringDir->add($enDir1);
$enFile2 = new File('enFile2', 1536);
$enDir1->add($enFile2);

$rootDir->printList('');


abstract class Entry{
	protected $name;
	protected $parent;

	public function getName(){
		return $this->name;
	}
	

	abstract public function getSize();
	
	public function getParent(){
		return $this->parent;
	}
	
	public function setParent(Entry $entry){
		$this->parent = $entry;
	}
	
	public function add(Entry $entry){
		throw New RuntimeException(__METHOD__ . 'このメソッドの呼び出しは禁止されています。');
	}
	
	abstract public function printList($prefix);
	
	public function getFullPath(){
		$path = '/' . $this->getName();
		var_dump($this->name);
		$entry = $this->getParent();
		while($entry != null){
			$path = '/' . $entry->getName() . $path;
			$entry = $entry->getParent();
		}
		return $path;
	}
}

class File extends Entry{
	protected $size;

	public function __construct($name, $size) {
		$this->name = $name;
		$this->size = $size;
		$this->parent = null;
	}
	
	public function getSize(){
		return $this->size;
	}

	public function printList($prefix){
		$output =  $prefix. '/' . $this->name . ' ' . $this->size . PHP_EOL;
		echo nl2br($output);
	}	
}

class Directory extends Entry{
	protected $directory;
	
	public function __construct($name){
		$this->name = $name;
		$this->directory = array();
		$this->parent = null;
	}

	public function getSize(){
		if(empty($this->directory)) return 0;
		$size = 0;
		foreach($this->directory as $entry){
			$size += $entry->getSize();
		}
		return $size;
	}
	
	public function add(Entry $entry){
		if(! $entry instanceof Entry){
			throw InvalidArgumentException('引数の型が不正です');
		}
		$this->directory[] = $entry;
		$entry->setParent($this);
	}
	
	public function printList($prefix){
		$output = $prefix . '/' . $this->name . ' ' . $this->getSize() . PHP_EOL;
		echo nl2br($output);
		
		if(empty($this->directory)) return;
		
		foreach($this->directory as $entry){
			$entry->printList($prefix . '/' . $this->name);
		}
	}
}
