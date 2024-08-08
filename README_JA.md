# Laravel Mailer for Gmail API  
  
Gmail API を Laravel の Mailer として使用することができます。  
既存のコードに手を加えること無く、Laravel からのメールの送信を Gmail API 経由にすることができます。  
  
OAuth ではなく、サービスアカウントを使用した送信を行います。  
これにより、ユーザによる認証プロセスや、アクセストークンの管理をすることなく、Gmail API を利用できます。  
もちろん、LSA (安全性の低いアプリ) には該当しない方法です。  
  
# インストール  
  
```  
composer require ad5jp/laravel-gmail  
```  
  
環境に応じてバージョンを指定してください。  
  
v4.x ... Laravel 9 以降  
v3.x ... Laravel 7 - 8  
v2.x ... Laravel 6 以前  
v1.x ... Laravel 6 以前 かつ google/apiclient-service が v0.200.0 より前  
  
# 使用方法  
  
### 1. Google Cloud Platform にて、サービスアカウントを作成  
  
(1) Google Cloud Platform のコンソールで、プロジェクトを作成します。  
(2) Gmail API を有効化します。  
(3) サービスアカウントを作成し、キーを作成して、JSON形式でダウンロードします。  
(4) Google Workspace の管理コンソールで「ドメイン全体の権限の委任」を設定します。上記のサービスアカウントに対して、スコープ `https://www.googleapis.com/auth/gmail.send` を付与します。  
  
### 2. キーの配置  
  
上記 (2) でダウンロードした JSON キーを、アプリケーション内に配置します。  
ソース管理に反映されないよう、.gitignore 等で除外してください。  
  
### 3. .env の設定  
  
.env の `MAIL_MAILER` の値を `gmail` に変更します。  
（または config/mail.php の 'default' の値を変更します）  
  
※ Laravel 6 以前の場合は、.env の `MAIL_DRIVER` の値を `gmail` に変更します。  
（または config/mail.php の 'driver' の値を変更します）  
  
.env に、下記の2行を追加します。  
  
```  
GMAIL_FROM_ADDRESS={差出人アドレス}  
GMAIL_SERVICE_ACCOUNT_KEY={2で配置したJSONキーのパス}  
```  
  
差出人アドレスは、1 の (4) で設定した GoogleWorkspace の組織内に存在するメールアドレスである必要があります。  
