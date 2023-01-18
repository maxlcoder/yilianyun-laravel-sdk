<?php

namespace Woody\YiLianYun;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Woody\YiLianYun\Enum\ApiEnum;

class Content
{
    public function generateContent($storeName)
    {
        $content = "<FS2><center>--- 本家鲜 ---</center></FS2>"; // 头部
        $content .= str_repeat(' ', 32); // 空行
        $content .= "<FS><center>$storeName</center></FS>"; // 店铺名
        $content .= "\n";
        $content .= "订单编号:40807050607030\n";
        $content .= str_repeat('-', 32);
        $content .= "<table>";
        $content .= "<tr><td>品项</td><td>数量</td><td>单价</td><td>小记</td></tr>";
        $content .= "</table>";
        $content .= str_repeat('-', 32) . "\n";
        $content .= "<table>";
        $content .= "<tr><td>烤土豆烤土烤土豆烤土豆豆(超级辣)</td><td>x3 </td><td>1111.96 </td><td>3333.96</td></tr>";
        $content .= "<tr><td>烤豆烤土豆烤土豆烤土豆烤土豆烤土豆干(超级辣)</td><td>x222 </td><td>2222.96 </td><td>22222.88</td></tr>";
        $content .= "<tr><td>烤鸡翅烤土豆烤土豆(超级辣)</td><td>x32 </td><td>52.96 </td><td>137.96</td></tr>";
        $content .= "<tr><td>烤排骨(香辣)</td><td>x33 </td><td>521.96 </td><td>12.44</td></tr>";
        $content .= "<tr><td>烤韭菜(超级辣)</td><td>x33 </td><td>521.96 </td><td>128.96</td></tr>";
        $content .= "<tr><td>烤韭菜(超级辣)</td><td>x33 </td><td>51.96 </td><td>128.96</td></tr>";
        $content .= "<tr><td>烤韭菜(超级辣)</td><td>x33 </td><td>51.96 </td><td>28.96</td></tr>";
        $content .= "<tr><td>烤豆烤土豆烤土豆烤土豆烤土豆烤土豆干(超级辣)</td><td>x33 </td><td>51.96 </td><td>28.96</td></tr>";
        $content .= "</table>";
        $content .= str_repeat('-', 32);
        $content .= "<FS><table>";
        $content .= "<tr><td>实付：</td><td>￥50000.01</td></tr>";
        $content .= "</table></FS>";
        $content .= str_repeat('-', 32) . "\n";
        $content .= "<FS>地址：浙江省杭州市滨江区长河街道寰诺大厦xxx层xxx号(xxx部门xxx代收)</FS>" . "\n";
        $content .= "\n";
        $content .= "<FS>收货人：待签收</FS>" . "\n";
        $content .= "<FS>电话：188xxxx9998</FS>" . "\n";
        $content .= "\n"; // 结尾空行
        $content .= "\n";
        $content .= "\n";

        return $content;

    }
}
