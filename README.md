# Wordpress Docker
複数wordpress検証環境

## 起動方法
``` bash
docker-compose up -d
```

## wordpress環境を増やす
### dockerを一旦停止
``` bash
docker-compose stop
```

### docker-compose.ymlを編集
wordpress2がwordpressをコピーしたものなので、それに倣って追加する   
コピー後、以下の項目を他のwordpressと被らないように変更   
・service名（任意）   
・port（****:80）   
・WORDPRESS_DB_NAME（任意） 
・volumes（htmlフォルダをコピー、またはwordpressのソースを用意）  

### dockerを起動
``` bash
docker-compose up -d
```

### DBを作成する
localhost:3000にアクセス（user: root, passsord: password）  
docker-compose.ymlで変更したWORDPRESS_DB_NAMEでデータベースを新規作成  
exampleuserに追加したデータベースへの権限を与える[[参考]](https://technote925.com/435)  
（sql: GRANT ALL PRIVILEGES ON 'DB名'.* TO 'exampleuser'@'localhost';）

### wordpressにアクセス
localhost:{docker-compose.ymlで変更したport}