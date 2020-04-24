# Wordpress Docker + GraphQL

## 起動方法
1. wordpressを起動
``` bash
$ git clone https://github.com/GLION-lab/wordpress.git
$ cd wordpress
$ git checkout feature/test-gatsby
$ docker-compose up -d
```

2. 設定編集
- 「設定 > パーマリンクの設定」より、パーマリンク設定の共通設定を「基本」以外に変更
- 「外観 > テーマ」より、Nonce for REST APIを有効にする

3. 下書きプレビュー
「投稿 > 投稿一覧」より、下書き記事のプレビューボタンを押すと、起動したgatsbyのプレビュー画面へと遷移する