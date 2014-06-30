# Vagrant

## Windowsローカル環境で動かす  
Vagrantをインストールする  
`git clone`したディレクトリに移動  
`vagrant up`  
`vagrant ssh`  
※`vagrant ssh` のコマンドが実行できない場合は、PuttyなどのSSHクライアントで接続してください。    
**ホストIP： 192.168.33.10**  
**ユーザ名： vagrant**  
**パスワード： vagrant** 

### move dir
```bash
$ cd /vagrant
```

### install
```bash
$ composer update
# or
$ composer install
```

###p ermission
app/storage　の実行権限を忘れずに
```bash
$ chmod -R 777 app/storage

### 初期設定
データベースを作成します
```bash
$ php artisan migrate
```
ビルトインサーバでアプリケーションを動作させます
```bash
$ php artisan serve --host 0.0.0.0
```
**http://192.168.33.11:8000** でアクセス可能です。  
portを変更したい場合は任意のポートを指定してください。
...
