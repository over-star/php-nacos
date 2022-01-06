## Nacos 配置中心的PHP客户端

### 开发计划

- [x] 配置中心
- [ ] [实现服务发现]
- [ ] Yii框架集成
- [ ] Laravel框架集成

### 安装

``` bash
composer require overstar/php-nacos
```


### 使用

#### 设置配置文件保存路径
默认是config目录
``` php
NacosConfig::setSavePath('path');
```
#### 获取配置文件
``` php
Nacos::init( "http://119.91.83.91:8848/", "console.php", "js", "0c1201b3-495a-4c14-9259-e798b64fb6e8" )
    ->run();
```

#### 长轮询拉取配置文件
``` php
Nacos::init( "http://119.91.83.91:8848/", "console.php", "js", "0c1201b3-495a-4c14-9259-e798b64fb6e8" )
    ->listener();
```

#### 发布配置文件
``` php
Nacos::init( "http://119.91.83.91:8848/", "console.php", "js", "0c1201b3-495a-4c14-9259-e798b64fb6e8" )
    ->publish("sdfsdfsdf","text");
```

#### 删除配置文件
``` php
Nacos::init( "http://119.91.83.91:8848/", "console.php", "js", "0c1201b3-495a-4c14-9259-e798b64fb6e8" )
->delete();
```
