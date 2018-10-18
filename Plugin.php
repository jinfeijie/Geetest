<?php

/**
 * 这是极验证的插件
 *
 * @package 极验证 For Typecho
 * @author mrjin
 * @version 1.0.3
 * @link https://jinfeijie.cn
 */
class Geetest_Plugin implements Typecho_Plugin_Interface{

    /* 激活插件方法 */
    public static function activate(){
        //  需要添加一个css的文件来控制极验证的样式
        // 头部输出一个css
        Typecho_Plugin::factory('Widget_Archive')->header = array('Geetest_Plugin', 'header');

        // 添加极验证的js
        // 底部输出js
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Geetest_Plugin', 'footer');
        return _t('插件已启用');
    }

    /* 禁用插件方法 */
    public static function deactivate(){
        return _t('插件已禁用');
    }

    /* 插件配置方法 */
    public static function config(Typecho_Widget_Helper_Form $form){
        /** 配置参数 */
        $CAPTCHA_ID = new Typecho_Widget_Helper_Form_Element_Text('CAPTCHA_ID', NULL, '', _t('CAPTCHA_ID  <a style="color: #E47E00;font-size: small;" href="https://jinfeijie.cn/post-183.html">点击查看如何获取CAPTCHA_ID</a>').$path);
        $PRIVATE_KEY = new Typecho_Widget_Helper_Form_Element_Text('PRIVATE_KEY', NULL, '', _t('PRIVATE_KEY  <a style="color: #E47E00;font-size: small;" href="https://jinfeijie.cn/post-183.html">点击查看如何获取PRIVATE_KEY</a>'));
        $option = Typecho_Widget::widget('Widget_Options')->plugin('Geetest');
        $data = json_encode(array('CAPTCHA_ID' => $option->CAPTCHA_ID, 'PRIVATE_KEY' => $option->PRIVATE_KEY));
        file_put_contents(dirname(__FILE__).'/'.md5($option->CAPTCHA_ID), $data);
        $form->addInput($CAPTCHA_ID);
        $form->addInput($PRIVATE_KEY);
    }

    /* 个人用户的配置方法 */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /* 头部插入css */
    public static function header(){
        $button_style = "<link rel=\"stylesheet\" href=\"https://olxjblx91.qnssl.com/buttons.css\">";
        $geeTest_style = "
<style>
        .inp {
            border: 1px solid gray;
            padding: 0 10px;
            width: 200px;
            height: 30px;
            font-size: 18px;
        }
        #embed-captcha {
            width: 300px;
            margin: 0 auto;
        }
        .show {
            display: block;
        }
        .hide {
            display: none;
        }
        #notice {
            color: red;
            line-height: 42px;
        }
        .gt_btn {
            display: block;
        }
        .button_input{
            display: block;
        }
</style>
";
        echo $button_style.$geeTest_style;
    }

    /*  尾部加入js */
    public static function footer(){
        $option = Typecho_Widget::widget('Widget_Options')->plugin('Geetest');
        $out_js = "<script src=\"//cdn.staticfile.org/jquery/1.9.1/jquery.min.js\"></script>
<script src=\"//static.geetest.com/static/tools/gt.js\"></script>";
        $geeTest_js = "
<script>
    var form = document.getElementById('comment-form');
    if(form){
        var handlerEmbed = function (captchaObj) {
            $(\"#embed-submit\").click(function (e) {
                var validate = captchaObj.getValidate();
                if (!validate) {
                    $(\"#notice\")[0].className = \"show\";
                    setTimeout(function () {
                        $(\"#notice\")[0].className = \"hide\";
                    }, 2000);
                    e.preventDefault();
                }
            });
            // 将验证码加到id为captcha的元素里，同时会有三个input的值：geetest_challenge, geetest_validate, geetest_seccode
            captchaObj.appendTo(\"#embed-captcha\");
            captchaObj.onReady(function () {
                $(\"#wait\")[0].className = \"hide\";
            });
            // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
        };
        $.ajax({
            // 获取id，challenge，success（是否启用failback）
            url: \"/usr/plugins/Geetest/Geetest.php?gt=".$option->CAPTCHA_ID."&t=\" + (new Date()).getTime(), // 加随机数防止缓存
            type: \"get\",
            dataType: \"json\",
            success: function (data) {
                //console.log(data);
                // 使用initGeetest接口
                // 参数1：配置参数
                // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
                initGeetest({
                    gt: data.gt,
                    challenge: data.challenge,
                    new_captcha: data.new_captcha,
                    product: \"embed\", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                    offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                    // 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
                }, handlerEmbed);
            }
        });
        // 插件作者用于统计插件使用次数，为推动作者更新插件，请勿删除以下代码
        // window.onload = function(){
        //   $.ajax({url:'https://jinfeijie.cn/counts.php?action=add'});
        // }
    }
</script>
";
        @$wu = Typecho_Widget::widget('Widget_User');
        if($wu->hasLogin()){
            $hide_old_comments = "<script>var form = document.getElementById('comment-form');
    if(form){var form = document.getElementById('comment-form');var p = form.getElementsByTagName('p');p[2].innerHTML = '".self::GeeButton()."';}</script>";
        }else{
            $hide_old_comments = "<script>var form = document.getElementById('comment-form');
    if(form){var form = document.getElementById('comment-form');var p = form.getElementsByTagName('p');p[4].innerHTML = '".self::GeeButton()."';}</script>";
        }
        echo $out_js.$geeTest_js.$hide_old_comments;
    }

    private static function GeeButton(){
        $GeeButton = "<center><div id=\"embed-captcha\" class=\"gt_btn\"></div><span id=\"wait\" class=\"show\">正在加载验证码......</span></center><center><input class=\"button button-block button-rounded button-large button_input\" id=\"embed-submit\" type=\"submit\" value=\"提交\"></center><center><span id=\"notice\" class=\"hide\">请先完成验证</span></center>	";
        return $GeeButton;
    }
}
