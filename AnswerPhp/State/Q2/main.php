<?php
namespace MyDesignPattern\Practice01;

interface Context{
	public function setClock($time);
	public function changeState(State $state);
	public function callSecurityCenter($str);
	public function recordLog($str);
}

class SafeFrame implements Context{
	const do_use = 1;
	const do_alarm = 2;
	const do_phone = 3;

	private $state;

	public function __construct(){
		$this->state = DayState::getInstance();
	}

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

	public function setClock($time){
		echo '現在時刻' . $time . PHP_EOL;
		$this->state->doClock($this, $time);
	}

	public function changeState(State $state){
		echo 'change from ' . get_class($this->state);
		echo ' to ' . get_class($state) . PHP_EOL;
		$this->state = $state;
	}

	public function callSecurityCenter($str){
		echo 'コールセンター呼び出し:' . PHP_EOL;
		echo $str . PHP_EOL;
	}

	public function recordLog($str){
		echo '留守録:' . PHP_EOL;
		echo $str . PHP_EOL;
	}
}

const service_start_time = '09:00:00';
const lunch_start_time   = '12:00:00';
const lunch_end_time     = '13:00:00';
const service_end_time   = '17:00:00';

interface State{
	public function doClock(Context $context, $time);
	public function doUse(Context $context);
	public function doAlarm(Context $context);
	public function doPhone(Context $context);
}

class DayState implements State{
	const useMessage   = "金庫使用時間帯(昼間)";
	const alarmMessage = "非常ベル(昼間)";
	const phoneMessage = "通常の電話(昼間)";

	private function __construct(){}

	public static function getInstance(){
		//シングルトン
		static $instance;
		if(!isset($instance)){
			$instance = new DayState();
		}
		return $instance;
	}

	public function doClock(Context $context, $time){
		if(strtotime($time) < strtotime(service_start_time)){
			$context->changeState(NightState::getInstance());
		}

		if(strtotime($time) >= strtotime(lunch_start_time) &&
		   strtotime($time) <  strtotime(lunch_end_time)){
			$context->changeState(LunchState::getInstance());
		}

		if(strtotime($time) >= strtotime(service_end_time)){
			$context->changeState(NightState::getInstance());
		}
	}

	public function doUse(Context $context){
		$context->recordLog(self::useMessage);
	}

	public function doAlarm(Context $context){
		$context->callSecurityCenter(self::alarmMessage);
	}

	public function doPhone(Context $context){
		$context->callSecurityCenter(self::phoneMessage);
	}
}

class LunchState implements State{
	const useMessage   = "非常:昼食時の金庫使用";
	const alarmMessage = "非常ベル(昼食時)";
	const phoneMessage = "通話録音(昼食時)";

	private function __construct(){}

	public static function getInstance(){
		//シングルトン
		static $instance;
		if(!isset($instance)){
			$instance = new LunchState();
		}
		return $instance;
	}

	public function doClock(Context $context, $time){
		if(strtotime($time) < strtotime(lunch_start_time)){
			$context->changeState(DayState::getInstance());
		}
		if(strtotime($time) >= strtotime(lunch_end_time) &&
		   strtotime($time) <  strtotime(service_end_time)){
			$context->changeState(DayState::getInstance());
		}
		if(strtotime($time) >= strtotime(service_end_time)){
			$context->changeState(NightState::getInstance());
		}
	}

	public function doUse(Context $context){
		$context->callSecurityCenter(self::useMessage);
	}

	public function doAlarm(Context $context){
		$context->callSecurityCenter(self::alarmMessage);
	}

	public function doPhone(Context $context){
		$context->recordLog(self::phoneMessage);
	}
}

class NightState implements State{
	const useMessage   = "非常:夜間の金庫使用";
	const alarmMessage = "非常ベル(夜間)";
	const phoneMessage = "通話録音(夜間)";

	private function __construct(){}

	public static function getInstance(){
		//シングルトン
		static $instance;
		if(!isset($instance)){
			$instance = new NightState();
		}
		return $instance;
	}

	public function doClock(Context $context, $time){
		if(strtotime($time) >= strtotime(service_start_time) &&
		   strtotime($time) <  strtotime(lunch_start_time)){
			$context->changeState(DayState::getInstance());
		}

		if(strtotime($time) >= strtotime(lunch_start_time) &&
		   strtotime($time) <  strtotime(lunch_end_time)){
			$context->changeState(LunchState::getInstance());
		}

		if(strtotime($time) >= strtotime(lunch_end_time) &&
		   strtotime($time) <  strtotime(service_end_time)){
			$context->changeState(DayState::getInstance());
		}
	}

	public function doUse(Context $context){
		$context->callSecurityCenter(self::useMessage);
	}

	public function doAlarm(Context $context){
		$context->callSecurityCenter(self::alarmMessage);
	}

	public function doPhone(Context $context){
		$context->recordLog(self::phoneMessage);
	}
}

//テストルーチン
$safeFrame = new SafeFrame();
$safeFrame->setClock('09:00:00');
actionFacade($safeFrame);
$safeFrame->setClock('12:00:00');
actionFacade($safeFrame);
$safeFrame->setClock('13:00:00');
actionFacade($safeFrame);
$safeFrame->setClock('17:00:00');
actionFacade($safeFrame);

function actionFacade(SafeFrame $safeFrame){
	$safeFrame->actionPerformed(SafeFrame::do_use);
	$safeFrame->actionPerformed(SafeFrame::do_alarm);
	$safeFrame->actionPerformed(SafeFrame::do_phone);
}



