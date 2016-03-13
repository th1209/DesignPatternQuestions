#### Mementoパターン　  
##### 問1  
以下の要件を満たすクラスを作成せよ。  
MementoパターンのWideインタフェースとNarrowインタフェースを意識して実装すること。  

###### Mementoクラス  
以下のプロパティを持つ。  
  * money:int値。Gamerが所持する金額。  
  * fruits:配列。Gamerが所持するフルーツの集合。  

以下のメソッドを持つ。  
* コンストラクタ  
  * int値を引数に取る。  
  * moneyは引数で初期化。fruitsは空の配列で初期化する。  
* getMoneyメソッド  
  * 引数無し。moneyプロパティを返す。  
  * 任意のクラスから呼び出せる。  
* getFruitsメソッド  
  * 引数無し。fruitを返す。  
  * Gamerクラスからしか呼び出せない。  
* addFruit  
  * 文字列を引数に取る。  
  * fruitsプロパティの末尾に要素を追加。  


###### Gamerクラス  
以下のconst値を持つ。  
* fruitsName:フルーツ名の集合。フルーツの個数と名前は任意で良い。  

以下のプロパティを持つ。  
* money:int値。所持する金額。  
* fruits:配列。所持するフルーツの集合。   

以下のメソッドを持つ。  
* コンストラクタ  
  * int値を引数に取る。  
  * moneyは引数で初期化。fruitsは空の配列で初期化する。  
* getMoneyメソッド  
  * 引数無し。対応するプロパティを返すだけ。  
* betメソッド  
  * 引数無し。  
  * 以下のロジックを実装すること。  
    * 1-6までの乱数を生成。  
    * 1ならmoneyを+100する。  
    * 2ならmoneyを1/2する。  
    * 6なら任意のフルーツをfruitsの末尾に追加。  
* createMementoメソッド  
  * 引数無し。  
  * Mementoインスタンスを生成。moneyとfruitsインスタンスを保存する  
  * Mementoインスタンスを返す。  
* restoreMementoメソッド  
  * Memento型変数を引数に取る。  
  * 変数のMementoのプロパティで、各プロパティの値を上書きする。  

以下の条件で実装せよ。  
 * Mementoクラスを継承する。  

###### メインルーチン  
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
