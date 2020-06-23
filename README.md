# Wordpress Docker + GraphQL

## 起動方法

```
# pluginの取得
git submodule update --init --recursive

docker up
```

 graphql plugin 入りの wordpress が立ち上がる（はず）
 
#立ち上がらない場合

```
docker-compose up -d
```

参考：http://docs.docker.jp/compose/reference/up.html
