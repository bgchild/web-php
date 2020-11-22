<?php

/**
 * Created by PhpStorm.
 * User: Ann
 * Date: 2015/12/23
 * Time: 10:23
 */
class word
{
    function start()
    {
        ob_start();
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
        xmlns:w="urn:schemas-microsoft-com:office:word"
        xmlns="http://www.w3.org/TR/REC-html40">';
    }
    function save($path)
    {
        echo "</html>";
        $data = ob_get_contents();
        ob_end_clean();
        $this->downdoc($path,$data);
    }

    function wirtefile ($fn,$data)
    {
        $fp=fopen($fn,"wb");
        fwrite($fp,$data);
        fclose($fp);
    }
    function downdoc($fn,$data){
        header("Content-Type: application/doc");
        header("Content-Disposition: attachment; filename=" . $fn . ".doc");
        echo $data;
    }

    /**
     * @param $data
     * @return string
     * $data['name'] 志愿者姓名
     * $data['bh'] 志愿者编号
     * $data['idtype'] 身份证件类型
     * $data['idno'] 证件号码
     * $data['fwtime'] 志愿服务时间
     * $data['fwcon'] 志愿服务内容
     */
    function wordtpl($data){
$logosrc=$_SERVER['HTTP_HOST'].'/include/word/mblogo.png';
$html='<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<xml><w:WordDocument><w:View>Print</w:View></xml><style type="text/css">
*{paddin:0px; margin:0px;}
body, td { font-size: 12.0pt; font-family: 宋体; text-align: center }
table { width: 600px; margin: 0 auto }
.yw { font-family: Times New Roman; }
</style>
<table border="0">
  <tr>
    <td style="text-align: right;"><img src="http://'.$logosrc.'" width="88" height="88"/>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td><b style="font-size:24.0pt;">志愿服务记录证明</b></td>
  </tr>
  <tr>
    <td><font class="yw" style="font-size:15.0pt;">（Certificate of Voluntary Service ）</font></td>
  </tr>
  <tr>
    <td style="text-align:right"><font class="yw">编号（No.）：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
  </tr>
</table>
<table style="border-collapse:collapse;border:none;" border="1" cellpadding="0" cellspacing="0">
  <tbody>
    <tr height="60">
      <td rowspan="3"  width="21%">志愿者信息<font class="yw" >（Information of Volunteer）</font></td>
      <td width="20%">姓  名<br/>
        <font class="yw">（Name）</font></td>
      <td colspan="3"  width="59%">'.$data['name'].'</td>
    </tr>
    <tr  height="60">
      <td  width="20%">志愿者编号<br />
        <font class="yw">（Volunteer&nbsp;No.）</font></td>
      <td colspan="3"  width="59%">'.$data['bh'].'</td>
    </tr>
    <tr height="60">
      <td  width="20%">身份证件类型<br />
        <font class="yw">（Type of ID）</font></td>
      <td  width="15%">'.$data['idtype'].'</td>
      <td  width="15%">证件号码<br />
        <font class="yw">（ID No.）</font></td>
      <td  width="26%">'.$data['idno'].'</td>
    </tr>
    <tr height="75">
      <td  width="21%">志愿服务时间<font class="yw">（Volunteer Service Time）</font></td>
      <td colspan="4"  width="79%">'.$data['fwtime'].'</td>
    </tr>
    <tr height="75">
      <td  width="21%">志愿服务内容<font class="yw">（Volunteer  Service Content）</font></td>
      <td colspan="4"  width="79%">'.$data['fwcon'].'</td>
    </tr>
    <tr  height="130">
      <td  width="21%">其他需要说明的事项<font class="yw">（Other Information）</font></td>
      <td colspan="4"  valign="bottom" width="79%">
      <p style="float:left; text-align:left; text-indent:2%">是否有附件？&nbsp;&nbsp;&nbsp;&nbsp;是□&nbsp;&nbsp;&nbsp;&nbsp;否□<br/><font class="yw">（With Attachment or Not?&nbsp;&nbsp;&nbsp;&nbsp;Yes</font>□&nbsp;&nbsp;&nbsp;&nbsp;<font class="yw">No</font>□）</p>
</td>
</tr>
    <tr height="135"><td colspan="5"  valign="bottom" width="100%">
    <p style="text-align:right;">（公章<font class="yw">Seal</font>）&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p style="text-align:right">年&nbsp;&nbsp;&nbsp; 月&nbsp;&nbsp;&nbsp; 日&nbsp;&nbsp;&nbsp; </p></td>
    </tr>
  </tbody>
</table>
<table border="0">
  <tr>
    <td style="text-align:left"><b>注</b>：其他需要说明的事项可填写志愿者参加的志愿服务活动、相关培训及获得表彰奖励等信息。</td>
  </tr>
<tr><td>&nbsp;</td></tr>
  <tr>
    <td style="text-align:left">经办人（Handled by）：<u><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></u></td>
  </tr>
  <tr>
    <td style="text-align:left">联系电话（Contact Phone Number）：<u><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></u></td>
  </tr>
</table>';
        return $html;
    }
}
?>