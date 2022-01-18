<?php


namespace app\api\controller;

use Ehua\Caiji\Selenum;
use Facebook\WebDriver\WebDriverBy;

require "vendor/autoload.php";

class Temp
{

    static function init()
    {
        $data['keyword'] = '破碎锤';//关键词
        $data['url'] = 'lcposuichui.com';//目标站点
        $prox='101.132.227.173:8080';//为空则不使用代理功能


        $url =explode('.',$data['url'])[0];
        $driver = Selenum::init($prox);
        $driver->get('https://www.baidu.com/');
        $driver->findElement(WebDriverBy::xpath('//*[@id="kw"]'))->sendKeys($data['keyword']);
        sleep(3);
        for ($i = 1; $i < 20; $i++) {
            if (Selenum::isset($driver, WebDriverBy::xpath("//*[@id=\"$i\"]"))) {
                $hrml = $driver->findElement( WebDriverBy::xpath("//*[@id=\"$i\"]"))->getAttribute('outerHTML');
                if(preg_match("/$url/",$hrml)){
                    Selenum::click($driver, WebDriverBy::xpath("//*[@id=\"$i\"]"));
                    Selenum::click($driver, WebDriverBy::xpath("//*[@id=\"$i\"]/h3"));
                    Selenum::switchToEndWindow($driver);
                    $driver->close();
                    die;
                }
            }
        }
    }
}

Temp::init();