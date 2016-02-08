#### Stateパターン　  
##### 問1  
以下の要件を満たすクラスを作成せよ。  


###### Stateインタフェース(状態に関するものはこちら)
以下の抽象メソッドを持つ。  
* doClock
  * Contextインタフェースを引数に取る。
  * 時間を引数に取る。
* doUse  
  * Contextインタフェースを引数に取る。
* doAlarm  
  * Contextインタフェースを引数に取る。
* doPhone
  * Contextインタフェースを引数に取る。


###### DayStateクラス  
以下のメソッドを持つ。  
* doClock
  * 引数で与えられた時刻が9時未満または、17時以降なら、contextインタフェースのchangeStateメソッドを呼び出す。
  * changeStateメソッドには、NightStateクラスのインスタンスを引数に渡す。
* doUse  
  * ContextインタフェースのrecordLogメソッドを呼び出す。
  * 引数は文字列"金庫使用期間(昼間)"を渡す
* doAlarm  
  * ContextインタフェースのcallSecurityCenterメソッドを呼び出す。
  * 引数は文字列"非常ベル(昼間)"を渡す
* doPhone
  * ContextインタフェースのcallSecurityCenterメソッドを呼び出す。
  * 引数は文字列"通常の電話(昼間)"を渡す

以下の条件で実装すること
 * シングルトンクラスとして実装すること


###### NightStateクラス  
 以下のメソッドを持つ。  
 * doClock
   * 引数で与えられた時刻が9時以降かつ17時未満なら、contextインタフェースのchangeStateメソッドを呼び出す。
   * changeStateメソッドには、DayStateクラスのインスタンスを引数に渡す。
 * doUse  
   * ContextインタフェースのcallSecurityCenterメソッドを呼び出す。
   * 引数は文字列"非常:夜間の金庫使用"を渡す
 * doAlarm  
   * ContextインタフェースのcallSecurityCenterメソッドを呼び出す。
   * 引数は文字列"非常ベル(夜間)"を渡す
 * doPhone
   * ContextインタフェースのrecordLogメソッドを呼び出す。
   * 引数は文字列"夜間の通話録音"を渡す

 以下の条件で実装すること
  * シングルトンクラスとして実装すること


###### Contextインタフェース(何かの機能はこちら)
以下の抽象メソッドを持つ。  
* setClock
  * 時間を引数に取る。
* changeState
  * Stateインタフェースを引数に取る。
* callSecurityCenter
  * 文字列を引数に取る
* recordLog
  * 文字列を引数に取る


###### SafeFrameクラス
以下のメソッドを持つ
* コンストラクタ
  * stateを、DayStateインスタンスで初期化
* actionPerformed
  * 関数名を引数に取る
  * 関数名に応じて、次のメソッドを実行する
    * state.doUse
    * state.doAlarm
    * state.doPhone
* setClock
  * 時刻を引数に取る
  * 時刻を表示
  * stateプロパティのdoClockメソッドを呼び出す
* changeStateメソッド
  * State型を引数に取る
  * 状態が切り替わったことを表示しつつ、
  * stateプロパティを、引数で切り替える。
* callSecurityCenter
  * 文字列を引数に取る
  * セキュリティセンター呼び出しを表示
* recordLog
  * 文字列を引数に取る
  * ログ記録を表示

以下のプロパティを持つ
  * Stateプロパティ

###### メインルーチン
  * 次のようなロジックを実装せよ
    * SafeFrameインスタンスを作る
    * SafeFrameインスタンスのsetClockメソッドを実行。昼間と夜間に切り替えてみる
    * 昼間と夜間に切り替えた時に、SafeFrameインスタンスのactionPerformedメソッドを実行。Stateクラスの色んな処理を実行してみる。

######  
* 今回はこの処理がCareTakerに該当する。  
* 所持金100円の状態で、Gamerインスタンスを生成する。また、この時のMementoを作成する。  
* 以下を100回繰り返す。  
 * 現在の回数と、Gamerの状態を表示。  
 * Gamerのbet()を実行  
 * もしGamerのMoneyが直近のMementoより増えた場合、Mementoを更新し、その旨を表示する。  
 * もしGamerのMoneyがMementoの半分になった場合、MementoでGamerを復元し、その旨を表示する。  


##### 問2  
問1で作成した処理に、ファイルによるシリアライズ・デシリアライズ処理を実装せよ。具体的には以下のようにする。  
* game.datファイルが存在しなければ、所持金100の状態でGamerを生成。game.datファイルが存在すれば、その状態でGamerを生成する。  
* Gamerのbet()を100回実行した後、game.datファイルにMementoの情報を書き込む。  
