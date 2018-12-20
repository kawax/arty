# Artisan only application

- 主にDiscord botを想定したartisanコマンドのみのアプリを作るためのテンプレート
- artisanコマンドでできることは大体何でも可能なので他の用途にも使えるけどそれならLaravelかLaravel Zeroを直接使えばいい。
- Laravel Zero https://laravel-zero.com/
- GitLab CIを使ってサーバーレスでの稼働が目標

## Create project

```
composer create-project --prefer-dist kawax/arty discord-bot && cd $_
```

`php arty`でコマンドリスト表示。

## Laravel Zeroから追加した機能

- Laravel Notification
  - https://github.com/laravel-notification-channels/discord

## Discord test
`.env`を設定後`php arty discord:test`で指定のチャンネルに投稿されれば成功。

このようにコマンド1回実行するだけであればGitLab CIで定期的に実行が可能。（最短間隔はおそらく1時間）  
Laravelのスケジュール機能は使わない。  
次回のコマンド実行時になんらかのデータを引き継ぎたい場合はキャッシュかStorageを使う。

## Discord serve
`php arty discord:serve`ではbotを起動し続ける。  
メッセージを受け取って返すようなbotを作るにはサーバー上で動かし続ける必要がある。

GitLab CIでは無理そうだけどtimeoutが1時間なので1時間毎に再実行し続ければ可能かもしれない。  
この場合はDB使ったりもっと複雑なbotを作るだろうからGitLab CIには向いてない。

## コマンドや通知の作成
Laravelと同じ。

```
php arty make:command TestCommand
php arty make:notification TestNotification
```

## Discordコマンド作成
makeコマンドは用意してないので`app/Discord`以下を見てファイルをコピーして対応。

## artyファイル名の変更
```
php arty app:rename artisan
```

```
php artisan
```
