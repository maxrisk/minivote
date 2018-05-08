## 基于 Laravel + JWT 的投票小程序接口


![license](https://img.shields.io/github/license/mashape/apistatus.svg) 
![PHP Version](https://img.shields.io/travis/php-v/symfony/symfony.svg)
![deploy](https://img.shields.io/badge/deploy-success-brightgreen.svg)

### 接口文档

[文档链接](https://github.com/maxrisk/minivote/wiki/%E6%8E%A5%E5%8F%A3%E8%AF%B4%E6%98%8E)

### 安装及快速开始

```bash
$ composer install
$ php artisan migrate
```

### 特性

- 实现无痛刷新 Token
- Restful 风格接口 

### Token 刷新机制说明

过期的 Token 可请求一次接口，正常返回数据，并在响应头信息返回新的 Token，同时旧的 Token 失效。可通过配置文件修改 Token 过期时间。


