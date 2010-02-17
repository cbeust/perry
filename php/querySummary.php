<?

include_once "_common.php";
$title = "Look up a Perry Rhodan issue";
cbHeader($title, $title, false);

?>


<h4>This page allows you to look up a Perry Rhodan issue and see
if it has a summary.  If it doesn't, you will have the opportunity
to enter one yourself.
</h4>


<table width="100%">

<tr align="center">

<td>

Enter the number of the issue:

</td>

</tr>
<tr align="center">

<td>

<form action="

<?
echo $EDIT_SUMMARY_URL
?>
" method="get" > <input type="text" name="heft"> </input>

</td>
</tr>
<tr align="center">

<td>

<INPUT TYPE=SUBMIT VALUE="Submit"> 
</td>

</table>


</form>

</body>
</html>
