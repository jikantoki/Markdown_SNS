---
# 優先度 A（セキュリティやWebサイトの存続に関わる問題）
1. cookieにパスワードの平文が保存されている
  1. セッション管理についてもっと勉強したら改善します
1. cookieのID、メアド、パスワードに正しい値を入力するとログイン認証無しでログインした状態になる…かもしれない

# 優先度 B（操作に支障が出る、すぐ治すべき）
1. 始めてアクセスしたURLで503等のサーバーエラーが出ると、エラーページがキャッシュされて毎回エラーページが出る
  1. 治し方を教えて欲しい

# 優先度 C（緊急で治すほどではない）
## プロフィールページ
1. モバイル表示でタイトルが「ログインしてください」になる
  1. Javascriptで書き換えるコードを追加予定
1. 投稿時にポップアップで出てくるテキストエリアで、変換機能が見にくい
  1. 最適なCSSを模索中
1. Webサイトが重い
  1. コードの最適化、二重に処理している部分の改善、PHPとjsの棲み分けを少しずつ進めています
1. ページによっては、最新の情報が出てこない時がある
  1. PHPで書いたコードはキャッシュに溜まるので新しい情報が入りません。常に最新の情報を出すべきページは、順次JSで書き直しています

# 優先度 D（バグではなく未実装or仕様）
1. 言語の変更ができない
1. DM、サーチページ、通知ページは未実装
1. メールアドレスによる二段階認証は夏までに実装します

# 修正済みの不具合
1. バグを修正した履歴を残したいときにここに残します
