<?php session_start();
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";
ini_set( 'display_errors', '0' );

$optionCnt = $_POST['optionCnt'];

for($i=0;$i<$optionCnt;$i++){
    $html .= "<tr>
            <th scope=\"row\">".($i+1)."</th>
            <td>
                <select name=\"optionType[".$i."]\" id=\"optionType[".$i."]\" style=\"width:200px;\" class=\"form-select form-select-sm\" aria-label=\".form-select-sm example\">
                    <option value=0>선택</option>
                    <option value=\"color\">컬러</option>
                    <option value=\"size\">사이즈</option>
                    <option value=\"material\">재질</option>
                </select>
            </td>
            <td></td>
            <td></td>
            </tr>";
}

echo $html;

?>
		