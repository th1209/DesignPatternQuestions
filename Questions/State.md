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

##### 問2  
問1のサンプルプログラムに、昼食時の処理を追加せよ(以下)
* 金庫を使用すると、警備センターに非常事態の通報が行く
* 非常ベルを使用すると、警備センターに非常ベルの通報が行く
* 電話を使用すると、警備センターの留守録が呼び出される

##### 問3
問2のサンプルプログラムに、非常時という状態を作れ。
非常時においては、時刻によらず警備センターに連絡がつくようになる。
具体的には、以下の仕様を満たすこと。
* 非常ベルを押すと、非常時という状態に遷移する
* 金庫を使用すると、警備センターに非常事態の通報が行く
* 非常ベルを使用すると、警備センターに非常ベルの通報が行く
* 電話を使用すると、警備センターが呼び出される
