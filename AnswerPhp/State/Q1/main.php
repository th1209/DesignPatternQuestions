<?php
namespace MyDesignPattern\Practice01;

//テストルーチン
$safeFrame = new SafeFrame();
$safeFrame->setClock('12:00:00');
actionFacade($safeFrame);


function actionFacade(SafeFrame $safeFrame){
	$safeFrame->actionPerformed(1);
}


//クラス定義
//MEMO 時間は H:i:s 形式の文字列で扱う
//     例えば、12:00:00といった感じ。
//     正規表現なんかでフォーマットチェックしてあげると親切かと。
//http://isket.jp/%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%9F%E3%83%B3%E3%82%B0/php%E6%97%A5%E4%BB%98%E3%82%84%E6%99%82%E5%88%BB%E3%82%92%E6%AF%94%E8%BC%83%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95/

//MEMO 書いていて思ったことは、Stateクラスはメッセージパッシングがものすごく多いこと。
//     State-State間
//     Context-State間
//     どのタイミングでどのメソッドを呼び合うか考えるのが大事なので、
//     シーケンス図書くと設計がうまくいきそう

//MEMO 書いていて思ったことその2。Stateは以下のような実装をすればうまくいきそう
//     1.Context::なにかを判定するメソッド(ここをクライアントに見せる。ここがトリガーとなる。)
//     2.State::状態に基づきなにかを判定。結果をContextに返す。
//     3.Context::返ってきた結果をもとに、Contextが持つ何かの機能を実行する

interface Context{
	abstract public function setClock($time);
	abstract public function changeState(State $state);
	abstract public function callSecurityCenter($str);
	abstract public function recordLog($str);
}

class SafeFrame implements Context{
	const do_use = 1;
	const do_alarm = 2;
	const do_phone = 3;

	private $state;

	public function __construct(){
		$this->state = DayState::getInstance();
		//この中で一回doClockしてあげたほうが親切かな?
		//$this->state->doClock($this, $time);
	}

	//MEMO Stateではメッセージパッシングが重要。
	//     ここでは、以下のような順番-関係で処理が実行
	//     1.Context::actionPerformed
	//     2.State::doXXX
	//     3.Context::YYY
	public function actionPerformed($action){
		switch($action){
			case(self::do_use):
				$this->state->doUse($this);
				break;
			case(self::do_alarm):
				$this->state->doAlarm($this);
				break;
			case(self::do_phone):
				$this->state->doPhone($this);
				break;
			default:
				throw RuntimeException(__LINE__ . ' ' . __METHOD__);
				break;
		}
	}

	//MEMO ここもメッセージパッシング(以下)。
	//     1.Context::setClock
	//     2.State::doClock
	//     3.Context::changeState
	public function setClock($time){
		echo '現在時刻' . $time;
		$this->state->doClock($this, $time);
	}

	public function changeState(State $state, $time){
		echo 'change from ' . get_class($this->state);
		echo ' to ' . get_class($state) . PHP_EOL;
		$this->state = $state;
	}

	public function callSecurityCenter($str){
		echo 'コールセンター呼び出し:' . PHP_EOL;
		echo $str . PHP_EOL;
	}

	public function recordLog($str){
		echo '電話使用:' . PHP_EOL;
		echo $str . PHP_EOL;
	}
}

const service_start_time = '09:00:00';
const service_end_time = '17:00:00';	//endなので、17時を含まない

interface State{
	abstract public function doClock(Context $context, $time); 
	abstract public function doUse(Context $context);
	abstract public function doAlarm(Context $context);
	abstract public function doPhone(Context $context);
}

class DayState implements State{
	const useMessage   = "金庫使用時間帯(昼間)";
	const alarmMessage = "非常ベル(昼間)";
	const phoneMessage = "通常の電話(昼間)";
	
	private function __construct(){}

	public function getInstance(){
		//シングルトン
		static $instance;
		if(!isset($instance)){
			$instance = new DayState();
		}
		return $instance;
	}
	
	public function doClock(Context $context, $time){
		if(strtotime($time) < strtotime(service_start_time)
		|| strtotime(service_end_time) <= strtotime($time)){
			//MEMO Stateクラス同士はどうしても密結合になってしまう
			$context->changeState(NightState::getInstance());	
		}
	}
	
	public function doUse(Context $context){
		//MEMO このように、機能に関するものは$contextを呼び出して実行。
		//     ある状態にしかない機能なら、Stateに書くのもありかもしれない。
		//     (ただし、その場合は 1.contextが機能を持つというルールが失われるし、
		//      2.同じ機能を実行したいStateが後から増えた場合に不便。)
		$context->recordLog(self::useMessage);
	}
	
	public function doAlarm(Context $context){
		$context->callSecurityCenter(self::alarmMessage);
	}
	
	public function doPhone(Context $context){
		$context->callSecurityCenter(self::phoneMessage);
	}
}

class NightState implements State{
	const useMessage   = "非常:夜間の金庫使用";
	const alarmMessage = "非常ベル(夜間)";
	const phoneMessage = "通話録音(夜間)";
	
	private function __construct(){}
	
	public function getInstance(){
		//シングルトン
		static $instance;
		if(!isset($instance)){
			$instance = new NightState();
		}
		return $instance;
	}
	
	public function doClock(Context $context, $time){
		if(strtotime(service_start_time) <= strtotime($time)
		|| strtotime($time) < strtotime(service_end_time)){
			$context->changeState(DayState::getInstance());
		}
	}
	
	public function doUse(Context $context){
		//MEMO DayStateクラスとは処理が異なっている
		//     状態と機能を疎結合にするパターンなので、こういうことはラクに実現できる
		$context->callSecurityCenter(self::useMessage);
	}
	
	public function doAlarm(Context $context){
		$context->callSecurityCenter(self::alarmMessage);
	}
	
	public function doPhone(Context $context){
		$context->recordLog(self::phoneMessage);
	}
}

