#### Chain Of Responsibilityパターン  
##### 問1  
以下の要件を満たすクラスを作成せよ。  

##### Troubleクラス  
以下のプロパティを持つ。  
* number:int値  

以下のメソッドを持つ。  
* コンストラクタ  
  * プロパティを初期化する  
* getNumberメソッド  
  * 引数無し  
  * numberプロパティを返す  

###### Supportクラス  
以下のプロパティを持つ。  
* name:String型  
* next:Support型。たらい回し先を表す  

以下のメソッドを持つ。  
* コンストラクタ  
  * nameを初期化する  
* setNextメソッド  
  * Support型を引数に取り、nextにセット。  
  * nextを返す。  
* supportメソッド  
  * 以下条件で実装する。  
    * resolveメソッドを呼び出す。  
    * trueならdoneメソッドを呼び出す。  
    * falseかつnextがあるなら、nextのsupportメソッドを呼び出す。  
    * それ以外ならfailメソッドを呼び出す。  
* setNextメソッド  
  * Support型を引数に取り、nextにセット。  
  * nextを返す。  
* resolveメソッド  
  * 抽象メソッド。Trouble型を引数に取り、bool型を返す。  
* doneメソッド  
  * Trouble型を引数に取る。  
  * Trouble型のNumberとこのクラスのnameを使い、このクラスによりトラブルが解決されたことを表示する。  
* failメソッド  
  * Trouble型のNumberを使い、Troubleがたらい回しによって解決されなかったことを表示する。  

##### その他のクラス  
以下のクラスは、次の条件を満たして実装すること。  
* Supportクラスを継承する。  
* コンストラクタ内で親クラスのコンストラクタを呼び出すこと。  
* Trouble型を引数に取り、bool値を返すresolveメソッドを持つ。  

##### LimitSupportクラス  
以下の条件で実装せよ。  
* limitプロパティを持ち、その番号未満のTroubleなら、resolveはtrueを返す。  

##### OddSupportクラス  
以下の条件で実装せよ。  
* 奇数番号のTroubleなら、resolveはtrueを返す。  

##### SpecialSupportクラス  
以下の条件で実装せよ。  
* SpecialNumberプロパティを持ち、その番号に一致するTroubleならresolveはtrueを返す。  

###### NoSupportクラス  
以下の条件で実装せよ。  
* どのような場合でも、resolveはfalseを返す。  

##### メインルーチン  
* Support型とその継承クラス達のインスタンスを生成。setNextメソッドでメソッドチェーンしながらインスタンス生成すること。  
* 100回乱数生成し、その乱数を使ってTrouble型インスタンスを生成。Supportインスタンスのsuppportメソッドに渡し、問題解決させること。  


##### 問2  
問1のSupportクラスのsupportメソッドを、再帰ではなくループで実装せよ。  
